    <style>
        /* Same Multi-Color Changing Background */
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

        /* Glassy Card for Registration */
        .register-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            padding: 40px;
            border-radius: 30px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 450px;
            border: 1px solid rgba(255, 255, 255, 0.4);
            transition: all 0.4s ease;
            margin: 20px;
        }

        .register-card:hover {
            transform: scale(1.01);
        }

        .register-title {
            background: linear-gradient(to right, #e73c7e, #23a6d5);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 30px;
            font-weight: 800;
            text-align: center;
            margin-bottom: 5px;
        }

        .register-subtitle {
            color: #666;
            text-align: center;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .custom-input {
            width: 100%;
            padding: 12px 18px;
            border: 2px solid transparent;
            border-radius: 15px;
            background: #f0f2f5;
            transition: all 0.3s ease;
            outline: none;
            font-size: 14px;
            color: #333;
        }

        .custom-input:focus {
            background: #fff;
            border-color: #e73c7e;
            box-shadow: 0 0 15px rgba(231, 60, 126, 0.2);
        }

        .btn-submit {
            background: linear-gradient(to right, #23a6d5, #23d5ab);
            color: white;
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 15px;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.4s ease;
            margin-top: 15px;
            box-shadow: 0 10px 20px rgba(35, 166, 213, 0.3);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-submit:hover {
            box-shadow: 0 15px 30px rgba(35, 166, 213, 0.5);
            transform: translateY(-3px);
            filter: brightness(1.1);
        }

        .label-text {
            font-weight: 700;
            color: #444;
            font-size: 11px;
            display: block;
            margin-bottom: 6px;
            text-transform: uppercase;
        }

        .footer-link {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
        }

        .footer-link a {
            color: #23a6d5;
            text-decoration: none;
            font-weight: 800;
        }
    </style>

    <div class="register-card">
        <h2 class="register-title">Create Account</h2>
        <p class="register-subtitle">Join us and start shopping!</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div style="margin-bottom: 15px;">
                <label class="label-text">Full Name</label>
                <input type="text" name="name" class="custom-input" placeholder="Your Name" value="{{ old('name') }}" required autofocus>
                <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs" />
            </div>

            <div style="margin-bottom: 15px;">
                <label class="label-text">Email Address</label>
                <input type="email" name="email" class="custom-input" placeholder="mail@example.com" value="{{ old('email') }}" required>
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs" />
            </div>

            <div style="margin-bottom: 15px;">
                <label class="label-text">Password</label>
                <input type="password" name="password" class="custom-input" placeholder="••••••••" required>
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs" />
            </div>

            <div style="margin-bottom: 20px;">
                <label class="label-text">Confirm Password</label>
                <input type="password" name="password_confirmation" class="custom-input" placeholder="••••••••" required>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs" />
            </div>

            <button type="submit" class="btn-submit">
                REGISTER <i class="fas fa-user-plus ms-2"></i>
            </button>

            <div class="footer-link">
                <span style="color: #666;">Already a member?</span> 
                <a href="{{ route('login') }}">SIGN IN</a>
            </div>
        </form>
    </div>
