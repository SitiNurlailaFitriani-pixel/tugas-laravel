<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRIDAS BANK - Dashboard Petugas</title>

     <!-- Favicon Logo SVG -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><circle cx='12' cy='12' r='12' fill='white'/><path d='M12 5L3 10v1h18v-1L12 5zm-6 8h2v6H6v-6zm4 0h2v6h-2v-6zm4 0h2v6h-2v-6zM4 20h16v2H4v-2z' fill='%230f172a'/></svg>">

    <!-- CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Alpine.js untuk interaksi Dropdown Notifikasi -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
                <!-- Dashboard (Active) -->
                <a href="{{ route('petugas.dashboard') }}" class="flex items-center gap-3.5 bg-[#2582ce] text-white px-4 py-3 rounded-xl font-semibold shadow-md transition text-sm">
                    <i class="fa-solid fa-house text-lg w-6 text-center"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Data Nasabah -->
                <a href="{{ route('petugas.nasabah') }}" class="flex items-center gap-3.5 text-white/90 hover:bg-[#13327b] px-4 py-3 rounded-xl font-medium transition text-sm">
                    <i class="fa-solid fa-users text-lg w-6 text-center"></i>
                    <span>Data Nasabah</span>
                </a>

                <!-- Setor Tunai -->
                <a href="{{ route('petugas.setortunai') }}" class="flex items-center gap-3.5 text-white/90 hover:bg-[#13327b] px-4 py-3 rounded-xl font-medium transition text-sm">
                    <i class="fa-solid fa-money-bill-transfer text-lg w-6 text-center"></i>
                    <span>Setor Tunai</span>
                </a>

                <!-- Tarik Tunai -->
                <a href="{{ route('petugas.tariktunai') }}" class="flex items-center gap-3.5 text-white/90 hover:bg-[#13327b] px-4 py-3 rounded-xl font-medium transition text-sm">
                    <i class="fa-solid fa-wallet text-lg w-6 text-center"></i>
                    <span>Tarik Tunai</span>
                </a>

                <!-- Riwayat Transaksi -->
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
        
        <!-- Top Bar Profil Header Petugas & Notifikasi -->
        <div class="flex justify-end items-center gap-6 mb-4">
            
            @php
                $pendingCount = isset($pendingList) ? count($pendingList) : 0;
            @endphp
            
            <div class="relative" x-data="{ open: false }">
                <!-- Tombol Lonceng dengan Badge Bulat Merah -->
                <button 
                    @click="open = !open" 
                    class="w-12 h-12 bg-[#e8f1fb] text-[#0c235b] rounded-full flex items-center justify-center hover:bg-[#d5e4f7] transition relative focus:outline-none"
                    title="Konfirmasi Transaksi"
                >
                    <i class="fa-solid fa-bell text-xl"></i>
                    
                    @if($pendingCount > 0)
                        <span class="absolute top-0 right-0 bg-[#f05252] text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center border-2 border-white shadow-sm">
                            {{ $pendingCount > 99 ? '99+' : $pendingCount }}
                        </span>
                    @endif
                </button>

                <!-- Card Dropdown Notifikasi -->
                <div 
                    x-show="open" 
                    @click.outside="open = false" 
                    x-transition
                    class="absolute right-0 mt-3 w-96 bg-white rounded-2xl shadow-2xl overflow-hidden z-50 text-left border border-gray-100"
                    style="display: none;"
                >
                    <!-- Header Warna Biru Gelap -->
                    <div class="bg-[#0b235a] text-white px-5 py-3.5 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-rotate-left text-lg"></i>
                            <h4 class="text-base font-bold tracking-wide">Konfirmasi Transaksi</h4>
                        </div>
                        <span class="bg-[#f2b705] text-[#0b235a] text-xs font-extrabold px-3 py-1 rounded-full shadow-sm">
                            {{ $pendingCount }} Pending
                        </span>
                    </div>

                    <!-- Isi / List Item Notifikasi -->
                    <div class="p-4 space-y-4 max-h-80 overflow-y-auto">
                        @forelse($pendingList as $item)
                            <div class="border-b border-gray-100 pb-3 last:border-b-0 last:pb-0">
                                <div class="flex items-start gap-3">
                                    <!-- Icon Tangan Dolar Warna Kuning/Oranye -->
                                    <div class="w-11 h-11 bg-[#f5a623] text-white rounded-full flex items-center justify-center shrink-0 shadow-sm">
                                        <i class="fa-solid fa-hand-holding-dollar text-xl"></i>
                                    </div>

                                    <!-- Detail Informasi Permintaan -->
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <h5 class="font-bold text-[#0b235a] text-sm">{{ $item->nama }}</h5>
                                            <span class="text-[11px] text-gray-400 font-medium">{{ $item->waktu }}</span>
                                        </div>

                                        <p class="text-xs text-gray-600 mt-0.5">
                                            Pengajuan <span class="font-bold text-gray-800">{{ $item->jenis }}</span> sebesar 
                                            <span class="text-[#00a86b] font-bold">Rp {{ number_format($item->nominal, 0, ',', '.') }}</span>
                                        </p>

                                        <p class="text-[11px] text-gray-400 italic mt-0.5">
                                            Rekening: {{ $item->rekening }}
                                        </p>

                                        <!-- Tombol Setujui dan Tolak -->
                                        <div class="flex items-center gap-2 mt-3">
                                            <form action="{{ route('petugas.tariktunai.setujui', $item->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-[#009661] hover:bg-[#007d51] text-white text-xs font-bold px-3.5 py-1.5 rounded-lg flex items-center gap-1.5 transition shadow-sm">
                                                    <i class="fa-solid fa-check text-xs"></i>
                                                    <span>Setujui</span>
                                                </button>
                                            </form>

                                            <form action="{{ route('petugas.tariktunai.tolak', $item->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-[#dc2626] hover:bg-[#b91c1c] text-white text-xs font-bold px-3.5 py-1.5 rounded-lg flex items-center gap-1.5 transition shadow-sm">
                                                    <i class="fa-solid fa-xmark text-xs"></i>
                                                    <span>Tolak</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="py-6 text-center text-gray-400 text-xs">
                                Tidak ada permintaan transaksi yang pending.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Profile Info -->
            <div class="flex items-center gap-3 text-[#0c235b] font-bold text-base border-l border-gray-300 pl-4">
                <i class="fa-solid fa-circle-user text-3xl"></i>
                <span>Petugas</span>
            </div>
        </div>

        <!-- Card Putih Utama -->
        <div class="bg-white rounded-3xl p-8 shadow-sm w-full space-y-8 flex-1">

        <!-- Alert Sukses (Persis seperti gambar) -->
@if(session('success'))
    <div class="mb-6 bg-[#d1fadf] border border-[#a6f4c5] text-[#027a48] px-5 py-3.5 rounded-2xl flex items-center gap-3 text-sm font-semibold shadow-sm">
        <div class="w-5 h-5 rounded-full bg-[#12b76a] text-white flex items-center justify-center shrink-0">
            <i class="fa-solid fa-check text-xs"></i>
        </div>
        <span>{{ session('success') }}</span>
    </div>
@endif

<!-- Alert Ditolak / Error -->
@if(session('error'))
    <div class="mb-6 bg-[#fee4e2] border border-[#fecdca] text-[#b42318] px-5 py-3.5 rounded-2xl flex items-center gap-3 text-sm font-semibold shadow-sm">
        <div class="w-5 h-5 rounded-full bg-[#f04438] text-white flex items-center justify-center shrink-0">
            <i class="fa-solid fa-xmark text-xs"></i>
        </div>
        <span>{{ session('error') }}</span>
    </div>
@endif
            
            <!-- Header Menyapa Petugas -->
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-[#0c235b] flex items-center gap-2">
                    Selamat datang, Petugas 👋
                </h2>
            </div>

            <!-- Grid Ringkasan Total Nasabah & Transaksi Hari Ini -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Box Total Nasabah -->
                <div class="border-2 border-[#0c235b] rounded-2xl p-6 flex items-center gap-5">
                    <div class="w-16 h-16 bg-[#0c235b] text-white rounded-full flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-users text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-[#0c235b]">Total Nasabah</p>
                        <p class="text-3xl font-extrabold text-[#0c235b] mt-1">
                            {{ number_format($totalNasabah ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <!-- Box Transaksi Hari Ini -->
                <div class="border-2 border-[#0c235b] rounded-2xl p-6 flex items-center gap-5">
                    <div class="w-16 h-16 bg-[#0c235b] text-white rounded-full flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-list-check text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-[#0c235b]">Transaksi hari ini</p>
                        <p class="text-3xl font-extrabold text-[#0c235b] mt-1">
                            {{ number_format($transaksiHariIni ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

            </div>

            <!-- Layanan / Menu Cepat -->
            <div>
                <h3 class="text-lg font-bold text-[#0c235b] mb-4">Layanan</h3>
                
                <div class="flex flex-wrap gap-4">

                    <!-- Data Nasabah -->
                    <a href="{{ route('petugas.nasabah') }}" class="w-28 h-28 bg-[#e3e8f4] border-2 border-[#3b558e] rounded-2xl flex flex-col items-center justify-center p-2 hover:scale-105 transition shadow-sm">
                        <div class="w-11 h-11 bg-[#0c235b] text-white rounded-full flex items-center justify-center mb-1">
                            <i class="fa-solid fa-users text-lg"></i>
                        </div>
                        <span class="text-xs font-bold text-[#0c235b] text-center leading-tight">Data<br>Nasabah</span>
                    </a>

                    <!-- Setor Tunai -->
                    <a href="{{ route('petugas.setortunai') }}" class="w-28 h-28 bg-[#eaf4ed] border-2 border-[#43a047] rounded-2xl flex flex-col items-center justify-center p-2 hover:scale-105 transition shadow-sm">
                        <div class="w-11 h-11 bg-[#43a047] text-white rounded-full flex items-center justify-center mb-1">
                            <i class="fa-solid fa-money-bill-transfer text-lg"></i>
                        </div>
                        <span class="text-xs font-bold text-[#2e7d32] text-center leading-tight">Setor Tunai</span>
                    </a>

                    <!-- Tarik Tunai -->
                    <a href="{{ route('petugas.tariktunai') }}" class="w-28 h-28 bg-[#fef2e8] border-2 border-[#fb8c00] rounded-2xl flex flex-col items-center justify-center p-2 hover:scale-105 transition shadow-sm">
                        <div class="w-11 h-11 bg-[#fb8c00] text-white rounded-full flex items-center justify-center mb-1">
                            <i class="fa-solid fa-wallet text-lg"></i>
                        </div>
                        <span class="text-xs font-bold text-[#e65100] text-center leading-tight">Tarik Tunai</span>
                    </a>

                    <!-- Riwayat Transaksi -->
                    <a href="{{ route('petugas.riwayat') }}" class="w-28 h-28 bg-[#e8f1fb] border-2 border-[#1e88e5] rounded-2xl flex flex-col items-center justify-center p-2 hover:scale-105 transition shadow-sm">
                        <div class="w-11 h-11 bg-[#1e88e5] text-white rounded-full flex items-center justify-center mb-1">
                            <i class="fa-solid fa-receipt text-lg"></i>
                        </div>
                        <span class="text-xs font-bold text-[#1565c0] text-center leading-tight">Riwayat<br>Transaksi</span>
                    </a>

                </div>
            </div>

        </div>

    </main>

</body>
</html>