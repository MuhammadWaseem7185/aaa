<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Arrivals - Responsive</title>
    <style>
        /* Base Container styling */
        .product-container {
            display: flex;
            flex-wrap: wrap; /* Yeh cards ko wrap karega jab jagah kam hogi */
            width: 90%;
            max-width: 1200px; /* Bohat badi screens par hadh se zyada na faile */
            margin: 50px auto;
            border-radius: 20px;
            gap: 20px;
            padding: 40px 20px; /* Thodi padding adjust ki */
            background-color: #0f172a;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Card Styling */
        .product-card {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 20px;
            padding: 30px;
            width: 100%; /* Default width full rakehin */
            max-width: 320px; /* Lekin ek hadh tak */
            position: relative;
            color: white;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-sizing: border-box; /* Padding ko width ke andar rakhta hai */
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(56, 189, 248, 0.2);
            border-color: #38bdf8;
        }

        /* Responsive Media Queries */
        @media (max-width: 768px) {
            .product-container {
                padding: 20px 10px;
                gap: 30px; /* Mobile par cards ke beech zyada gap */
            }
            
            .product-card {
                max-width: 100%; /* Mobile par card poori width le lega */
            }

            h2 {
                font-size: 20px; /* Mobile par text thoda chota */
            }
        }

        /* Badge aur baqi styles (Same as before) */
        .badge {
            background: linear-gradient(90deg, #38bdf8, #818cf8);
            color: white;
            font-size: 12px;
            font-weight: bold;
            padding: 5px 12px;
            border-radius: 50px;
            display: inline-block;
            margin-bottom: 15px;
        }

        h3 { color: #38bdf8; font-size: 14px; text-transform: uppercase; margin: 0; }
        h2 { font-size: 24px; margin: 10px 0; }
        .tagline { color: #94a3b8; font-size: 14px; margin-bottom: 20px; }

        .features { list-style: none; padding: 0; margin-bottom: 30px; }
        .features li { font-size: 14px; margin-bottom: 8px; color: #cbd5e1; }
        .features span { color: #38bdf8; margin-right: 8px; }

        .btn-group { display: flex; gap: 10px; }
        .btn-primary, .btn-secondary {
            padding: 12px 15px;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            flex: 1;
            font-size: 14px;
            transition: 0.2s;
        }

        .btn-primary { background: #38bdf8; border: none; color: #0f172a; }
        .btn-secondary { background: transparent; border: 1px solid #38bdf8; color: #38bdf8; }
        .btn-primary:hover { background: #7dd3fc; }
        .btn-secondary:hover { background: rgba(56, 189, 248, 0.1); }
    </style>
</head>
<body>
    <div class></div>
    <div class="product-container">
        <div class="product-card">
            <div class="badge">New Arrival</div>
            <div class="product-content">
                <h3>Fit-Tech Series</h3>
                <h2>The Ultimate Smart Companion</h2>
                <p class="tagline">Watch your health, stay connected.</p>
                <ul class="features">
                    <li><span>✦</span> AMOLED Display</li>
                    <li><span>✦</span> 24/7 Health Tracking</li>
                    <li><span>✦</span> 10 Days Battery</li>
                </ul>
                <div class="btn-group">
                    <button class="btn-primary">Shop Now</button>
                    <button class="btn-secondary">Explore</button>
                </div>
            </div>
        </div>

        <div class="product-card">
            <div class="badge">New Arrival</div>
            <div class="product-content">
                <h3>Pro-Book Series</h3>
                <h2>Power Without Limits</h2>
                <p class="tagline">Built for creators & gamers.</p>
                <ul class="features">
                    <li><span>✦</span> i7/i9 Processor</li>
                    <li><span>✦</span> Dedicated GPU</li>
                    <li><span>✦</span> Ultra-Thin Design</li>
                </ul>
                <div class="btn-group">
                    <button class="btn-primary">Buy Now</button>
                    <button class="btn-secondary">Specs</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>