<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
    public function dashboard()
    {
        $currency = session('user_currency');
        if (!$currency) {
            $ip = request()->ip();
            $location = Location::get($ip == '127.0.0.1' ? '103.255.4.42' : $ip);
            $currency = $location ? ($location->countryCode == 'PK' ? 'PKR' : ($location->countryCode == 'US' ? 'USD' : 'INR')) : 'INR';
            session(['user_currency' => $currency]);
        }

        $rates = Cache::remember('currency_rates', 86400, function() {
            $apiKey = '68c48409403666f28646b97b'; 
            try {
                $response = Http::get("https://v6.exchangerate-api.com/v6/{$apiKey}/latest/INR");
                return $response->json()['conversion_rates'];
            } catch (\Exception $e) {
                return ['INR' => 1, 'PKR' => 3.30, 'USD' => 0.012];
            }
        });

        $currentRate = $rates[$currency] ?? 1;

        $orders = Order::all();
        $products = Product::latest()->get(); 
        $users = User::all();

        return view('admindashboard', compact('products', 'users', 'orders', 'currency', 'currentRate'));
    }

    public function store(Request $request) 
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('products'), $imageName);
            $data['image'] = $imageName;
        }

        Product::create($data);
        return redirect()->route('admindashboard')->with('success', 'Product added successfully!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('updateproduct', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('products'), $imageName);
            $product->image = $imageName;
        }

        $product->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true, 
                'message' => 'Product updated successfully!',
            ]);
        }

        return redirect()->route('admindashboard');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Product deleted!');
    }

    public function create()
    {
        return view('adduser');                                     
    }                                                                                     
}