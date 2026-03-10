<?php

namespace App\Http\Middleware;

use Closure;
use Stevebauman\Location\Facades\Location;

class CountryCurrencyMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!session()->has('currency'))
        {
$ip='3e5acfc64493b98c3610414274ecc216';
           
          $ip = $request->ip();

            $position = Location::get($ip);

            $currency = "USD";

            if ($position)
            {

                $country = $position->countryCode;

                $currency = match($country)
                {

                    "PK" => "PKR",   
                    "US" => "USD",   
                    "GB" => "GBP",   
                    "AE" => "AED",   
                    "SA" => "SAR",  

                    default => "USD"
                };
            }

            session(['currency' => $currency]);
        }

        return $next($request);
    }
}