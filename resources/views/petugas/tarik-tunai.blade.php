<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRIDAS BANK - Tarik Tunai Petugas</title>

     <!-- Favicon Logo SVG -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><circle cx='12' cy='12' r='12' fill='white'/><path d='M12 5L3 10v1h18v-1L12 5zm-6 8h2v6H6v-6zm4 0h2v6h-2v-6zm4 0h2v6h-2v-6zM4 20h16v2H4v-2z' fill='%230f172a'/></svg>">

    <!-- CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-[#dbe7f6] h-screen flex text-[#122e6f] overflow-hidden">

    <!-- Sidebar Navigasi Kiri -->
    <aside class="w-72 bg-[#0c235b] text-white flex flex-col justify-between p-6 h-screen shrink-0">
        <div>
            <!-- Logo & Brand Name -->
            <div class="flex items-center gap-3 mb-8 px-2">
                <div class="w-10 h-10 rounded-full border-2 border-white flex items-center justify-center">
                    <i class="fa-solid fa-building-columns text-xl"></i>
                </div>
                <h1 class="text-xl font-bold tracking-wide">GRIDAS BANK</h1>
            </div>

            <!-- Menu Navigasi -->
            <nav class="space-y-3">
                <a href="{{ route('petugas.dashboard') }}" class="flex items-center gap-3.5 text-white/90 hover:bg-[#13327b] px-4 py-3 rounded-xl font-medium transition text-sm">
                    <i class="fa-solid fa-house text-lg w-6 text-center"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('petugas.nasabah') }}" class="flex items-center gap-3.5 text-white/90 hover:bg-[#13327b] px-4 py-3 rounded-xl font-medium transition text-sm">
                    <i class="fa-solid fa-users text-lg w-6 text-center"></i>
                    <span>Data Nasabah</span>
                </a>

                <a href="{{ route('petugas.setortunai') }}" class="flex items-center gap-3.5 text-white/90 hover:bg-[#13327b] px-4 py-3 rounded-xl font-medium transition text-sm">
                    <i class="fa-solid fa-money-bill-transfer text-lg w-6 text-center"></i>
                    <span>Setor Tunai</span>
                </a>

                <a href="{{ route('petugas.tariktunai') }}" class="flex items-center gap-3.5 bg-[#2582ce] text-white px-4 py-3 rounded-xl font-semibold shadow-md transition text-sm">
                    <i class="fa-solid fa-wallet text-lg w-6 text-center"></i>
                    <span>Tarik Tunai</span>
                </a>

                <a href="{{ route('petugas.riwayat') }}" class="flex items-center gap-3.5 text-white/90 hover:bg-[#13327b] px-4 py-3 rounded-xl font-medium transition text-sm">
                    <i class="fa-solid fa-receipt text-lg w-6 text-center"></i>
                    <span>Riwayat Transaksi</span>
                </a>
            </nav>
        </div>

        <!-- Section Logout -->
        <div>
            <hr class="border-white/20 mb-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-3 text-white/90 hover:text-red-300 px-3 py-2 font-semibold transition w-full text-left text-sm">
                    <i class="fa-solid fa-right-from-bracket text-xl rotate-180"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Konten Utama (Kanan) -->
    <main class="flex-1 p-8 flex flex-col justify-start h-screen overflow-y-auto">
        
        <!-- Top Bar Profil Header Petugas -->
        <div class="flex justify-end mb-4">
            <div class="flex items-center gap-3 text-[#0c235b] font-bold text-base">
                <i class="fa-solid fa-circle-user text-4xl"></i>
                <span>Petugas</span>
            </div>
        </div>

        <!-- Form Tarik Tunai Card Putih Utama -->
        <div class="bg-white rounded-3xl shadow-lg p-8 md:p-10 w-full max-w-3xl mx-auto">
            
            <!-- Header Form (Icon Samakan dengan Dashboard: fa-wallet & Warna Biru) -->
            <div class="flex items-center gap-4 mb-8 border-b border-slate-100 pb-6">
                <div class="w-14 h-14 bg-[#3B82F6] rounded-full flex items-center justify-center text-white text-2xl shadow-md shrink-0">
                    <i class="fa-solid fa-wallet"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-[#1E293B]">Tarik Tunai (Petugas)</h2>
                    <p class="text-slate-500 text-sm">Lakukan penarikan tunai dari rekening nasabah</p>
                </div>
            </div>

            <!-- Alert Notifikasi -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r shadow-sm text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r shadow-sm text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Form Tarik Tunai -->
            <form action="{{ route('petugas.tariktunai.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Input Nomor Rekening -->
                <div>
                    <label for="no_rekening" class="block text-slate-800 font-bold mb-2 text-sm">Nomor Rekening Nasabah</label>
                    <input 
                        type="text" 
                        id="no_rekening" 
                        name="no_rekening" 
                        placeholder="Masukkan nomor rekening nasabah" 
                        value="{{ old('no_rekening') }}"
                        class="w-full px-4 py-3 bg-[#F8FAFC] border border-[#1E293B] rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm transition-all @error('no_rekening') border-red-500 @enderror"
                        required
                    >
                    @error('no_rekening')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Jumlah Tarik -->
                <div>
                    <label for="jumlah" class="block text-slate-800 font-bold mb-2 text-sm">Jumlah Penarikan</label>
                    <div class="flex border border-[#1E293B] rounded-xl overflow-hidden bg-[#F8FAFC] focus-within:ring-2 focus-within:ring-blue-500">
                        <span class="px-5 py-3 text-slate-800 font-bold bg-transparent border-r border-[#1E293B] flex items-center text-sm">
                            Rp
                        </span>
                        <input 
                            type="number" 
                            id="jumlah" 
                            name="jumlah" 
                            placeholder="0" 
                            value="{{ old('jumlah') }}"
                            min="10000"
                            class="w-full px-4 py-3 bg-transparent text-slate-800 text-sm focus:outline-none"
                            required
                        >
                    </div>
                    @error('jumlah')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Keterangan -->
                <div>
                    <label for="keterangan" class="block text-slate-800 font-bold mb-2 text-sm">Keterangan</label>
                    <input 
                        type="text" 
                        id="keterangan" 
                        name="keterangan" 
                        placeholder="Tuliskan keterangan (opsional)" 
                        value="{{ old('keterangan') }}"
                        class="w-full px-4 py-3 bg-[#F8FAFC] border border-[#1E293B] rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm transition-all @error('keterangan') border-red-500 @enderror"
                    >
                    @error('keterangan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Submit (Biru) -->
                <div class="pt-4 flex justify-center">
                    <button 
                        type="submit" 
                        class="w-full sm:w-auto px-12 py-3.5 bg-[#3B82F6] hover:bg-blue-600 text-white font-bold rounded-xl shadow-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 text-sm"
                    >
                        Tarik Sekarang
                    </button>
                </div>
            </form>

        </div>

    </main>

</body>
</html>