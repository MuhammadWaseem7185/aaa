<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CartController extends Controller
{

   private function getCurrencyData()
{
    $currency = session('user_currency');

    if ($currency) {
        $ip = request()->ip();
        $location = Location::get($ip == '127.0.0.1' ? '103.255.4.42' : $ip);
        $currency = $location ? match($location->countryCode) {
            'PK' => 'PKR',
            'IN' => 'INR',
            'US' => 'USD',
            'EU' => 'EUR',
            default => 'USD'
        } : 'USD';
        session(['user_currency' => $currency]);
    }

    $rates = Cache::remember('currency_rates', 86400, function() {
        $apiKey = '3f22522cdccf35a84e0cd612862bc7d1';
        try {
            $response = Http::get("https://v6.exchangerate-api.com/v6/{$apiKey}/latest/USD");
            return $response->json()['conversion_rates'] ?? ['USD'=>1,'PKR'=>285,'INR'=>83,'EUR'=>0.92];
        } catch (\Exception $e) {
            return ['USD'=>1,'PKR'=>285,'INR'=>83,'EUR'=>0.92];
        }
    });

    return [
        'currency' => $currency,
        'currentRate' => $rates[$currency] ?? 1,
        'currencySymbol' => match($currency) {
            'PKR' => 'Rs ', 'INR' => '₹ ', 'USD' => '$ ', 'EUR' => '€ ', default => '$ '
        }
    ];
}



    public function index()
    {
        $currencyData = $this->getCurrencyData();
        $cart = session()->get('cart', []);

        return view('cart', array_merge($currencyData, compact('cart')));
    }

    public function add($id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Item added to cart!',
            'cart_count' => count($cart)
        ]);
    }


    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            if ($request->action == 'increase') {
                $cart[$id]['quantity']++;
            } elseif ($request->action == 'decrease' && $cart[$id]['quantity'] > 1) {
                $cart[$id]['quantity']--;
            }

            session()->put('cart', $cart);
        }

        $grandTotalRaw = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        return response()->json([
            'success' => true,
            'item_qty' => $cart[$id]['quantity'],
            'item_subtotal_raw' => $cart[$id]['price'] * $cart[$id]['quantity'],
            'grand_total_raw' => $grandTotalRaw
        ]);
    }

    /* ============================
       Remove Item
    ============================ */

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        $grandTotalRaw = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        return response()->json([
            'success' => true,
            'grand_total_raw' => $grandTotalRaw,
            'cart_empty' => count($cart) == 0
        ]);
    }

   

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Cart is empty']);
            }
            return redirect()->back()->with('error', 'Your cart is empty!');
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => array_sum(array_map(function ($item) {
                return $item['price'] * $item['quantity'];
            }, $cart)),
            'payment_method' => $request->input('payment_method', 'cod'),
            'status' => 'pending',
        ]);

        foreach ($cart as $details) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_name' => $details['name'],
                'quantity' => $details['quantity'],
                'price' => $details['price']
            ]);
        }

        session()->forget('cart');
        session()->flash('success', '✅ Order placed successfully! Order ID: #' . $order->id);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'order_id' => $order->id]);
        }

        return redirect()
            ->route('dashboard')
            ->with('success', '✅ Order placed successfully! Order ID: #' . $order->id);
    }
}