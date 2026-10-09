<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRIDAS BANK - Tarik Tunai</title>

     <!-- Favicon Logo SVG -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><circle cx='12' cy='12' r='12' fill='white'/><path d='M12 5L3 10v1h18v-1L12 5zm-6 8h2v6H6v-6zm4 0h2v6h-2v-6zm4 0h2v6h-2v-6zM4 20h16v2H4v-2z' fill='%230f172a'/></svg>">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#dbe8f6] min-h-screen flex">

    <!-- <!-- Sidebar Left -->
    <aside class="w-64 bg-[#0A2558] text-white flex flex-col justify-between p-4 min-h-screen">
        <div>
            <!-- Logo & Brand -->
            <div class="flex items-center gap-3 px-2 py-4 mb-4">
                <div class="bg-white text-[#0A2558] p-2 rounded-full w-10 h-10 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-building-columns text-lg"></i>
                </div>
                <div>
                    <h1 class="font-bold text-lg leading-tight tracking-wider">GRIDAS</h1>
                    <h2 class="font-bold text-lg leading-tight tracking-wider">BANK</h2>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="space-y-2">
                <a href="{{ route('admin.homeadmin') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition">
                    <i class="fa-solid fa-house w-5"></i>
                    Dashboard
               <a href="{{ route('admin.nasabah.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition">
    <i class="fa-solid fa-address-card w-5"></i>
    Data Nasabah
</a>
            
                <a href="{{ route('admin.rekening.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition">
                    <i class="fa-solid fa-id-card w-5"></i>
                    Data Rekening
                </a>
                <a href="{{ route('admin.setor_tunai.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition">
                    <i class="fa-solid fa-money-bill-transfer w-5"></i>
                    Setor Tunai
                </a>
                <a href="{{ route('admin.tarik_tunai.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-[#1E75D8] text-white font-medium">
                    <i class="fa-solid fa-hand-holding-dollar w-5"></i>
                    Tarik Tunai
                </a>
                <a href="{{ route('admin.riwayat_transaksi.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition">
                    <i class="fa-solid fa-list-check w-5"></i>
                    Riwayat Transaksi
                </a>
                <a href="{{ route('admin.laporan_transaksi.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition">
                    <i class="fa-solid fa-chart-line w-5"></i>
                    Laporan Transaksi
                </a>
            </nav>
        </div>

        <!-- Logout Button -->
        <div class="pt-4 border-t border-blue-900/40">
            <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-200 hover:text-white transition">
                <i class="fa-solid fa-right-from-bracket w-5"></i>
                Logout
            </a>
        </div>
    </aside>

             <!-- Konten Utama (Kanan) -->
    <main class="flex-1 p-8 flex flex-col justify-start h-screen overflow-y-auto">
        
        <!-- Top Bar Profil Header Admin -->
        <div class="flex justify-end mb-4">
            <div class="flex items-center gap-3 text-[#0c235b] font-bold text-base">
                <i class="fa-solid fa-circle-user text-4xl"></i>
                <span>Admin</span>
            </div>
        </div>

    <!-- Main Content Container -->
    <main class="flex-1 p-8 md:p-12 flex items-center justify-center">
        
        <div class="w-full max-w-3xl bg-white rounded-3xl p-8 md:p-10 shadow-sm border border-slate-100">
            
            <!-- Alert Sukses / Error -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-300 text-green-800 rounded-2xl text-sm font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-800 rounded-2xl text-sm font-semibold">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Header Title -->
            <div class="flex items-center gap-4 mb-8">
                <div class="w-14 h-14 rounded-full bg-[#2b82d9] text-white flex items-center justify-center text-2xl shrink-0">
                    <i class="fa-solid fa-hand-holding-dollar"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-[#132863]">Tarik Tunai</h1>
                    <p class="text-slate-500 font-medium text-sm">Ambil dana dari rekening anda</p>
                </div>
            </div>

            <!-- Form Tarik Tunai (Persis Sama Seperti Setor Tunai) -->
            <form action="{{ route('admin.tarik_tunai.store') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Field 1: Rekening -->
                <div>
                    <label for="no_rekening" class="block text-slate-800 font-bold mb-1.5 text-sm">Rekening</label>
                    <input type="text" id="no_rekening" name="no_rekening" value="{{ old('no_rekening') }}" placeholder="Masukan Rekening" required
                           class="w-full px-4 py-3 rounded-xl border border-[#132863] text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#2b82d9] placeholder:text-slate-400 font-medium">
                </div>

                <!-- Field 2: Jumlah Penarikan -->
                <div>
                    <label for="jumlah_penarikan" class="block text-slate-800 font-bold mb-1.5 text-sm">Jumlah Penarikan</label>
                    <div class="flex rounded-xl border border-[#132863] overflow-hidden focus-within:ring-2 focus-within:ring-[#2b82d9]">
                        <span class="px-5 py-3 text-slate-800 font-bold border-r border-[#132863] bg-white flex items-center justify-center">Rp</span>
                        <input type="number" id="jumlah_penarikan" name="jumlah_penarikan" value="{{ old('jumlah_penarikan') }}" min="10000" placeholder="" required
                               class="w-full px-4 py-3 text-slate-800 focus:outline-none font-medium">
                    </div>
                </div>

                <!-- Field 3: Keterangan -->
                <div>
                    <label for="keterangan" class="block text-slate-800 font-bold mb-1.5 text-sm">Keterangan</label>
                    <input type="text" id="keterangan" name="keterangan" value="{{ old('keterangan') }}" placeholder="Tuliskan keterangan"
                           class="w-full px-4 py-3 rounded-xl border border-[#132863] text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#2b82d9] placeholder:text-slate-400 font-medium">
                </div>

                <!-- Tombol Submit Capsule -->
                <div class="pt-6 flex justify-center">
                    <button type="submit" class="w-full max-w-xs py-3.5 bg-[#2b82d9] hover:bg-[#1d6cb8] text-white font-bold text-base rounded-2xl transition shadow-md">
                        Tarik Sekarang
                    </button>
                </div>
            </form>

        </div>

    </main>

</body>
</html>