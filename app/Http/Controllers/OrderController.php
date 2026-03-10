<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Torann\GeoIP\Facades\GeoIP;

class OrderController extends Controller
{


    private function getCurrencyData()
    {
        $currency = session('user_currency');
        
        if (!$currency) {
            $ip = request()->getClientIp();
            ($ip);
            $location = GeoIP::get($ip == '127.0.0.1' ? '103.255.4.42' : $ip);
            $currency = $location ? (($location->countryCode == 'PK') ? 'PKR' : (($location->countryCode == 'IN') ? 'INR' : 'USD')) : 'INR';
            session(['user_currency' => $currency]);
             
        }


        $rates = Cache::remember('currency_rates', 86400, function() {
            $apiKey = '68c48409403666f28646b97b'; 
            try {
                $response = Http::get("https://v6.exchangerate-api.com/v6/{$apiKey}/latest/INR");
                return $response->json()['conversion_rates'] ?? ['INR' => 1, 'PKR' => 3.30, 'USD' => 0.012];
            } catch (\Exception $e) {
                return ['INR' => 1, 'PKR' => 3.30, 'USD' => 0.012];
            }
        });

        return [
            'currency' => $currency,
            'currentRate' => $rates[$currency] ?? 1
        ];
    }

    public function myorder(Request $request)
    {
        ($request->getClientIp());
        $currencyData = $this->getCurrencyData(); // Fetch currency info

        $orders = Order::where('user_id', auth()->id())
                        ->with('orderItems') 
                        ->latest()
                        ->get();
                        
        // Merge currency data with orders and send to view
        return view('myorder', array_merge($currencyData, compact('orders')));
    }

    public function getDetails($id)
    {
        try {
            $order = Order::where('user_id', auth()->id())
                            ->with('orderItems')
                            ->findOrFail($id);

            // Note: Return RAW numbers here so your JS 'formatVal' function can convert them
            $items = $order->orderItems->map(function($item) {
                return [
                    'product_name' => $item->product_name ?? 'Product Name', 
                    'price' => $item->price, // Don't format here, let JS handle it
                    'quantity' => $item->quantity,
                    'subtotal' => $item->price * $item->quantity
                ];
            });

            return response()->json([
                'success' => true,
                'items' => $items,
                'total' => $order->total_amount // Raw total for JS conversion
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found or access denied.'
            ], 404);
        }
    }
}