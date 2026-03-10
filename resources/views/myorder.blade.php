<x-app-layout>
    @php
        $symbol = $currencySymbol; // Ye variable AppServiceProvider se aa raha hai
    @endphp

    <style>
        /* (Aapka existing CSS...) */
        body { background-color: #020617; font-family: 'Inter', sans-serif; color: #cbd5e1; }
        .table-wrapper { background: #0f172a; padding: 2rem; border-radius: 24px; box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5); border: 1px solid rgba(255, 255, 255, 0.05); margin: 20px auto; max-width: 1100px; }
        .table-header-title { color: #f8fafc; font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 12px; }
        .table-header-title i { color: #38bdf8; }
        table { width: 100%; border-spacing: 0 8px; border-collapse: separate; }
        th { background: rgba(30, 41, 59, 0.5); padding: 16px; color: #94a3b8; font-size: 0.75rem; text-transform: uppercase; border-radius: 12px; }
        tbody tr { background: rgba(30, 41, 59, 0.4); transition: 0.3s; }
        tbody tr:hover { background: rgba(51, 65, 85, 0.7); transform: scale(1.005); }
        td { padding: 16px; vertical-align: middle; border-radius: 12px; }
        .order-id { color: #60a5fa; font-family: monospace; font-weight: 600; }
        .items-badge { background: rgba(56, 189, 248, 0.1); color: #38bdf8; padding: 4px 12px; border-radius: 99px; font-size: 0.75rem; }
        .amount { color: #10b981; font-weight: 700; }
        .status-pill { padding: 6px 14px; border-radius: 8px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; }
        .status-pending { background: rgba(245, 158, 11, 0.1); color: #fbbf24; }
        .status-completed { background: rgba(16, 185, 129, 0.1); color: #34d399; }
        .status-cancelled { background: rgba(239, 68, 68, 0.1); color: #f87171; }
        .btn-view { background: linear-gradient(135deg, #2563eb, #1d4ed8); color: white; padding: 8px 18px; border-radius: 10px; font-size: 0.8rem; font-weight: 600; transition: 0.3s; box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3); border: none; }
        .modal-content { background: #0f172a !important; border: 1px solid rgba(255, 255, 255, 0.1) !important; border-radius: 24px !important; }
        .product-name-text { color: #38bdf8; font-weight: 600; }
        .qty-badge { background: #1e293b; color: #94a3b8; padding: 2px 8px; border-radius: 6px; }
        .subtotal-text { color: #f8fafc; font-weight: 600; }
        .grand-total-amount { color: #10b981; font-size: 1.5rem; font-weight: 800; }
    </style>

    <div class="modal fade" id="orderModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content text-white">
                <div class="modal-header border-bottom border-secondary">
                    <h5 class="modal-title fw-bold">
                        <i class="fa-solid fa-receipt me-2 text-info"></i> Order Details <span id="modalOrderId" class="text-info"></span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="modalLoading" class="text-center py-5">
                        <div class="spinner-border text-info" role="status"></div>
                        <p class="mt-2 text-secondary">Converting prices to {{ $currency }}...</p>
                    </div>

                    <div id="modalContent" style="display: none;">
                        <div class="table-responsive">
                            <table class="table table-dark table-borderless align-middle">
                                <thead class="text-secondary small text-uppercase">
                                    <tr>
                                        <th>Product</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody id="orderItemsTable"></tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-4 p-3 rounded-4" style="background: rgba(16, 185, 129, 0.05); border: 1px dashed rgba(16, 185, 129, 0.2);">
                            <span class="fw-bold">Grand Total ({{ $currency }})</span>
                            <span class="grand-total-amount" id="modalTotalAmount"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-wrapper">
        <h2 class="table-header-title">
            <i class="fa-solid fa-clock-rotate-left"></i> Order History
        </h2>

        <div class="overflow-x-auto">
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Items</th>
                        <th>Total ({{ $currency }})</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td><span class="order-id">#{{ $order->id }}</span></td>
                        <td>{{ $order->created_at->format('d M, Y') }}</td>
                        <td><span class="items-badge">{{ $order->orderItems->count() }} Items</span></td>
                        <td><span class="amount">{{ $currencySymbol }}{{ number_format($order->total_amount * $currentRate, 2) }}</span></td>
                        <td>
                            @php
                                $statusClass = match($order->status) {
                                    'pending' => 'status-pending',
                                    'completed' => 'status-completed',
                                    default => 'status-cancelled'
                                };
                            @endphp
                            <span class="status-pill {{ $statusClass }}">{{ $order->status }}</span>
                        </td>
                        <td class="text-center">
                            <button class="btn-view" onclick="showOrderDetails({{ $order->id }})">
                                <i class="fa-solid fa-eye me-1"></i> View
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Provider se aane wale rates ko JS mein pass kiya
        const currentRate = {{ $currentRate }};
        const currencySymbol = '{{ $currencySymbol }}';

        function formatVal(amount) {
            // Amount ko current rate se multiply karke format karna
            return (amount * currentRate).toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        function showOrderDetails(orderId) {
            const modalElement = document.getElementById('orderModal');
            const myModal = new bootstrap.Modal(modalElement);
            
            document.getElementById('modalOrderId').innerText = '#' + orderId;
            document.getElementById('modalLoading').style.display = 'block';
            document.getElementById('modalContent').style.display = 'none';
            
            myModal.show();

            fetch(`/order-details/${orderId}`)
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        let rows = '';
                        data.items.forEach(item => {
                            rows += `
                                <tr>
                                    <td><div class="product-name-text">${item.product_name}</div></td>
                                    <td class="text-center text-secondary">${currencySymbol}${formatVal(item.price)}</td>
                                    <td class="text-center"><span class="qty-badge">${item.quantity}</span></td>
                                    <td class="text-end subtotal-text">${currencySymbol}${formatVal(item.price * item.quantity)}</td>
                                </tr>`;
                        });

                        document.getElementById('orderItemsTable').innerHTML = rows;
                        document.getElementById('modalTotalAmount').innerText = currencySymbol + formatVal(data.total);
                        document.getElementById('modalLoading').style.display = 'none';
                        document.getElementById('modalContent').style.display = 'block';
                    }
                });
        }
    </script>
</x-app-layout>