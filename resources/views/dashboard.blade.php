<x-app-layout>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    @php
        $currency = session('user_currency', 'USD');
        $currentRate = session('current_rate', 1);
        $currencySymbols = ['INR'=>'₹','PKR'=>'Rs','USD'=>'$','EUR'=>'€','AED'=>'د.إ'];
        $currencySymbol = $currencySymbols[$currency] ?? '$';
    @endphp

    <style>
        html { scroll-behavior: smooth; }
        #toast-container { position: fixed; top: 20px; right: 20px; z-index: 9999; }

        /* Hero Image Styles */
        .hero_section {
            border-radius: 30px; 
            border: 1px solid #333;
            overflow: hidden;
        }

        .hero-img-blur {
            /* The requested corner blur effect */
            -webkit-mask-image: radial-gradient(circle, black 65%, rgba(0, 0, 0, 0) 100%);
            mask-image: radial-gradient(circle, black 65%, rgba(0, 0, 0, 0) 100%);
            filter: drop-shadow(0 0 30px rgba(241, 97, 121, 0.2));
            max-height: 550px;
            object-fit: contain;
        }

        /* Carousel Styles */
        .carousel-item img {
            height: 550px;
            object-fit: cover;
            filter: brightness(0.6);
            transition: transform 5s ease;
        }
        .carousel-item.active img { transform: scale(1.05); }
        .carousel-caption {
            background: rgba(0,0,0,0.45);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            bottom: 15%;
        }

        /* Sections & Cards */
        .dashboard-summary-card {
            background-color: #1a1616;
            /* border-left: 5px solid #f16179;
            border-right: 5px solid #f16179;
            border-bottom: 5px solid #f16179;
            border-top: 5px solid #f16179; */
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            max-width: 100%;
            margin: 0 auto;
        }
        .summary-text {
            color: #ccbaba;
            font-size: 1.1rem;
            line-height: 1.8;
            text-align: justify;
        }

        .trust-section { background: #0a0a0a; width: 90%; margin: auto; border-radius: 25px; border: 1px solid #222; }
        .trust-card { padding: 25px; border-radius: 15px; transition: 0.3s; color: #e5e7eb; }
        .trust-card:hover { transform: translateY(-5px); background: #111; }

        .trending-card { transition: 0.3s; border: none; }
        .trending-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.12); }
        .price-text { color: #f16179; font-weight: 800; font-size: 1.2rem; }

        #newarrivals-section, #about-section, #contact-section {
            scroll-margin-top: 100px;
            padding-top: 20px;}

            #scrollTopBtn:hover {
    background-color: #ff4567;
    transform: translateY(-10px);
}
        
    </style>

    <div id="toast-container"></div>

    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold mb-0 text-danger"><i class="fa fa-shopping-bag me-2"></i>Shopping Mall</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('myorder') }}" class="btn btn-outline-danger rounded-pill fw-bold px-4">
                    <i class="fa fa-list-alt me-1"></i> My Orders
                </a>
                <a href="{{ route('cart.index') }}" class="btn btn-warning rounded-pill fw-bold px-4">
                    <i class="fa fa-shopping-basket text-danger me-1"></i> Cart
                    <span id="cart-count" class="badge bg-danger ms-1">{{ count((array) session('cart')) }}</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="container mt-4 mb-4">
        <section class="hero_section bg-dark text-white py-5">
            <div class="container px-5">
                <div class="row align-items-center">
                    <div class="col-md-6 mb-4 mb-md-0">
                        <div class="detail-box">
                            <h1 class="display-3 fw-bold mb-3">
                                Welcome To Our <br>
                                <span style="color: #f16179;">SHOPPING MALL</span>
                            </h1>
                            <p class="lead mb-4 text-secondary">
                                Experience the ultimate destination for style, taste, and innovation. 
                                Our shopping mall offers a curated collection of world-class brands, 
                                premium boutiques, and exceptional dining options all under one roof.
                            </p>
                            <a href="#contact-section" class="btn btn-danger btn-lg px-5 rounded-pill shadow-lg">
                                CONTACT US
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <img src="shopnow.JPEG" alt="Neon Shopping Cart" class="img-fluid hero-img-blur w-100">
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="container mt-6">
        <div class="dashboard-summary-card">
            <h5 class="text-uppercase fw-bold mb-3" style="color: #f16179; letter-spacing: 2px;">System Overview</h5>
            <p class="summary-text">
                An effective ecommerce dashboard acts as the central nervous system of your online business, 
                transforming raw data into actionable insights at a single glance. It typically features 
                a clean, high-contrast interface—often utilizing a sidebar for navigation and a responsive 
                grid for key performance indicators.
            </p>
            <p class="summary-text mb-0">
                Modern dashboards also prioritize operational efficiency by integrating dedicated sections 
                for inventory management, customer support tickets, and order fulfillment tracking, 
                ensuring a seamless experience for both administrators and customers alike.
            </p>
        </div>
    </div>

<div class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <h3 class="fw-bold mb-0">Trending Now</h3>
            <a href="{{ route('product') }}" class="badge bg-light text-dark border p-2 px-3 rounded-pill text-decoration-none shadow-sm hover-fade">
                ALL PRODUCTS <i class="fa fa-arrow-right ms-1" style="font-size: 10px;"></i>
            </a>
        </div>
        
        <div class="row g-4">
            @foreach($products->take(4) as $product)
                <div class="col-6 col-md-3">
                    <div class="card h-100 trending-card rounded-4 overflow-hidden shadow-sm border-0">
                        <div class="p-3 bg-light d-flex align-items-center justify-content-center" style="height: 240px;">
                            <img src="{{ asset('products/' . $product->image) }}" 
                                 class="card-img-top" 
                                 style="max-height: 100%; width: auto; object-fit: contain;" 
                                 alt="{{ $product->name }}">
                        </div>
                        <div class="card-body text-center">
                            <h6 class="fw-bold text-truncate">{{ $product->name }}</h6>
                            <div class="price-text mb-3" style="color: #f16179;">
                                {{ $currencySymbol }} {{ number_format($product->price * $currentRate, 2) }}
                            </div>
                            <button onclick="addToCart({{ $product->id }})" class="btn btn-dark w-100 rounded-pill py-2 shadow-sm">
                                <i class="fa fa-cart-plus me-2"></i>Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>


     
    <div class="trust-section py-5 mt-4 text-center">
        <div class="container">
       
            <div class="row g-4 text-white">
                <div class="col-6 col-md-3">
                    <div class="trust-card">
                        <i class="fa fa-truck-fast text-info fs-1 mb-3"></i>
                        <h6 class="fw-bold">Free Shipping</h6>
                        <p class="small opacity-75 mb-0">Fast delivery worldwide</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="trust-card">
                        <i class="fa fa-shield-halved text-success fs-1 mb-3"></i>
                        <h6 class="fw-bold">Secure Payment</h6>
                        <p class="small opacity-75 mb-0">100% safe transactions</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="trust-card">
                        <i class="fa fa-rotate-left text-warning fs-1 mb-3"></i>
                        <h6 class="fw-bold">Easy Returns</h6>
                        <p class="small opacity-75 mb-0">7 days return policy</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="trust-card">
                        <i class="fa fa-headset text-danger fs-1 mb-3"></i>
                        <h6 class="fw-bold">24/7 Support</h6>
                        <p class="small opacity-75 mb-0">Always here to help</p>
                    </div>
                </div>
            </div>
        </div>
        </div>


    <div id="newarrivals-section">@include('newarival')</div>
    <div id="about-section">@include('aboutus')</div>
    <div id="contact-section">@include('contactus')</div>

    <!-- Scroll to Top Button -->
<button id="scrollTopBtn" title="Go to top" 
        style="display:none; position: fixed; bottom: 40px; right: 30px; z-index: 9999;
               background-color: #f16179; color: white; border: none; 
               padding: 12px 18px; border-radius: 50px; font-size: 18px; cursor: pointer;
               box-shadow: 0 4px 8px rgba(0,0,0,0.2); transition: 0.3s;">
    ↑ Top
</button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>

// Scroll to Top Button Logic
const scrollTopBtn = document.getElementById("scrollTopBtn");

// Show button when user scrolls down 200px
window.onscroll = function() {
    if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
        scrollTopBtn.style.display = "block";
    } else {
        scrollTopBtn.style.display = "none";
    }
};

// Smooth scroll to top when button clicked
scrollTopBtn.addEventListener("click", () => {
    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
});


        function addToCart(id) {
            fetch(`/cart/add/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success){
                    document.getElementById('cart-count').innerText = data.cart_count ?? 0;
                    const container = document.getElementById('toast-container');
                    const toast = document.createElement('div');
                    toast.className = 'toast align-items-center text-bg-success border-0 show';
                    toast.innerHTML = `
                        <div class="d-flex">
                            <div class="toast-body"><i class="fa fa-check-circle me-2"></i>${data.message || 'Added to cart!'}</div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                        </div>`;
                    container.appendChild(toast);
                    new bootstrap.Toast(toast, { delay: 3000 }).show();
                    toast.addEventListener('hidden.bs.toast', () => toast.remove());
                }
            });
        }
    </script>
</x-app-layout>