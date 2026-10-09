@php
    /* Mengambil nama user dari variabel controller atau session */
    $username = $username ?? session('username', 'Nasabah');
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRIDAS BANK - Tarik Tunai</title>

     <!-- Favicon Logo SVG -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><circle cx='12' cy='12' r='12' fill='white'/><path d='M12 5L3 10v1h18v-1L12 5zm-6 8h2v6H6v-6zm4 0h2v6h-2v-6zm4 0h2v6h-2v-6zM4 20h16v2H4v-2z' fill='%230f172a'/></svg>">

    <!-- CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome untuk Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-[#dbe7f6] h-screen flex text-[#0c235b] overflow-hidden">

    <!-- Sidebar / Navigasi Kiri -->
    <aside class="w-72 bg-[#0c235b] text-white flex flex-col justify-between p-5 h-screen shrink-0">
        <div>
            <!-- Logo & Brand Name -->
            <div class="flex items-center gap-3 mb-6 px-2">
                <div class="w-9 h-9 rounded-full border-2 border-white flex items-center justify-center">
                    <i class="fa-solid fa-building-columns text-lg"></i>
                </div>
                <h1 class="text-xl font-bold tracking-wide">GRIDAS BANK</h1>
            </div>

            <!-- Menu Navigasi -->
            <nav class="space-y-2">
                <a href="{{ route('homenasabah') }}" class="flex items-center gap-3.5 text-white/90 hover:bg-[#13327b] px-4 py-2.5 rounded-xl font-medium transition text-sm">
                    <i class="fa-solid fa-house text-base w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('profil') }}" class="flex items-center gap-3.5 text-white/90 hover:bg-[#13327b] px-4 py-2.5 rounded-xl font-medium transition text-sm">
                    <i class="fa-solid fa-user text-base w-5 text-center"></i>
                    <span>Profil Rekening</span>
                </a>

                <!-- Tarik Tunai (Active) -->
                <a href="{{ route('tariktunai') }}" class="flex items-center gap-3.5 bg-[#2582ce] text-white px-4 py-2.5 rounded-xl font-semibold shadow-md transition text-sm">
                    <i class="fa-solid fa-wallet text-base w-5 text-center"></i>
                    <span>Tarik Tunai</span>
                </a>

                <a href="{{ route('nasabah.riwayat') }}" class="flex items-center gap-3.5 text-white/90 hover:bg-[#13327b] px-4 py-2.5 rounded-xl font-medium transition text-sm">
                    <i class="fa-solid fa-receipt text-base w-5 text-center"></i>
                    <span>Riwayat Transaksi</span>
                </a>
            </nav>
        </div>

        <!-- Section Logout -->
        <div class="pt-2">
            <hr class="border-white/20 mb-3">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-3 text-white/90 hover:text-red-300 px-3 py-1.5 font-semibold transition w-full text-left text-sm">
                    <i class="fa-solid fa-right-from-bracket text-xl rotate-180"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Konten Utama (Kanan) -->
    <main class="flex-1 p-8 flex flex-col justify-center items-center h-screen overflow-y-auto">
        
        <!-- Top Bar Profil Header -->
        <div class="w-full max-w-4xl flex justify-end mb-3">
            <a href="{{ route('profil') }}" class="flex items-center gap-2.5 text-[#0c235b] hover:opacity-80 transition font-bold text-base">
                <i class="fa-solid fa-circle-user text-3xl"></i>
                <span>{{ $username }}</span>
            </a>
        </div>

        <!-- Card Utama -->
        <div class="bg-white rounded-3xl p-8 shadow-sm w-full max-w-4xl space-y-6">
            
            <!-- Header Halaman -->
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-[#2582ce] text-white rounded-full flex items-center justify-center text-2xl shrink-0 shadow-sm">
                    <i class="fa-solid fa-wallet"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-[#0c235b]">Tarik Tunai</h2>
                    <p class="text-[#3b558e] font-medium text-sm">Ambil dana dari rekening Anda</p>
                </div>
            </div>

            <!-- Alert Informasi Konfirmasi Petugas -->
            <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded-r-xl shadow-sm flex items-start gap-3">
                <i class="fa-solid fa-circle-info text-amber-600 text-xl mt-0.5 shrink-0"></i>
                <div class="text-sm text-amber-900">
                    <p class="font-bold">Informasi Transaksi:</p>
                    <p class="mt-0.5 leading-relaxed">
                        Setelah melakukan pengajuan tarik tunai, silakan datangi teller/petugas Bank Gridas untuk melakukan konfirmasi dan pengambilan uang tunai secara langsung.
                    </p>
                </div>
            </div>

            <!-- Notifikasi Berhasil -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl text-sm flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="font-bold ml-4 text-lg line-none">&times;</button>
                </div>
            @endif

            <!-- Notifikasi Error/Gagal -->
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl text-sm flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-xmark"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="font-bold ml-4 text-lg line-none">&times;</button>
                </div>
            @endif

            <form action="{{ route('tariktunai.store') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Kotak Saldo Tersedia -->
                <div class="bg-[#eaf3fc] border-2 border-[#2582ce] rounded-2xl p-5 text-[#0c235b]">
                    <p class="text-xs font-semibold text-[#3b558e] mb-1">Saldo Tersedia</p>
                    <p class="text-3xl font-extrabold">
                        Rp {{ number_format($saldo ?? 0, 0, ',', '.') }}
                    </p>
                </div>

                <!-- Input Jumlah Penarikan -->
                <div>
                    <label for="nominal" class="block text-sm font-bold text-[#0c235b] mb-1.5">Jumlah Penarikan</label>
                    <div class="relative flex items-center">
                        <span class="absolute left-4 font-semibold text-[#0c235b] text-base border-r border-slate-300 pr-3 select-none">Rp</span>
                        <input 
                            type="number" 
                            name="nominal" 
                            id="nominal" 
                            placeholder="0" 
                            min="10000"
                            value="{{ old('nominal') }}"
                            class="w-full pl-16 pr-4 py-3.5 border-2 border-[#0c235b] rounded-xl font-medium focus:outline-none focus:border-[#2582ce] transition text-base"
                            required
                        >
                    </div>
                    @error('nominal')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Input Keterangan -->
                <div>
                    <label for="keterangan" class="block text-sm font-bold text-[#0c235b] mb-1.5">Keterangan</label>
                    <input 
                        type="text" 
                        name="keterangan" 
                        id="keterangan" 
                        placeholder="Tuliskan keterangan (opsional)"
                        value="{{ old('keterangan') }}"
                        class="w-full px-4 py-3.5 border-2 border-[#0c235b] rounded-xl font-medium focus:outline-none focus:border-[#2582ce] transition text-base"
                    >
                    @error('keterangan')
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Tombol Submit -->
                <div class="pt-2 flex justify-center">
                    <button type="submit" class="bg-[#2582ce] hover:bg-[#1a629d] text-white font-bold py-3.5 px-12 rounded-xl transition duration-200 text-base shadow-sm">
                        Tarik Sekarang
                    </button>
                </div>

            </form>

        </div>

    </main>

</body>
</html>