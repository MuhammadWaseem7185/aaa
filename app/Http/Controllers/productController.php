<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class ProductController extends Controller
{
    // Dashboard
    public function index()
    {
        $products = Product::all();
        $orders = Order::all();

        // Get currency and rate from session
        $currency = session('user_currency', 'USD');
        $currentRate = session('current_rate', 1); // fallback
        $currencySymbol = session('currency_symbol', '$');

        return view('dashboard', compact('products', 'orders', 'currency', 'currentRate', 'currencySymbol'));
    }

    public function learnmore() {
    return view('learnmore');
    }

    // Products page
    public function product()
    {
        $products = Product::all();

        // Currency variables
        $currency = session('user_currency', 'USD');
        $currentRate = session('current_rate', 1);
        $currencySymbol = session('currency_symbol', '$');

        return view('product', compact('products', 'currency', 'currentRate', 'currencySymbol'));
    }

    public function aboutus() { return view('aboutus'); }
    public function contactus() { return view('contactus'); }
    public function adduser() { return view('adduser'); }   
    public function newarival() { return view('newarival'); }
    


    // Debug IP
    public function dd()
    {
        dd(request()->ip());
    }
    public function search(Request $request)
    {
        $search = $request->input('search');

        $products = Product::where('name', 'LIKE', "%$search%")
                            ->orWhere('description', 'LIKE', "%$search%")
                            ->orWhere('price', 'LIKE', "%$search%")
                            ->get();
        

        // Currency variables
        $currency = session('user_currency', 'USD');
        $currentRate = session('current_rate', 1);
        $currencySymbol = session('currency_symbol', '$');

        return view('product', compact('products', 'search', 'currency', 'currentRate', 'currencySymbol'));
    }
}
