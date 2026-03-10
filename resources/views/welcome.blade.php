<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        /* Global Styles */
        body {
            font-family: 'Instrument Sans', sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            background: linear-gradient(-45deg, #4f46e5, #7c3aed, #ec4899, #06b6d4);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Glass Container */
        .welcome-card {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 40px;
            padding: 60px 40px;
            text-align: center;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            max-width: 650px;
            width: 90%;
            color: white;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .welcome-card:hover {
            transform: translateY(-12px);
            background: rgba(255, 255, 255, 0.18);
        }

        /* Logo Animation */
        .logo-box {
            background: white;
            width: 85px;
            height: 85px;
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .logo-box i {
            font-size: 42px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 15px;
            letter-spacing: -2px;
            line-height: 1;
            text-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        p {
            font-size: 1.15rem;
            line-height: 1.6;
            opacity: 0.95;
            margin-bottom: 45px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Buttons Style */
        .nav-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-custom {
            padding: 14px 40px;
            border-radius: 18px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s ease;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 1.5px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary-custom {
            background: white;
            color: #4f46e5;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .btn-outline-custom {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.4);
        }

        .btn-custom:hover {
            transform: scale(1.08);
            box-shadow: 0 20px 30px rgba(0,0,0,0.25);
        }

        .btn-outline-custom:hover {
            background: white;
            color: #7c3aed;
        }

        /* Footer */
        .footer-text {
            position: absolute;
            bottom: 30px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 13px;
            font-weight: 500;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>

    <div class="welcome-card">
        <div class="logo-box">
            <i class="fa-solid fa-bolt-lightning"></i>
        </div>

        <h1>Next-Gen Shopping</h1>
        <p>Elevate your lifestyle with our curated collection of premium products. Quality, speed, and elegance—all in one place.</p>

        <div class="nav-buttons">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-custom btn-primary-custom">
                        Open Dashboard <i class="fa fa-gauge-high ms-2"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-custom btn-primary-custom">
                        login  <i class="fa fa-arrow-right ms-2"></i>
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-custom btn-outline-custom">
                          REGISTER
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </div>

    <div class="footer-text">
        &copy; {{ date('Y') }} {{ config('app.name') }}. Crafted with Excellence.
    </div>

</body>
</html>

