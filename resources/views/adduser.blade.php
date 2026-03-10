<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
   <style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap');
    
    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        /* Animated Mesh Background */
        background: linear-gradient(-45deg, #f1f5f9, #e2e8f0, #e0e7ff, #f8fafc);
        background-size: 400% 400%;
        animation: meshGradient 15s ease infinite;
        min-height: 100vh;
    }

    @keyframes meshGradient {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Floating Card Effect */
    .premium-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.8);
        box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.08);
    }

    /* Input Field Styling */
    .premium-field {
        background: rgba(255, 255, 255, 0.5);
        border: 1px solid rgba(203, 213, 225, 0.5);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .premium-field:focus {
        background: white;
        border-color: #6366f1;
        box-shadow: 0 10px 20px -5px rgba(99, 102, 241, 0.15);
        transform: translateY(-1px);
    }

    /* Image Upload Box Enhancement */
    .upload-zone {
        background: linear-gradient(135deg, rgba(248, 250, 252, 0.8) 0%, rgba(241, 245, 249, 0.8) 100%);
        border: 2px dashed #cbd5e1;
        position: relative;
        transition: all 0.4s ease;
    }

    .upload-zone:hover {
        border-color: #6366f1;
        background: rgba(238, 242, 255, 0.8);
    }

    /* Price & Stock Boxes */
    .stat-box {
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .stat-box:focus-within {
        transform: scale(1.02);
        background: white !important;
        border-color: inherit;
        box-shadow: 0 15px 30px -10px rgba(0, 0, 0, 0.05);
    }

    /* Submit Button Glow */
    .btn-submit {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        position: relative;
        overflow: hidden;
    }

    .btn-submit::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 70%);
        opacity: 0;
        transition: opacity 0.3s;
    }

    .btn-submit:hover::after {
        opacity: 1;
    }

    .btn-submit:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 20px 40px -10px rgba(79, 70, 229, 0.4);
    }
</style>
</head>
<body class="antialiased flex items-center justify-center p-6">

    @if(session('success'))
    <div class="fixed top-6 right-6 z-50 alert-toast bg-white border-l-4 border-emerald-500 shadow-2xl p-4 rounded-xl flex items-center gap-4">
        <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center">
            <i class="fa-solid fa-check"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Success</p>
            <p class="text-slate-700 font-semibold">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <div class="max-w-3xl w-full bg-white/80 backdrop-blur-xl rounded-[3rem] shadow-[0_32px_64px_-12px_rgba(0,0,0,0.1)] border border-white p-8 md:p-14 relative">
        
        <div class="absolute top-0 right-0 p-8 opacity-10 pointer-events-none">
            <i class="fa-solid fa-boxes-stacked text-8xl text-indigo-600"></i>
        </div>

        <header class="mb-12 relative">
            <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">Add Product</h1>
            <p class="text-slate-500 mt-2 font-medium">List a new item with all its specifications.</p>
        </header>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 items-center">
                <div class="relative group h-48 bg-slate-100 rounded-[2rem] border-2 border-dashed border-slate-300 flex items-center justify-center overflow-hidden transition-all hover:border-indigo-400">
                    <img id="imagePreview" src="#" alt="Preview" class="hidden absolute inset-0 w-full h-full object-cover z-10">
                    <div id="placeholder" class="text-center z-0 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-camera text-3xl text-slate-400 mb-2"></i>
                        <p class="text-[10px] font-bold text-slate-400 uppercase">Upload</p>
                    </div>
            <input type="file" name="image" id="imageInput" class="absolute inset-0 opacity-0 z-20 cursor-pointer" onchange="previewImage(event)">
                </div>

                <div class="md:col-span-2 space-y-6">
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 block">Product Identity</label>
                        <input type="text" name="name" placeholder="Name of the product" class="premium-field w-full p-4 rounded-2xl font-semibold" required>
                    </div>
                    
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div class="p-6 bg-indigo-50/50 rounded-[2rem] border border-indigo-100">
                    <label class="text-[10px] font-black uppercase tracking-widest text-indigo-400 mb-3 block">Price Value</label>
                    <div class="flex items-center gap-2">
                        <span class="text-2xl font-bold text-indigo-600">$</span>
                        <input type="number" name="price" step="0.01" placeholder="0.00" class="bg-transparent border-none text-2xl font-bold text-indigo-600 focus:ring-0 w-full" required>
                    </div>
                </div>
                <div class="p-6 bg-emerald-50/50 rounded-[2rem] border border-emerald-100">
                    <label class="text-[10px] font-black uppercase tracking-widest text-emerald-400 mb-3 block">Total Stock</label>
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-cubes text-xl text-emerald-600"></i>
                        <input type="number" name="stock" placeholder="0" class="bg-transparent border-none text-2xl font-bold text-emerald-600 focus:ring-0 w-full" required>
                    </div>
                </div>
            </div>

            <div>
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 block">Item Description</label>
                <textarea name="description" rows="3" placeholder="Tell customers about this product..." class="premium-field w-full p-5 rounded-3xl font-medium resize-none"></textarea>
            </div>

            <div class="flex items-center gap-4 pt-6">
                <button type="button" onclick="window.history.back()" class="px-8 py-5 text-xs font-bold uppercase tracking-widest text-slate-400 hover:text-slate-600 transition-colors">Back</button>
                <button type="submit" class="btn-glow flex-1 py-5 bg-indigo-600 text-white rounded-[1.5rem] font-bold shadow-xl shadow-indigo-200 hover:bg-indigo-700 hover:-translate-y-1 transition-all flex items-center justify-center gap-3">
                    Confirm & List Product <i class="fa-solid fa-arrow-right-long"></i>
                </button>
            </div>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            const output = document.getElementById('imagePreview');
            const placeholder = document.getElementById('placeholder');
            reader.onload = function() {
                output.src = reader.result;
                output.classList.remove('hidden');
                placeholder.classList.add('opacity-0');
            };
            if(event.target.files[0]) reader.readAsDataURL(event.target.files[0]);
        }
    </script>

    
</body>
</html>