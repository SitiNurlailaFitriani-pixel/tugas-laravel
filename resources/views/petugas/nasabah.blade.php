<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRIDAS BANK - Data Nasabah</title>

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
                <!-- Dashboard -->
                <a href="{{ route('petugas.dashboard') }}" class="flex items-center gap-3.5 text-white/90 hover:bg-[#13327b] px-4 py-3 rounded-xl font-medium transition text-sm">
                    <i class="fa-solid fa-house text-lg w-6 text-center"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Data Nasabah (Active) -->
                <a href="{{ route('petugas.nasabah') }}" class="flex items-center gap-3.5 bg-[#2582ce] text-white px-4 py-3 rounded-xl font-semibold shadow-md transition text-sm">
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
        
        <!-- Top Bar Profil Header Petugas -->
        <div class="flex justify-end mb-4">
            <div class="flex items-center gap-3 text-[#0c235b] font-bold text-base">
                <i class="fa-solid fa-circle-user text-4xl"></i>
                <span>Petugas</span>
            </div>
        </div>

        <!-- Card Putih Utama -->
        <div class="bg-white rounded-3xl p-8 shadow-sm w-full space-y-6 flex-1 flex flex-col justify-between">
            
            <div>
                <!-- Header Title & Tombol Tambah Nasabah -->
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-[#0c235b]">Data Nasabah</h2>
                        <p class="text-slate-500 text-sm mt-0.5">Kelola data nasabah bank</p>
                    </div>
                    <a href="{{ route('register') }}" class="bg-[#2582ce] hover:bg-[#1d6fa8] text-white font-semibold px-5 py-2.5 rounded-xl shadow transition text-sm flex items-center gap-2">
                        <span>+ Tambah Nasabah</span>
                    </a>
                </div>

                <!-- Input Search -->
                <form action="{{ route('petugas.nasabah') }}" method="GET" class="mb-6">
                    <div class="relative w-full max-w-md">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-[#0c235b] text-base"></i>
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama atau username" 
                            class="w-full pl-11 pr-10 py-2.5 border-2 border-[#0c235b] rounded-full text-sm font-medium text-[#0c235b] placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#2582ce]">
                        @if($search)
                            <a href="{{ route('petugas.nasabah') }}" class="absolute right-4 top-1/2 -translate-y-1/2 text-[#0c235b] hover:text-red-500">
                                <i class="fa-solid fa-xmark text-lg"></i>
                            </a>
                        @endif
                    </div>
                </form>

                <!-- Tabel Data Nasabah -->
                <div class="overflow-x-auto border border-slate-200 rounded-xl">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#f0f4f9] text-[#0c235b] font-bold text-sm border-b border-slate-200">
                                <th class="py-3 px-4 border-r border-slate-200 w-12 text-center">No</th>
                                <th class="py-3 px-4 border-r border-slate-200">Nama</th>
                                <th class="py-3 px-4 border-r border-slate-200">Username</th>
                                <th class="py-3 px-4 border-r border-slate-200">E-mail</th>
                                <th class="py-3 px-4 border-r border-slate-200 text-center w-28">Status</th>
                                <th class="py-3 px-4 text-center w-24">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 text-sm font-medium text-slate-700">
                            @forelse($nasabah as $index => $item)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="py-3 px-4 border-r border-slate-200 text-center">
                                        {{ $nasabah->firstItem() + $index }}
                                    </td>
                                    <td class="py-3 px-4 border-r border-slate-200 font-semibold text-[#0c235b]">
                                        {{ $item->nama ?? $item->name ?? '-' }}
                                    </td>
                                    <td class="py-3 px-4 border-r border-slate-200">
                                        {{ $item->username ?? '-' }}
                                    </td>
                                    <td class="py-3 px-4 border-r border-slate-200">
                                        {{ $item->email ?? '-' }}
                                    </td>
                                    <td class="py-3 px-4 border-r border-slate-200 text-center">
                                        <span class="inline-block px-3 py-0.5 rounded-full border border-[#43a047] text-[#2e7d32] bg-[#eaf4ed] text-xs font-semibold">
                                            Aktif
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <form action="{{ route('petugas.nasabah.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus nasabah ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 transition text-lg">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-slate-400">
                                        Data nasabah belum tersedia atau tidak ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Custom Pagination Sesuai Desain Gambar -->
            <div class="flex justify-center items-center mt-6">
                @if ($nasabah->hasPages())
                    <div class="inline-flex items-center border border-slate-300 rounded-lg overflow-hidden bg-white text-sm">
                        {{-- Previous Page Link --}}
                        @if ($nasabah->onFirstPage())
                            <span class="px-3 py-1.5 text-slate-300 cursor-not-allowed border-r border-slate-200"><i class="fa-solid fa-chevron-left text-xs"></i></span>
                        @else
                            <a href="{{ $nasabah->previousPageUrl() }}" class="px-3 py-1.5 text-slate-600 hover:bg-slate-100 border-r border-slate-200"><i class="fa-solid fa-chevron-left text-xs"></i></a>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($nasabah->getUrlRange(1, $nasabah->lastPage()) as $page => $url)
                            @if ($page == $nasabah->currentPage())
                                <span class="px-3.5 py-1.5 bg-[#2582ce] text-white font-bold border-r border-slate-200">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="px-3.5 py-1.5 text-slate-600 hover:bg-slate-100 border-r border-slate-200 font-medium">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($nasabah->hasMorePages())
                            <a href="{{ $nasabah->nextPageUrl() }}" class="px-3 py-1.5 text-slate-600 hover:bg-slate-100"><i class="fa-solid fa-chevron-right text-xs"></i></a>
                        @else
                            <span class="px-3 py-1.5 text-slate-300 cursor-not-allowed"><i class="fa-solid fa-chevron-right text-xs"></i></span>
                        @endif
                    </div>
                @endif
            </div>

        </div>

    </main>

</body>
</html>