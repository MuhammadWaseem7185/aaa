
    <style>
        /* Multi-Color Changing Animated Background */
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Glassy Stylish Card */
        .login-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            padding: 50px 40px;
            border-radius: 30px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 420px;
            border: 1px solid rgba(255, 255, 255, 0.4);
            position: relative;
            transition: all 0.4s ease;
        }

        .login-card:hover {
            transform: scale(1.02);
            box-shadow: 0 35px 60px rgba(0, 0, 0, 0.3);
        }

        .login-title {
            background: linear-gradient(to right, #e73c7e, #23a6d5);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 32px;
            font-weight: 800;
            text-align: center;
            margin-bottom: 5px;
        }

        .login-subtitle {
            color: #666;
            text-align: center;
            font-size: 14px;
            margin-bottom: 35px;
        }

        /* Inputs that change on focus */
        .custom-input {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid transparent;
            border-radius: 15px;
            background: #f0f2f5;
            transition: all 0.3s ease;
            outline: none;
            font-size: 15px;
            color: #333;
        }

        .custom-input:focus {
            background: #fff;
            border-color: #23a6d5;
            box-shadow: 0 0 15px rgba(35, 166, 213, 0.2);
        }

        /* Gradient Button with Glow */
        .btn-submit {
            background: linear-gradient(to right, #e73c7e, #ee7752);
            color: white;
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 15px;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.4s ease;
            margin-top: 15px;
            box-shadow: 0 10px 20px rgba(231, 60, 126, 0.3);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-submit:hover {
            box-shadow: 0 15px 30px rgba(231, 60, 126, 0.5);
            transform: translateY(-3px);
            filter: brightness(1.1);
        }

        .links-area {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #555;
        }

        .links-area a {
            color: #e73c7e;
            text-decoration: none;
            font-weight: 800;
        }

        .links-area a:hover {
            text-decoration: underline;
        }
    </style>

    <div class="login-card">
        <h2 class="login-title">Welcome Back</h2>
        <p class="login-subtitle">Aapka account intezar kar raha hai!</p>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div style="margin-bottom: 20px;">
                <label style="font-weight: 700; color: #444; font-size: 12px; display: block; margin-bottom: 8px;">EMAIL ADDRESS</label>
                <input type="email" name="email" class="custom-input" placeholder="mail@example.com" value="{{ old('email') }}" required autofocus>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs" />
            </div>

            <div style="margin-bottom: 20px;">
                <label style="font-weight: 700; color: #444; font-size: 12px; display: block; margin-bottom: 8px;">PASSWORD</label>
                <input type="password" name="password" class="custom-input" placeholder="••••••••" required>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs" />
            </div>

            <div class="flex items-center justify-between mb-6">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-pink-600 focus:ring-pink-500">
                    <span class="ms-2 text-xs text-gray-600">Remember Me</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs font-bold" style="color: #23a6d5;">
                        Forgot?
                    </a>
                @endif
            </div>

            <button type="submit" class="btn-submit">
                LOGIN <i class="fas fa-arrow-right ms-2"></i>
            </button>

            <div class="links-area">
                Account nahi hai? <a href="{{ route('register') }}">REGISTER NOW</a>
            </div>
        </form>
    </div>
