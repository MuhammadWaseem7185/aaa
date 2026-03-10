<x-app-layout>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Checkout | Online Shop</title>
    <script src="https://js.stripe.com/v3/"></script>
    
    @php
        $symbols = ['INR' => '₹', 'PKR' => 'Rs', 'USD' => '$', 'EUR' => '€', 'GBP' => '£'];
        $symbol = $symbols[$currency] ?? '$';
        $convertedTotal = $total * $currentRate;
    @endphp

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .checkout-container {
            width: 100%;
            max-width: 500px;
            background: #ffffff;
            border-radius: 16px;
            padding: 40px 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            color: #333;
            margin: 40px auto;
        }

        h2 { font-size: 24px; font-weight: 700; text-align: center; margin-bottom: 24px; color: #1a202c; }

        .cart-summary { background: #f8f9fa; border-radius: 12px; padding: 20px; margin-bottom: 24px; border: 1px solid #edf2f7; }
        .cart-item { display: flex; align-items: center; gap: 12px; padding: 10px 0; border-bottom: 1px solid #eee; }
        .cart-item:last-child { border-bottom: none; }
        .cart-item img { width: 50px; height: 50px; object-fit: contain; border-radius: 6px; background: #fff; }

        #card-element { background: #f6f9fc; padding: 14px; border-radius: 8px; border: 1px solid #e2e8f0; margin-bottom: 20px; }
        input[type="text"] { width: 100%; padding: 14px; border-radius: 8px; border: 1px solid #e2e8f0; margin-bottom: 20px; font-size: 16px; transition: 0.3s; }
        input[type="text"]:focus { border-color: #667eea; outline: none; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }

        .payment-btn { 
            width: 100%; padding: 16px; background: #667eea; color: #fff; font-size: 16px; font-weight: 600; 
            border: none; border-radius: 8px; cursor: pointer; display: flex; justify-content: center; 
            align-items: center; transition: all 0.2s ease; 
        }
        .payment-btn:hover { background: #5a67d8; transform: translateY(-2px); }
        .payment-btn:disabled { opacity: 0.7; cursor: not-allowed; }

        /* Notification Styles */
        .notification {
            display: none; /* Hidden by default, JS will set to flex */
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            width: 90%;
            max-width: 400px;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            font-weight: 700;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            animation: slideDown 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }
        @keyframes slideDown { from { top: -100px; opacity: 0; } to { top: 20px; opacity: 1; } }
        
        .success { background: #10b981; color: white; border: 2px solid #059669; }
        .error { background: #ef4444; color: white; border: 2px solid #dc2626; }

        .spinner {
            width: 20px; height: 20px; border: 2px solid rgba(255,255,255,0.3);
            border-top-color: #fff; border-radius: 50%; display: none;
            animation: spin 0.8s linear infinite; margin-right: 10px;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
</head>
<body>

<div class="checkout-container">
    <h2>Secure Checkout</h2>
    
    <div class="cart-summary">
        <h5 style="margin-top:0;">📦 Order Summary</h5>
        @foreach($cartItems as $item)
        <div class="cart-item">
            <img src="{{ asset('products/' . $item['image']) }}" alt="{{ $item['name'] }}">
            <div style="flex: 1;">
                <div style="font-weight: 600;">{{ $item['name'] }}</div>
                <div style="font-size: 13px; color: #718096;">
                    {{ $item['quantity'] }} × {{ $symbol }}{{ number_format($item['price'] * $currentRate, 2) }}
                </div>
            </div>
            <div style="font-weight: 700; color: #667eea;">
                {{ $symbol }}{{ number_format(($item['price'] * $currentRate) * $item['quantity'], 2) }}
            </div>
        </div>
        @endforeach
        <div style="margin-top: 15px; padding-top: 15px; border-top: 2px dashed #e2e8f0; text-align: center;">
            <span style="font-size: 18px; font-weight: 800;">
                Total: {{ $symbol }}{{ number_format($convertedTotal, 2) }} {{ $currency }}
            </span>
        </div>
    </div>

    <div style="margin-bottom: 25px;">
        <div id="stripe-option" onclick="selectPayment('stripe')" style="border: 2px solid #667eea; border-radius: 12px; padding: 14px; margin-bottom: 10px; cursor: pointer; display: flex; align-items: center; gap: 10px; background: #f5f7ff;">
            <input type="radio" name="payment" id="stripe-radio" checked>
            <label style="margin:0; cursor:pointer; font-weight:600;">💳 Pay with Card</label>
        </div>
        <!-- <div id="cod-option" onclick="selectPayment('cod')" style="border: 2px solid #e2e8f0; border-radius: 12px; padding: 14px; cursor: pointer; display: flex; align-items: center; gap: 10px;">
            <input type="radio" name="payment" id="cod-radio">
            <label style="margin:0; cursor:pointer; font-weight:600;">💵 Cash on Delivery</label>
        </div> -->
    </div>

    <form id="payment-form">
        <label style="font-size: 14px; font-weight: 600; color: #4a5568;">Cardholder Name</label>
        <input type="text" id="cardholder-name" placeholder="Name on card" required>
        
        <label style="font-size: 14px; font-weight: 600; color: #4a5568;">Card Details</label>
        <div id="card-element"></div>

        <button type="submit" id="submit-btn" class="payment-btn">
            <div class="spinner" id="spinner"></div>
            <span id="btn-text" data-raw-total="{{ $total }}">
                Pay {{ $symbol }}{{ number_format($convertedTotal, 2) }}
            </span>
        </button>
    </form>

    <div id="cod-container" style="display:none;">
        <div style="background: #fffbeb; border: 1px solid #fef3c7; padding: 15px; border-radius: 10px; margin-bottom: 15px; color: #92400e; font-size: 14px;">
            🚀 Your order will be processed immediately. You'll pay <strong>{{ $symbol }}{{ number_format($convertedTotal, 2) }}</strong> at your doorstep.
        </div>
        <button type="button" id="cod-btn" onclick="processCOD(event)" class="payment-btn">
            Confirm Order (COD)
        </button>
    </div>

    <div id="payment-result" class="notification">
        <div id="status-icon" style="font-size: 30px;"></div>
        <div id="status-message"></div>
    </div>
</div>

<script>
    const stripe = Stripe('pk_test_51T1ZAe5sDRiS3mQ5raEcerwL6GMl5Xynx3ihRQ1At6UYEFWiqdBr8SXy45cAUnZ4RLVVKsehOjclkYO4NXPAyuRS0018u0K4s1');
    const elements = stripe.elements();
    const cardElement = elements.create('card');
    cardElement.mount('#card-element');

    const resultDiv = document.getElementById('payment-result');
    const messageText = document.getElementById('status-message');
    const statusIcon = document.getElementById('status-icon');

    function selectPayment(method) {
        const isStripe = (method === 'stripe');
        document.getElementById('payment-form').style.display = isStripe ? 'block' : 'none';
        document.getElementById('cod-container').style.display = isStripe ? 'none' : 'block';
        
        document.getElementById('stripe-option').style.borderColor = isStripe ? '#667eea' : '#e2e8f0';
        document.getElementById('stripe-option').style.background = isStripe ? '#f5f7ff' : '#fff';
        document.getElementById('cod-option').style.borderColor = isStripe ? '#e2e8f0' : '#667eea';
        document.getElementById('cod-option').style.background = isStripe ? '#fff' : '#f5f7ff';
        document.getElementById(method + '-radio').checked = true;
    }

    function showStatus(type, message) {
        resultDiv.style.display = 'flex';
        resultDiv.className = `notification ${type}`;
        messageText.textContent = message;
        statusIcon.textContent = type === 'success' ? '✅' : '❌';
        
        // Ensure user sees it if they've scrolled down
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    async function processCOD(event) {
        const btn = document.getElementById('cod-btn');
        btn.disabled = true;
        btn.innerHTML = '<div class="spinner" style="display:inline-block"></div> Processing...';

        try {
            const response = await fetch("{{ route('checkout') }}", {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ payment_method: 'cod' })
            });
            const data = await response.json();
        if (data.success === true) {
    showStatus('success', data.message || 'Payment successful!');
    setTimeout(() => window.location.href = dashboardUrl, 2500);
} else {
    showStatus('error', data.message || 'Payment failed.');
    btn.disabled = false;
    btn.innerHTML = 'Confirm Order';
}
        } catch (e) {
            showStatus('error', 'Network error. Please check your connection.');
            btn.disabled = false;
        }
    }

    document.getElementById('payment-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const btn = document.getElementById('submit-btn');
        const spinner = document.getElementById('spinner');
        const btnText = document.getElementById('btn-text');

        btn.disabled = true;
        spinner.style.display = 'block';
        btnText.textContent = 'Processing...';

        const { paymentMethod, error } = await stripe.createPaymentMethod({
            type: 'card',
            card: cardElement,
            billing_details: { name: document.getElementById('cardholder-name').value }
        });

        if(error) {
            showStatus('error', error.message);
            btn.disabled = false;
            spinner.style.display = 'none';
            btnText.textContent = 'Try Again';
        } else {
            const response = await fetch("{{ route('charge') }}", {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ 
                    payment_method: paymentMethod.id, 
                    amount: btnText.dataset.rawTotal * 100 
                })
            });
            const data = await response.json();
            
            if(data.success) {
                showStatus('success', 'Payment Successful! Redirecting...');
                setTimeout(() => window.location.href = "{{ route('dashboard') }}", 2500);
            } else {
                showStatus('error', data.message || 'Payment failed.');
                btn.disabled = false;
                spinner.style.display = 'none';
                btnText.textContent = 'Pay Now';
            }
        }
    });
</script>
</body>
</html>
</x-app-layout>