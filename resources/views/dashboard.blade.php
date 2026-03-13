<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    

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
            -webkit-mask-image: radial-gradient(circle, black 65%, rgba(0, 0, 0, 0) 100%);
            mask-image: radial-gradient(circle, black 65%, rgba(0, 0, 0, 0) 100%);
            filter: drop-shadow(0 0 30px rgba(241, 97, 121, 0.2));
            max-height: 550px;
            object-fit: contain;
        }

        /* Sections & Cards */
        .dashboard-summary-card {
            background-color: #1a1616;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
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
            padding-top: 20px;
        }

        /* Scroll Top Button Hover */
        #scrollTopBtn:hover {
            background-color: #ff4567 !important;
            transform: translateY(-5px);
        }

        /* Footer Custom Styling */
        .hover-pink:hover {
            color: #f16179 !important;
            transition: 0.3s;
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
                                Our shopping mall offers a curated collection of world-class brands.
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

    <div class="container mt-5">
        <div class="dashboard-summary-card">
            <h5 class="text-uppercase fw-bold mb-3" style="color: #f16179; letter-spacing: 2px;">System Overview</h5>
            <p class="summary-text">
                An effective ecommerce dashboard acts as the central nervous system of your online business, 
                transforming raw data into actionable insights at a single glance.
            </p>
            <p class="summary-text mb-0">
                Modern dashboards prioritize operational efficiency, ensuring a seamless experience 
                for both administrators and customers alike.
            </p>
        </div>
    </div>

    <div class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <h3 class="fw-bold mb-0">Trending Now</h3>
                <a href="{{ route('product') }}" class="badge bg-light text-dark border p-2 px-3 rounded-pill text-decoration-none shadow-sm">
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
                                <div class="price-text mb-3">
                                    {{ $currencySymbol }} {{ number_format($product->price * $currentRate, 2) }}
                                </div>
                                <button onclick="addToCart({{ $product->id }})" class="btn btn-dark w-100 rounded-pill py-2">
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

 <section class="py-2 bg-light" style="border-radius:20px;">
<div class="container py-5">

<div class="text-center mb-5">
<h5 class="text-uppercase fw-bold" style="color:#f16179; letter-spacing:2px;">Testimonials</h5>
<h2 class="fw-bold text-dark">What Our Shoppers Say</h2>
</div>

<div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">

<div class="carousel-inner">

<!-- SLIDE 1 -->
<div class="carousel-item active">
<div class="row g-4">

<div class="col-lg-4">
<div class="card border-0 shadow-sm text-center p-4 rounded-4">
<img class="rounded-circle mx-auto mb-4 border border-3"
style="width:80px;height:80px;object-fit:cover;border-color:#f16179 !important;"
src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?q=80&w=150">
<p class="text-secondary mb-4">Great shopping experience. Amazing products!</p>
<h6 class="fw-bold">SARAH J.</h6>
</div>
</div>

<div class="col-lg-4">
<div class="card border-0 shadow-sm text-center p-4 rounded-4">
<img class="rounded-circle mx-auto mb-4 border border-3"
style="width:80px;height:80px;object-fit:cover;border-color:#f16179 !important;"
src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=150">
<p class="text-secondary mb-4">Online shopping here is super easy.</p>
<h6 class="fw-bold">DAVID K.</h6>
</div>
</div>

<div class="col-lg-4">
<div class="card border-0 shadow-sm text-center p-4 rounded-4">
<img class="rounded-circle mx-auto mb-4 border border-3"
style="width:80px;height:80px;object-fit:cover;border-color:#f16179 !important;"
src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=150">
<p class="text-secondary mb-4">Premium brands and wonderful service.</p>
<h6 class="fw-bold">EMILY R.</h6>
</div>
</div>

</div>
</div>

<!-- SLIDE 2 -->
<div class="carousel-item">
<div class="row g-4">

<div class="col-lg-4">
<div class="card border-0 shadow-sm text-center p-4 rounded-4">
<img class="rounded-circle mx-auto mb-4 border border-3"
style="width:80px;height:80px;object-fit:cover;border-color:#f16179 !important;"
src="https://randomuser.me/api/portraits/men/32.jpg">
<p class="text-secondary mb-4">Fast delivery and great quality.</p>
<h6 class="fw-bold">JOHN D.</h6>
</div>
</div>

<div class="col-lg-4">
<div class="card border-0 shadow-sm text-center p-4 rounded-4">
<img class="rounded-circle mx-auto mb-4 border border-3"
style="width:80px;height:80px;object-fit:cover;border-color:#f16179 !important;"
src="https://randomuser.me/api/portraits/women/44.jpg">
<p class="text-secondary mb-4">Customer support is very helpful.</p>
<h6 class="fw-bold">ANNA M.</h6>
</div>
</div>

<div class="col-lg-4">
<div class="card border-0 shadow-sm text-center p-4 rounded-4">
<img class="rounded-circle mx-auto mb-4 border border-3"
style="width:80px;height:80px;object-fit:cover;border-color:#f16179 !important;"
src="https://randomuser.me/api/portraits/men/50.jpg">
<p class="text-secondary mb-4">My favorite shopping website!</p>
<h6 class="fw-bold">MICHAEL T.</h6>
</div>
</div>

</div>
</div>

</div>

<!-- BUTTONS -->
<button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
<span class="carousel-control-prev-icon"></span>
</button>

<button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
<span class="carousel-control-next-icon"></span>
</button>

</div>

</div>
</section>


<hr class="container">

<div class="container">
<footer class="text-secondary bg-white border-top mt-5 rounded-4 shadow-sm">

<div class="container py-5">
<div class="row text-center text-md-start">

<!-- Categories -->
<div class="col-lg-3 col-md-6 mb-4">
<h2 class="fw-bold text-dark fs-6 mb-3 text-uppercase">Categories</h2>

<ul class="list-unstyled">

<li class="mb-2">
<a href="{{ route('dashboard') }}" class="text-secondary text-decoration-none hover-pink">
Dashboard
</a>
</li>

<li class="mb-2">
<a href="#newarrivals-section" class="text-secondary text-decoration-none hover-pink">
New Arrival
</a>
</li>

<li class="mb-2">
<a href="#about-section" class="text-secondary text-decoration-none hover-pink">
About Us
</a>
</li>

<li class="mb-2">
<a href="#contact-section" class="text-secondary text-decoration-none hover-pink">
Contact Us
</a>
</li>

</ul>
</div>


<!-- Support -->
<div class="col-lg-3 col-md-6 mb-4">

<h2 class="fw-bold text-dark fs-6 mb-3 text-uppercase">Support</h2>

<ul class="list-unstyled">

<li class="mb-2">
<a href="tel:+9230012345678" class="text-secondary text-decoration-none hover-pink">
📞 +92 300 12345678
</a>
</li>

<li class="mb-2">
<a href="mailto:support@yourwebsite.com" class="text-secondary text-decoration-none hover-pink">
✉ support@yourwebsite.com
</a>
</li>

<li class="mb-2">
<a href="#" class="text-secondary text-decoration-none hover-pink">
Returns & Refunds
</a>
</li>

<li class="mb-2">
<a href="#contact-section" class="text-secondary text-decoration-none hover-pink">
Contact Support
</a>
</li>

</ul>

</div>


<!-- Legal -->
<div class="col-lg-3 col-md-6 mb-4">

<h2 class="fw-bold text-dark fs-6 mb-3 text-uppercase">Legal</h2>

<ul class="list-unstyled">

<li class="mb-2">
<a href="#" class="text-secondary text-decoration-none hover-pink">
Privacy Policy
</a>
</li>

<li class="mb-2">
<a href="#" class="text-secondary text-decoration-none hover-pink">
Terms of Service
</a>
</li>

<li class="mb-2">
<a href="#" class="text-secondary text-decoration-none hover-pink">
Cookies Policy
</a>
</li>

</ul>

</div>


<!-- Newsletter -->
<div class="col-lg-3 col-md-6 mb-4">

<h2 class="fw-bold text-dark fs-6 mb-3 text-uppercase">Subscribe</h2>

<form>

<div class="d-flex flex-column flex-sm-row gap-2">

<input 
type="email" 
class="form-control bg-light" 
placeholder="Your Email"
required
>

<button class="btn btn-success">
Join
</button>

</div>

</form>

<p class="small text-muted mt-3">
Stay updated with our latest offers and products.
</p>

</div>

</div>
</div>



<!-- Bottom Footer -->
<div class="bg-light py-3 border-top mb-3">
  <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">

    <!-- Copyright -->
    <p class="small text-muted mb-2 mb-md-0">
      © {{ date('Y') }} Shopping Mall — All Rights Reserved
    </p>

    <!-- Social Links -->
    <div class="d-flex gap-3">
      <a href="https://www.facebook.com" target="_blank" rel="noopener" class="text-secondary hover-pink fs-5" aria-label="Facebook">
        <i class="fa-brands fa-facebook"></i>
      </a>

      <a href="https://www.twitter.com" target="_blank" rel="noopener" class="text-secondary hover-pink fs-5" aria-label="Twitter">
        <i class="fa-brands fa-twitter"></i>
      </a>

      <a href="https://www.instagram.com" target="_blank" rel="noopener" class="text-secondary hover-pink fs-5" aria-label="Instagram">
        <i class="fa-brands fa-instagram"></i>
      </a>
    </div>

  </div>
</div>
</footer>
</div>

      

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
new bootstrap.Carousel(document.querySelector('#testimonialCarousel'), {
interval: 4000,
pause:false
});


        const scrollTopBtn = document.getElementById("scrollTopBtn");
        window.onscroll = function() {
            if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
                scrollTopBtn.style.display = "block";
            } else {
                scrollTopBtn.style.display = "none";
            }
        };

        scrollTopBtn.addEventListener("click", () => {
            window.scrollTo({ top: 0, behavior: "smooth" });
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