<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Premium Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>

        .glass-card { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); }
        .premium-input { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .premium-input:focus { background: white; transform: translateY(-2px); box-shadow: 0 10px 20px -5px rgba(99, 102, 241, 0.1); }
        .floating-orb { position: absolute; width: 400px; height: 400px; filter: blur(100px); border-radius: 50%; z-index: -1; opacity: 0.3; }
   
    </style>
</head>
<body class="antialiased">
    
<div class="min-h-screen bg-[#f1f5f9] py-12 px-4 flex items-center justify-center relative overflow-hidden">
    <div class="floating-orb bg-indigo-400 -top-20 -left-20"></div>
    <div class="floating-orb bg-emerald-300 -bottom-20 -right-20"></div>

    <div class="max-w-2xl w-full glass-card rounded-[3rem] shadow-[0_32px_64px_-12px_rgba(0,0,0,0.1)] p-8 md:p-14 relative z-10">
        
        <header class="mb-12">
            <div class="flex items-center gap-3 mb-2">
                <span class="h-1 w-8 bg-indigo-600 rounded-full"></span>
                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-600">Inventory System</span>
            </div>
            <h2 class="text-4xl font-black text-slate-900 tracking-tight">Edit Product</h2>
            <p class="text-slate-500 mt-2 font-medium">Refining details for <span class="text-indigo-600 border-b-2 border-indigo-100">{{ $product->name }}</span></p>
        </header>

        <form id="edit-product-form" action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-10">
            @csrf
            @method('PUT') 

            <div class="relative group">
                <div class="flex flex-col items-center p-8 border-2 border-dashed border-slate-200 rounded-[2.5rem] bg-slate-50/50 transition-all group-hover:border-indigo-400 group-hover:bg-indigo-50/30">
                    <div class="relative mb-6">
                        @php $img_path = $product->image ? asset('products/' . $product->image) : 'https://via.placeholder.com/150'; @endphp
                        <img id="preview-img" src="{{ $img_path }}" class="w-40 h-40 object-cover rounded-3xl shadow-2xl ring-8 ring-white transition-transform group-hover:scale-105">
                    </div>
                    
                    <label class="cursor-pointer bg-slate-900 text-white px-8 py-3 rounded-2xl text-xs font-bold uppercase tracking-widest hover:bg-indigo-600 hover:scale-105 active:scale-95 transition-all shadow-lg">
                        <i class="fa-solid fa-cloud-arrow-up mr-2"></i> Replace Image
                        <input type="file" name="image" class="hidden" onchange="previewImage(event)">
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-2">Product Identity</label>
                    <input type="text" name="name" value="{{ $product->name }}" required class="premium-input w-full bg-slate-50 rounded-2xl p-5 text-slate-700 font-semibold border-2 border-transparent focus:border-indigo-500/20 focus:bg-white outline-none">
                </div>

                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-2 text-indigo-500">Retail Price</label>
                    <div class="relative">
                        <span class="absolute left-5 top-1/2 -translate-y-1/2 font-bold text-indigo-600">$</span>
                        <input type="number" name="price" step="0.01" value="{{ $product->price }}" required class="premium-input w-full bg-indigo-50/30 rounded-2xl p-5 pl-10 text-indigo-600 font-bold border-2 border-transparent focus:border-indigo-500/20 outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-2 text-emerald-500">Inventory Stock</label>
                    <div class="relative">
                        <span class="absolute left-5 top-1/2 -translate-y-1/2 text-emerald-600"><i class="fa-solid fa-box-archive"></i></span>
                        <input type="number" name="stock" value="{{ $product->stock }}" required class="premium-input w-full bg-emerald-50/30 rounded-2xl p-5 pl-12 text-emerald-700 font-bold border-2 border-transparent focus:border-emerald-500/20 outline-none">
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-6 mt-12 pt-10 border-t border-slate-100">
                <a href="{{ route('admindashboard') }}" class="text-xs font-black text-slate-400 uppercase tracking-widest hover:text-rose-500 transition-colors flex items-center gap-2">
                    <i class="fa-solid fa-arrow-left-long"></i> Discard
                </a>
                <button type="submit" id="submit-btn" class="flex-1 bg-indigo-600 text-white py-5 rounded-[1.5rem] font-bold shadow-xl shadow-indigo-200 hover:bg-indigo-700 hover:-translate-y-1 transition-all flex items-center justify-center gap-3">
                    <span id="btn-text">Save Changes</span>
                    <i id="btn-icon" class="fa-solid fa-check-double"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<div id="toast" class="hidden fixed top-5 right-5 bg-slate-900 text-white px-6 py-4 rounded-2xl shadow-2xl z-50 flex items-center gap-3 border border-indigo-500/30">
    <div class="bg-indigo-500 rounded-full p-1"><i class="fa-solid fa-check text-white text-xs"></i></div>
    <span class="font-bold text-sm">Product updated successfully!</span>
</div>

<script>

    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            document.getElementById('preview-img').src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }

   
    document.getElementById('edit-product-form').addEventListener('submit', function(e) {
        e.preventDefault(); 

        const form = this;
        const btn = document.getElementById('submit-btn');
        const btnText = document.getElementById('btn-text');
        const toast = document.getElementById('toast');
        const formData = new FormData(form);

        
        btn.disabled = true;
        btnText.innerText = "Updating...";
        btn.classList.add('opacity-50', 'pointer-events-none');

        fetch(form.action, {
            method: 'POST', 
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => {
            if (!res.ok) throw res;
            return res.json();
        })
        .then(data => {
            if(data.success) {
                toast.classList.remove('hidden');
                setTimeout(() => toast.classList.add('hidden'), 3000);
            }
        })
        .catch(err => {
            console.error(err);
            alert("Update failed. Please check your inputs.");
        })
        .finally(() => {
            btn.disabled = false;
            btnText.innerText = "Save Changes";
            btn.classList.remove('opacity-50', 'pointer-events-none');
        });
    });
</script>
</body>
</html>