<?php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Order;

Schedule::call(function () {

    User::create([
        'name' => 'waseem',
        'email' => 'waseem' . time() . '@example.com',
        'password' => bcrypt('123456')
    ]);

})->everyTenSeconds();

Schedule::call(function () {

    Order::where('status', 'pending')
        ->delete();

})->everyTenSeconds();

Schedule::call(function () {

    Order::where('status', 'cancelled')
        ->delete();

})->everyTenSeconds();