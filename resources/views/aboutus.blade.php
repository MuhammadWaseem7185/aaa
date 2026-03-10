<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Glassmorphism Card */
        .about-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(15px);
            border-radius: 40px;
            padding: 60px 40px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
            margin-top: 60px;
            margin-bottom: 60px;
            transition: transform 0.3s ease;
            width: 100%;margin-left:auto;margin-right:auto;
        }

        .section-title {
            background: linear-gradient(to right, #e73c7e, #23a6d5);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        /* Icon Animation */
        .value-box {
            padding: 30px;
            border-radius: 25px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.5);
            border: 1px solid transparent;
        }

        .value-box:hover {
            background: #fff;
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
            border: 1px solid #e73c7e;
        }

        .value-icon {
            font-size: 3rem;
            margin-bottom: 20px;
            display: inline-block;
            transition: transform 0.5s ease;
        }

        .value-box:hover .value-icon {
            transform: rotateY(360deg);
        }

        /* Animated Illustration Area */
        .image-container {
            position: relative;
            padding: 20px;
        }

        .image-container i {
            background: linear-gradient(135deg, #e73c7e, #ee7752);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 10px 15px rgba(231, 60, 126, 0.3));
        }

        .why-us-section {
            background: rgba(255, 255, 255, 0.4);
            border-radius: 30px;
            padding: 40px;
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .feature-item i {
            color: #e73c7e;
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

    </style>
    <title>About Us - Premium Style</title>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-lg-11 mx-auto">
            <div class="about-card">
                
                <div class="text-center mb-5 pb-4">
                    <h1 class="display-4 section-title">Our Story</h1>
                    <p class="lead text-dark fw-light px-lg-5">
                        <strong>welcome at !</strong> Our journey began with a simple thought: to make high-quality and excellent products easily accessible to everyone. We're not just an online store, we want to build a community where shopping is easy, trustworthy, and fun.
                    </p>
                </div>

         <!-- resources/views/product.blade.php -->
<div class="row mb-5 align-items-center">
    <div class="col-md-6 order-2 order-md-1">
        <h2 class="section-title">What We Do?</h2>
        <p class="text-muted">
            We offer the best variety in <strong>[Fashion/Electronics/Home Decor]</strong>. 
            Our team works day and night to deliver only products that pass quality tests. 
            We know that both your time and money are valuable, so we rely on fast delivery and an easy return policy.
        </p>
        <button id="learnMoreBtn" class="btn btn-outline-danger rounded-pill px-4 mt-3">
            Learn More
        </button>

        <div id="learnMoreContent" class="mt-3"></div>
    </div>

    <div class="col-md-6 order-1 order-md-2 text-center image-container">
        <i class="fa fa-rocket fa-10x opacity-75"></i>
    </div>
</div>


<script>
document.getElementById('learnMoreBtn').addEventListener('click', function() {
    // Fetch content from the learnmore route
    fetch("{{ route('learnmore') }}")
        .then(response => response.text())
        .then(html => {
            // Insert content below the button
            document.getElementById('learnMoreContent').innerHTML = html;
            // Optionally, hide the button after click
            this.style.display = 'none';
        })
        .catch(err => console.error('Error loading content:', err));
});
</script>
                <hr class="my-5 opacity-50">

                <h2 class="section-title text-center mb-5">Our Values</h2>
                <div class="row text-center g-4 mb-5">
                    <div class="col-md-4">
                        <div class="value-box">
                            <i class="fa fa-heart value-icon" style="color: #e73c7e;"></i>
                            <h5 class="fw-bold">Customer First</h5>
                            <p class="small text-muted mb-0">Your happiness is our top priority. We listen to your needs.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="value-box">
                            <i class="fa fa-shield-halved value-icon" style="color: #23a6d5;"></i>
                            <h5 class="fw-bold">Quality Guarantee</h5>
                            <p class="small text-muted mb-0">We never compromise. Every product is hand-checked.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="value-box">
                            <i class="fa fa-eye value-icon" style="color: #23d5ab;"></i>
                            <h5 class="fw-bold">Transparency</h5>
                            <p class="small text-muted mb-0">No hidden costs. Honest pricing and honest products.</p>
                        </div>
                    </div>
                </div>

                <div class="why-us-section mt-5">
                    <h2 class="section-title text-center h3">Why Choose Us?</h2>
                    <div class="row g-4 mt-2 text-center">
                        <div class="col-md-4 feature-item">
                            <i class="fa fa-rocket"></i>
                            <h6 class="fw-bold">Fast Delivery</h6>
                            <p class="small text-muted mb-0">Across the country in record time.</p>
                        </div>
                        <div class="col-md-4 feature-item">
                            <i class="fa fa-fingerprint"></i>
                            <h6 class="fw-bold">Secure Checkout</h6>
                            <p class="small text-muted mb-0">Your data is encrypted and 100% safe.</p>
                        </div>
                        <div class="col-md-4 feature-item">
                            <i class="fa fa-headset"></i>
                            <h6 class="fw-bold">24/7 Support</h6>
                            <p class="small text-muted mb-0">We are always here to help you out.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>