<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\productController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ContactUsController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::middleware(['currency'])->group(function () {

    Route::get('/', function () {
        return view('welcome');
    });


Route::get('/', function () {
    return view('welcome');
});

// Currency routes
Route::post('/set-currency', function (Request $request) {
    session(['user_currency' => $request->currency]);
    return back();
})->name('set.currency');


Route::get('/test-currency/{currency}', function ($currency) {
    session(['user_currency' => $currency]);
    return redirect()->back()->with('success', "Currency set to {$currency}");
});

// Check IP location
Route::get('/check-location', function () {
    $ip = request()->ip();
    
    if ($ip == '127.0.0.1' || $ip == '::1') {
        try {
            $ip = Http::get('https://api.ipify.org')->body();
        } catch (\Exception $e) {
            $ip = '8.8.8.8';
        }
    }
    
    try {
$ip='3e5acfc64493b98c3610414274ecc216';
        $response = Http::timeout(300)->get("https://ipapi.co/{$ip}/json/");
        $data = $response->json();
        
        $currencyMap = [
            'PK' => 'PKR', 'IN' => 'INR', 'US' => 'USD', 'GB' => 'GBP',
            'AE' => 'AED', 'SA' => 'SAR', 'CA' => 'CAD', 'AU' => 'AUD'
        ];
        
        $detectedCurrency = $currencyMap[$data['country_code'] ?? 'US'] ?? 'USD';
   
        
        return response()->json([
            'ip' => $ip,
            'country' => $data['country_name'] ?? 'Unknown',
            'country_code' => $data['country_code'] ?? 'US',
            'detected_currency' => $detectedCurrency,
            'session_currency' => session('user_currency')
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()]);
    }

    Route::get('/check-location', [productController::class, 'dd']);
});


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admindashboard');
    Route::get('adduser', [AdminController::class, 'create'])->name('adduser'); 
    Route::post('/admin/products/store', [AdminController::class, 'store'])->name('admin.products.store');
    Route::get('/admin/products/{id}/edit', [AdminController::class, 'edit'])->name('admin.products.edit');
    Route::put('/admin/products/{id}', [AdminController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{id}', [AdminController::class, 'destroy'])->name('admin.products.delete');

    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});

Route::middleware(['auth', 'verified'])->group(function () 
{
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    })->name('logout');


    Route::get('/dashboard', [productController::class, 'index'])->name('dashboard');
    Route::get('/product', [productController::class, 'product'])->name('product');
    Route::get('/aboutus', [productController::class, 'aboutus'])->name('aboutus');
    Route::get('/learnmore', [productController::class, 'learnmore'])->name('learnmore');
    Route::get('/contactus', [productController::class, 'contactus'])->name('contactus');
    Route::get('newarival',[productController::class,'newarival']);
    Route::get('product',[productController::class, 'search'])->name('product');
    Route::post('contactus',[ContactUsController::class, 'contactusstore'])->name('contactusstore');

    Route::get('myorder',[OrderController::class,'myorder'])->name('myorder');
    Route::get('/order-details/{id}', [OrderController::class, 'getDetails']);

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');

    Route::get('/checkout', [PaymentController::class,'checkout'])->name('checkout.page');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/charge', [PaymentController::class,'charge'])->name('charge');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

});
require __DIR__.'/auth.php';
