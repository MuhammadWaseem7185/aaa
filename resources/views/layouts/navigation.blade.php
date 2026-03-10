<div class="container" >
<nav x-data="{ open: false }" class="premium-nav" style="border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 1px solid #eee;" >
    <style>
        .premium-nav {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.95), rgba(124, 58, 237, 0.95)) !important;
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2) !important;
            position: sticky;
            top: 0;
            z-index: 1050;
        }

        .nav-link-custom {
            color: rgba(255, 255, 255, 0.8) !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            padding: 0 15px;
            height: 100%;
            border-bottom: 3px solid transparent;
            text-decoration: none !important;
            display: inline-flex;
            align-items: center;
        }

        .nav-link-custom:hover, .active-link {
            color: #ffffff !important;
            border-bottom: 3px solid #f472b6; /* High-end Pink accent */
            background: rgba(255, 255, 255, 0.1);
        }

        .user-dropdown-btn {
            background: rgba(19, 10, 10, 0.84) !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            color: white !important;
            border-radius: 12px !important;
            padding: 8px 18px !important;
            font-weight: 600 !important;
            transition: 0.3s ease;
        }
        .dropdown-glass {
    position: relative;
    z-index: 2000;
}

.premium-nav {
    position: sticky;
    top: 0;
    z-index: 1050;
    overflow: visible !important;
}

        .user-dropdown-btn:hover {
            border-color: #f472b6 !important;
            background: #000 !important;
        }

        .dropdown-glass {
            background: #ffffff !important;
            border-radius: 15px !important;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2) !important;
            padding: 8px;
            border: none !important;
        }

        .dropdown-item-style {
            color: #4b5563 !important;
            padding: 10px 15px !important;
            border-radius: 10px;
            font-weight: 500;
            transition: 0.2s;
        }

        .dropdown-item-style:hover {
            background-color: #f3f4f6 !important;
            color: #f16179 !important;
        }

        /* Fix for the red logo text */
        .logo-text {
            color: #ffffff !important;
            text-shadow: 0 0 10px rgba(255,255,255,0.3);
        }
    </style>
<div>
    <div class=" max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="no-underline hover:scale-105 transition-transform">
                        <h2 class="logo-text font-bold text-xl tracking-tighter mb-0">ONLINE SHOP</h2>  
                    </a>
                </div>

                <div class="hidden space-x-2 sm:-my-px sm:ms-10 sm:flex h-full">
                    <a href="{{ route('product') }}" class="nav-link-custom {{ request()->routeIs('product') ? 'active-link' : '' }}">
                        <i class="fa fa-th-large me-2"></i>ALL PRODUCTS
                    </a>
                    <a href="#newarrivals-section" class="nav-link-custom">New Arrivals</a>
                    <a href="#about-section" class="nav-link-custom">About Us</a>
                    <a href="#contact-section" class="nav-link-custom">Contact Us</a>
                </div>
                             <form action="{{ route('product') }}" method="GET" class="flex items-center">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="border rounded px-2 py-1">
    <button type="submit" class="ms-2"><i class="fa fa-search"></i></button>
</form>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-3">
                
                <form method="POST" action="{{ route('set.currency') }}" id="currency-form" class="mb-0">
                    @csrf
                    <select name="currency" onchange="this.form.submit()" class="user-dropdown-btn" style="cursor: pointer; outline: none;">
                        @foreach(['USD' => '$ USD', 'PKR' => 'Rs PKR', 'INR' => '₹ INR', 'GBP' => '£ GBP', 'AED' => 'د.إ AED', 'SAR' => 'ر.س SAR', 'CAD' => 'C$ CAD', 'AUD' => 'A$ AUD'] as $code => $label)
                            <option value="{{ $code }}" {{ session('user_currency') == $code ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </form>

                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="user-dropdown-btn inline-flex items-center">
                                <span>{{ Auth::user()->name }}</span>
                                <i class="fa fa-chevron-down ms-2 text-xs"></i>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="dropdown-glass">
                                <x-dropdown-link :href="route('profile.edit')" class="dropdown-item-style text-decoration-none">
                                    <i class="fa fa-user-circle me-2"></i> Profile
                                </x-dropdown-link>
                                <hr class="my-1 border-gray-100">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" class="dropdown-item-style text-red-600 text-decoration-none" onclick="event.preventDefault(); this.closest('form').submit();">
                                        <i class="fa fa-sign-out-alt me-2"></i> Log Out
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}" class="nav-link-custom">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="user-dropdown-btn text-decoration-none">Register</a>
                        @endif
                    </div>
                @endauth
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2 rounded-md text-white hover:bg-white/20 transition focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-indigo-900/95 backdrop-blur-xl border-t border-white/10">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white border-none">
                <i class="fa fa-home me-2"></i>Dashboard
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('product')" class="text-white border-none">
                <i class="fa fa-th-large me-2"></i>Products
            </x-responsive-nav-link>
            <a href="#newarrivals-section" class="block px-4 py-2 text-white no-underline opacity-80">New Arrivals</a>
            <a href="#contact-section" class="block px-4 py-2 text-white no-underline opacity-80">Contact</a>
        </div>
    </div>
    </div>
</nav>
</div>