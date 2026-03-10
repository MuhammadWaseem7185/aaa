<x-app-layout>
    <style>
        /* --- Base Admin Styling & Animated Background --- */
        body { 
            margin: 0; padding: 0; min-height: 100vh;
            background: linear-gradient(-45deg, #020617, #0f172a, #1e1b4b, #020617);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            font-family: 'Inter', sans-serif; color: #cbd5e1; 
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .min-h-screen { background: transparent !important; }
        .admin-container { padding: 2rem; max-width: 1200px; margin: 0 auto; }

        .glass-panel {
            background: rgba(15, 23, 42, 0.6); 
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px; padding: 1.5rem; margin-bottom: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .custom-table { width: 100%; border-spacing: 0 8px; border-collapse: separate; }
        .custom-table thead th { padding: 12px 20px; color: #38bdf8; font-size: 0.75rem; text-transform: uppercase; }
        .custom-table tbody tr { background: rgba(30, 41, 59, 0.4); transition: 0.3s; }
        .custom-table td { padding: 16px 20px; border-radius: 12px; vertical-align: middle; }

        .btn-action { padding: 8px 16px; border-radius: 10px; font-size: 0.75rem; font-weight: 700; transition: 0.3s; display: inline-flex; align-items: center; gap: 6px; cursor: pointer; }
        .btn-edit { background: rgba(99, 102, 241, 0.1); color: #818cf8; border: 1px solid rgba(129, 140, 248, 0.3); }
        .btn-delete { background: rgba(239, 68, 68, 0.1); color: #f87171; border: 1px solid rgba(248, 113, 113, 0.3); }
        .btn-delete:hover { background: #dc2626; color: white; }
        
        .btn-new-product { background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 10px 20px; border-radius: 12px; font-weight: 600; text-decoration: none; }
        .order-id-tag { font-family: monospace; color: #38bdf8; background: rgba(56, 189, 248, 0.1); padding: 2px 6px; border-radius: 4px; }

        /* Status Pills */
        .status-pill { padding: 4px 12px; border-radius: 20px; font-size: 0.7rem; font-weight: bold; text-transform: uppercase; }
        .status-pending { background: rgba(245, 158, 11, 0.1); color: #fbbf24; border: 1px solid rgba(251, 191, 36, 0.3); }
        .status-completed { background: rgba(16, 185, 129, 0.1); color: #34d399; border: 1px solid rgba(52, 211, 153, 0.3); }

        /* Currency Select Style */
        .currency-select {
            background: rgba(30, 41, 59, 0.7);
            color: #38bdf8;
            border: 1px solid rgba(56, 189, 248, 0.2);
            padding: 5px 15px;
            border-radius: 12px;
            font-size: 0.85rem;
            outline: none;
            cursor: pointer;
        }
    </style>

    @php
        $symbols = ['INR' => '₹', 'PKR' => 'Rs', 'USD' => '$', 'AED' => 'د.إ '];
        $symbol = $symbols[$currency] ?? 'Rs';
    @endphp

    <div class="admin-container">
        <div class="glass-panel d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 fw-bold text-white mb-0">Admin Dashboard</h1>
                <p class="text-secondary small">Welcome back! Here's what's happening today.</p>
            </div>
            
            <div class="d-flex align-items-center gap-3">
                <span class="text-secondary small fw-bold"><i class="fa-solid fa-globe me-1"></i> CURRENCY</span>
                <form action="{{ route('set.currency') }}" method="POST" class="m-0">
                    @csrf
                    <select name="currency" onchange="this.form.submit()" class="currency-select">
                        <option value="INR" {{ $currency == 'INR' ? 'selected' : '' }}>₹ INR</option>
                        <option value="PKR" {{ $currency == 'PKR' ? 'selected' : '' }}>Rs PKR</option>
                        <option value="USD" {{ $currency == 'USD' ? 'selected' : '' }}>$ USD</option>
                        <option value="AED" {{ $currency == 'AED' ? 'selected' : '' }}>د.إ AED</option>
                        <option value="EUR" {{ $currency == 'EUR' ? 'selected' : '' }}>€ EUR</option>
                    </select>
                </form>
            </div>
        </div>

        <div class="glass-panel">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h4 fw-bold text-white mb-0">
                    <i class="fa-solid fa-receipt text-info me-2"></i> Recent Orders
                </h2>
                <span class="badge bg-dark border border-secondary px-3 py-2 rounded-pill">
                    Total: {{ $orders->count() }}
                </span>
            </div>

            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>User ID</th>
                            <th>Amount</th>
                            <th class="text-center">Status</th>
                            <th class="text-end">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td><span class="order-id-tag">#ORD-{{ $order->id }}</span></td>
                            <td><span class="small text-secondary">ID: {{ $order->user_id }}</span></td>
                            <td><span class="text-white fw-bold">{{ $symbol }}{{ number_format($order->total_amount * $currentRate, 2) }}</span></td>
                            <td class="text-center">
                                <span class="status-pill status-{{ strtolower($order->status ?? 'pending') }}">
                                    {{ $order->status ?? 'Pending' }}
                                </span>
                            </td>
                            <td class="text-end text-secondary small">
                                {{ $order->created_at->format('d M, Y') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-secondary">
                                <i class="fa-solid fa-box-open d-block mb-2 fs-2"></i>
                                Abhi tak koi order nahi mila.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="glass-panel">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="h4 fw-bold text-white mb-0">Product Management</h2>
                    <p class="text-secondary small mb-0">Track and update your store inventory</p>
                </div>
                <a href="{{ route('adduser') }}" class="btn-new-product">
                    <i class="fa-solid fa-plus-circle me-1"></i> New Product
                </a>
            </div>

            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="product-list">
                        @foreach($products as $product)
                        <tr id="product-row-{{ $product->id }}">
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ asset('/products/' . $product->image) }}" class="rounded-3" style="width: 45px; height: 45px; object-fit: cover" onerror="this.src='https://placehold.co/50x50?text=NA'">
                                    <span class="text-white fw-medium">{{ $product->name }}</span>
                                </div>
                            </td>
                            <td><span class="text-secondary small text-truncate d-inline-block" style="max-width: 200px;">{{ $product->description }}</span></td>
                            <td class="text-info fw-bold">{{ $symbol }}{{ number_format($product->price * $currentRate, 2) }}</td>
                            <td class="text-info fw-bold">{{ $product->stock }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-action btn-edit text-decoration-none">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>
                                    <form class="delete-form" data-id="{{ $product->id }}" action="{{ route('admin.products.delete', $product->id) }}" method="POST">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete border-0">
                                            <i class="fa-solid fa-trash-can"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                if (!confirm('Are you sure you want to delete this product?')) return;

                const productId = this.getAttribute('data-id');
                const url = this.getAttribute('action');
                const row = document.getElementById(`product-row-${productId}`);
                const token = this.querySelector('input[name="_token"]').value;

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: new FormData(this)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        row.style.transition = "all 0.5s ease";
                        row.style.transform = "translateX(50px)";
                        row.style.opacity = "0";
                        setTimeout(() => row.remove(), 500);
                    } else {
                        alert('Something went wrong!');
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
    </script>
</x-app-layout>