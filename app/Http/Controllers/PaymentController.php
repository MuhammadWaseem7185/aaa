<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{




    public function checkout()
    {
        $cartProducts = session('cart', []);

        if(empty($cartProducts)){
            return redirect('/cart')->with('error','Your cart is empty.');
        }

        $products = Product::whereIn('id', array_keys($cartProducts))->get();

        $total = 0;
        $cartItems = [];
        foreach($products as $product){
            $quantity = $cartProducts[$product->id]['quantity'] ?? 1;
            $price = is_array($product->price) ? ($product->price['amount'] ?? 0) : $product->price;
            $total += floatval($price) * intval($quantity);
            
            $cartItems[] = [
                'name' => $product->name,
                'quantity' => $quantity,
                'price' => $price,
                'image' => $product->image
            ];
        }

        return view('checkout', [
            'total' => $total,
            'currency' => 'USD',
            'cartItems' => $cartItems
        ]);
    }

    public function charge(Request $request)
    {
        $request->validate([
            'payment_method' => 'required',
            'amount' => 'required|numeric'
        ]);

        Stripe::setApiKey('sk_test_51T1ZAe5sDRiS3mQ530inEuwyd7vpNquGG7M6z3vJpti3g3D3SunjnuvHmQiFJesG0QfAzg1asic8CaiF80NvYD6Y00A9FWbTc0');

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => intval($request->amount),
                'currency' => 'usd',
                'payment_method' => $request->payment_method,
                'confirm' => true,
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never'
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }

        $cart = session()->get('cart', []);
        
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => $request->amount / 100,
            'payment_method' => 'stripe',
            'status' => 'paid',
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
        session()->flash('success', '✅ Payment successful! Order ID: #' . $order->id);

        return response()->json(['success' => true, 'order_id' => $order->id]);
    }
}