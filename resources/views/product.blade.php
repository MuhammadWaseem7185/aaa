<x-app-layout>
    <div class="container" style="border-radius:10px;margin-top:10px;">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">

    <style>
        html { scroll-behavior: smooth !important; }
        .main-content-wrapper {
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradientBG 25s ease infinite;
            min-height: 100vh;
            padding: 40px 0;
        }
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .product-card {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(15px);
            border-radius: 25px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: 0.4s;
            margin-bottom: 30px;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .product-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.2); }
        .btn-cart {
            background: linear-gradient(to right, #e73c7e, #ee7752);
            color: white !important;
            border: none;
            padding: 10px;
            border-radius: 12px;
            font-weight: 700;
            width: 100%;
            transition: 0.3s;
        }
        .btn-cart:disabled { opacity: 0.7; cursor: not-allowed; }
        .currency-selector {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.4);
            color: white;
            border-radius: 20px;
            padding: 5px 15px;
            font-weight: 600;
            outline: none;
            cursor: pointer;
        }
        .currency-selector option { background: #e73c7e; color: white; }
        #toast-container { position: fixed; top: 20px; right: 20px; z-index: 9999; }

        #scrollTopBtn:hover {
    background-color: #ff4567;
    transform: translateY(-10px);
}
    </style>

    @php
        $currencySymbols = ['INR'=>'₹','PKR'=>'Rs','USD'=>'$','EUR'=>'€','AED'=>'د.إ'];
        $currencySymbol = $currencySymbols[$currency] ?? '$';
    @endphp

    <div id="toast-container"></div>

    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold mb-0" style="color: #d11414ff;">🛒 Shopping Mall</h2>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('myorder') }}" class="btn btn-outline-danger rounded-pill px-3 shadow-sm fw-bold">
                    <i class="fa fa-list-alt me-2"></i> My Orders
                </a>
                <a href="{{ route('cart.index') }}" class="btn btn-warning rounded-pill px-4 fw-bold shadow-sm">
                    <i class="fa fa-shopping-basket me-2"></i> Cart
                    <span id="cart-count-badge" class="badge bg-danger ms-1">{{ count((array) session('cart')) }}</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="main-content-wrapper" style="border-radius: 20px;">
        <div class="container" style="border-radius: 20px;">
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-white">EXCLUSIVE CATALOG</h1>
                <p class="text-white opacity-75 fs-5">Premium quality products curated just for you in <strong>{{ $currency }}</strong></p>
            </div>

            <div class="row gx-3 gy-5">
                @foreach($products as $product)
                <div class="col-md-6 col-lg-4">
                    <div class="product-card p-3 shadow-lg">
                        <div class="rounded-4 mb-3" style="height: 200px; overflow: hidden; background: #fff;">
                            <img src="{{ asset('products/' . $product->image) }}" class="w-100 h-100 object-fit-contain" onerror="this.src='https://placehold.co/400x300?text=Product'">
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fw-bold text-white mb-1">{{ $product->name }}</h5>
                            <p class="text-white small mb-2 opacity-75">{{ Str::limit($product->description, 60) }}</p>
                              <!-- <h5 class="fw-bold text-white mb-1">{{ $product->stock }}</h5> -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="fs-4 fw-bold text-white">
                                    {{ $currencySymbol }}{{ number_format($product->price * $currentRate, 2) }}
                                </span>
                                <div class="text-warning small"><i class="fa fa-star"></i> 4.8</div>
                            </div>
                        </div>
                        <button type="button" onclick="addToCart(this, {{ $product->id }})" class="btn btn-cart">
                            <i class="fa fa-cart-plus me-2"></i> ADD TO CART
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        
    </div>
<!-- Scroll to Top Button -->
<button id="scrollTopBtn" title="Go to top" 
        style="display:none; position: fixed; bottom: 40px; right: 18px; z-index: 9999;
               background-color: #f16179; color: white; border: none; 
               padding: 12px 18px; border-radius: 50px; font-size: 18px; cursor: pointer;
               box-shadow: 0 4px 8px rgba(0,0,0,0.2); transition: 0.3s;">
    ↑ Top
</button>
    
    <!-- Currency Auto-detect for all countries -->
    <script>
    if(!sessionStorage.getItem("currencyDetected")) {
        fetch("https://ip-api.com/json/")
        .then(res => res.json())
        .then(location => {
            let countryCode = location.countryCode;

            fetch("https://restcountries.com/v3.1/alpha/" + countryCode)
            .then(res => res.json())
            .then(countryData => {
                let currencies = countryData[0].currencies;
                let currencyCode = Object.keys(currencies)[0] || 'USD';

                fetch("{{ route('set.currency') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ currency: currencyCode })
                }).then(() => {
                    sessionStorage.setItem("currencyDetected","yes");
                    location.reload();
                });
            })
            .catch(() => { // fallback
                fetch("{{ route('set.currency') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ currency: 'USD' })
                }).then(() => {
                    sessionStorage.setItem("currencyDetected","yes");
                    location.reload();
                });
            });
        });
    }
    </script>

    <script>
        function addToCart(btn, productId) {
            const originalContent = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Adding...';

            fetch("{{ url('cart/add') }}/" + productId, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    document.getElementById('cart-count-badge').innerText = data.cart_count;
                    showToast('Success', 'Item added to cart!', 'success');
                }
                btn.disabled = false;
                btn.innerHTML = originalContent;
            })
            .catch(error => {
                showToast('Error', 'Something went wrong!', 'danger');
                btn.disabled = false;
                btn.innerHTML = originalContent;
            });
        }

        function showToast(title, msg, type) {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = `alert alert-${type} shadow-lg border-0 rounded-4 mb-2 animate__animated animate__fadeInRight`;
            toast.innerHTML = `<strong>${title}</strong>: ${msg}`;
            container.appendChild(toast);

            setTimeout(() => { 
                toast.style.transition = '0.5s';
                toast.style.opacity = '0'; 
                setTimeout(() => toast.remove(), 500); 
            }, 3000);
        }


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
    </script>
    </div>
</x-app-layout>
