<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/all.min.css">

    @php
        $symbols = ['INR' => '₹', 'PKR' => 'Rs', 'USD' => '$'];
        $symbol = $symbols[$currency] ?? '₹';
    @endphp

    <div id="toast-container" class="position-fixed top-0 end-0 p-3" style="z-index: 9999;"></div>

    <div class="container py-5">
        <h2 class="fw-bold mb-4 text-dark"><i class="fa fa-shopping-cart text-primary me-2"></i>Your Shopping Cart ({{ $currency }})</h2>
        
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 text-start">Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="cart-table-body">
                        @if(session('cart') && count(session('cart')) > 0)
                            @foreach(session('cart') as $id => $details)
                                <tr id="row-{{ $id }}">
                                    <td class="ps-4 text-start">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('products/' . ($details['image'] ?? 'default.jpg')) }}" 
                                                 class="rounded-3 shadow-sm me-3" 
                                                 style="width: 65px; height: 65px; object-fit: cover;">
                                            <div class="fw-bold text-dark">{{ $details['name'] }}</div>
                                        </div>
                                    </td>
                                    <td class="text-secondary">{{ $symbol }}{{ number_format($details['price'] * $currentRate, 2) }}</td>
                                    
                                    <td style="min-width: 160px;">
                                        <div class="d-flex align-items-center justify-content-center bg-light rounded-pill p-1 mx-auto" style="width: fit-content; border: 1px solid #dee2e6;">
                                            <button onclick="updateQty('{{ $id }}', 'decrease')" class="btn btn-sm btn-white rounded-circle shadow-sm qty-btn" {{ $details['quantity'] <= 1 ? 'disabled' : '' }} id="minus-{{ $id }}">
                                                <b>-</b>
                                            </button>
                                            <span class="mx-3 fw-bold text-dark qty-val" id="qty-{{ $id }}">{{ $details['quantity'] }}</span>
                                            <button onclick="updateQty('{{ $id }}', 'increase')" class="btn btn-sm btn-white rounded-circle shadow-sm qty-btn">
                                                <b>+</b>
                                            </button>
                                        </div>
                                    </td>

                                    <td class="fw-bold text-primary">{{ $symbol }}<span id="subtotal-{{ $id }}">{{ number_format(($details['price'] * $details['quantity']) * $currentRate, 2) }}</span></td>
                                    
                                    <td>
                                        <button onclick="removeItem('{{ $id }}')" class="btn btn-outline-danger btn-sm rounded-pill px-3 shadow-sm">
                                            <i class="fa fa-trash"></i> Remove
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr id="empty-cart-msg">
                                <td colspan="5" class="py-5 text-center text-muted">
                                    <p class="mb-0 fs-5">Your cart is empty!</p>
                                    <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3 rounded-pill px-4 shadow">Continue Shopping</a>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        @if(session('cart') && count(session('cart')) > 0)
        <div class="row mt-4" id="checkout-section">
            <div class="col-md-12 text-end">
                <div class="card border-0 shadow-sm p-4 rounded-4 bg-white d-inline-block" style="min-width: 300px;">
                    <h5 class="text-muted">Grand Total:</h5>
                    <h2 class="text-danger fw-bold mb-3">{{ $symbol }}<span id="grand-total">{{ number_format(array_sum(array_map(function($item) use ($currentRate) { return ($item['price'] * $item['quantity']) * $currentRate; }, session('cart'))), 2) }}</span></h2>
                    <form action="{{ route('checkout.page') }}" method="GET">
                        <button type="submit" class="btn btn-success btn-lg w-100 rounded-pill shadow py-3">
                            Proceed to Checkout <i class="fa fa-arrow-right ms-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>

    <script>
        // Controller se rate pass kiya ja raha hai
        const currentRate = {{ $currentRate }};

        function formatCurrency(amount) {
            return parseFloat(amount * currentRate).toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        function updateQty(id, action) {
            fetch(`/cart/update/${id}`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ action: action })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    document.getElementById(`qty-${id}`).innerText = data.item_qty;
                    // PHP se aane wale data ko JS rate se multiply karke format karna
                    document.getElementById(`subtotal-${id}`).innerText = formatCurrency(data.item_subtotal_raw); // Subtotal raw numeric bhejna controller se behtar hai
                    document.getElementById(`grand-total`).innerText = formatCurrency(data.grand_total_raw); 
                    
                    document.getElementById(`minus-${id}`).disabled = data.item_qty <= 1;
                }
            });
        }

        function removeItem(id) {
            if(!confirm('Are you sure you want to remove this item?')) return;

            fetch(`/cart/remove/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    document.getElementById(`row-${id}`).remove();
                    document.getElementById(`grand-total`).innerText = formatCurrency(data.grand_total_raw);
                    
                    if(data.cart_empty) {
                        location.reload(); 
                    }
                }
            });
        }
    </script>
</x-app-layout>