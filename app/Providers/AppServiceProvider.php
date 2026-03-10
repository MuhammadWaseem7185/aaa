<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {

            // 1️⃣ Get currency from session
            $currency = session('user_currency');

            if (!$currency) {

                // 2️⃣ REAL visitor IP
                $ip = request()->ip();

                // Localhost ONLY for testing
                if ($ip === '127.0.0.1' || $ip === '::1') {
                    $ip = '119.73.110.186'; // Pakistan test IP
                }

                // 3️⃣ Cache currency per IP (24 hours)
                $currency = Cache::remember("currency_{$ip}", 86400, function () use ($ip) {

                    try {
                        $ip='3e5acfc64493b98c3610414274ecc216';
                        $response = Http::timeout(60)
                            ->get("https://ipapi.co/{$ip}/json/");

                        if ($response->successful()) {
                            return $response->json()['currency'] ?? 'USD';
                        }

                    } catch (\Exception $e) {
                        // fail silently
                    }

                    return 'USD';
                });

                // 4️⃣ Save to session
                session(['user_currency' => $currency]);
            }

            // 5️⃣ Exchange rates (example – static)
            $rates = Cache::remember('currency_rates', 86400, function () {
                return [
                    'USD' => 1,
                    'PKR' => 278,
                    'INR' => 83,
                    'EUR' => 0.92,
                    'GBP' => 0.79,
                    'AED' => 3.67,
                ];
            });

            // 6️⃣ Currency symbols
            $symbols = [
                'USD' => '$',
                'PKR' => 'Rs',
                'INR' => '₹',
                'EUR' => '€',
                'GBP' => '£',
                'AED' => 'د.إ',
            ];

            // 7️⃣ Share with all views
            $view->with([
                'currency'       => $currency,
                'currentRate'    => $rates[$currency] ?? 1,
                'currencySymbol' => $symbols[$currency] ?? '$',
            ]);
        });
    }
}
