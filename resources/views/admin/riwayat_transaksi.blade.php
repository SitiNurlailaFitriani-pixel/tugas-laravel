<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRIDAS BANK - Riwayat Transaksi</title>

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

    <!-- Sidebar Left -->
    <aside class="w-64 bg-[#0A2558] text-white flex flex-col justify-between p-4 min-h-screen shrink-0">
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
                </a>
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
                <a href="{{ route('admin.tarik_tunai.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition">
                    <i class="fa-solid fa-hand-holding-dollar w-5"></i>
                    Tarik Tunai
                </a>
                <a href="{{ route('admin.riwayat_transaksi.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-[#1E75D8] text-white font-medium">
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
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-4 py-3 text-gray-200 hover:text-white transition w-full text-left">
                    <i class="fa-solid fa-right-from-bracket w-5"></i>
                    Logout
                </button>
            </form>
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
    <main class="flex-1 p-8 md:p-10 flex items-start justify-center">
        
        <div class="w-full max-w-5xl bg-white rounded-3xl p-8 md:p-10 shadow-sm border border-slate-100 flex flex-col gap-6">
            
            <!-- Header Title -->
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-full bg-[#2b82d9] text-white flex items-center justify-center text-2xl shrink-0">
                    <i class="fa-solid fa-list-check"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-[#132863]">Riwayat Transaksi</h1>
                    <p class="text-slate-500 font-medium text-sm">Lihat semua transaksi nasabah</p>
                </div>
            </div>

            <!-- Filter Search & Tanggal -->
            <form action="{{ route('admin.riwayat_transaksi.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <!-- Search Box -->
                <div class="relative flex-1">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari transaksi..." 
                           class="w-full pl-11 pr-10 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-[#2b82d9] placeholder:text-slate-400 font-medium">
                    @if(request('search'))
                        <a href="{{ route('admin.riwayat_transaksi.index') }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    @endif
                </div>

                <!-- Tanggal Filter -->
                <div class="relative w-full sm:w-56">
                    <input type="date" name="tanggal" value="{{ $tanggal ?? '' }}" onchange="this.form.submit()"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-[#2b82d9] font-medium bg-white">
                </div>
            </form>

            <!-- Tabel Riwayat Transaksi -->
            <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#ebf3fc] text-[#132863] text-sm font-bold border-b border-slate-200">
                            <th class="py-4 px-6">Tanggal</th>
                            <th class="py-4 px-6">No. Rekening</th>
                            <th class="py-4 px-6">Username</th>
                            <th class="py-4 px-6">Tipe</th>
                            <th class="py-4 px-6">Nominal</th>
                            <th class="py-4 px-6 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700 font-medium">
                        @forelse($transaksi as $row)
                            @php
                                // 1. Ambil nilai status dari atribut yang tersedia
                                $rawStatus = $row->status ?? $row->status_transaksi ?? '';
                                
                                // 2. Normalisasi string (lowercase + trim)
                                $statusClean = strtolower(trim((string)$rawStatus));

                                // 3. Pengecekan variasi status
                                $isDitolak = in_array($statusClean, ['ditolak', 'gagal', 'reject', 'rejected', 'canceled', 'batal', '2', 'denied']);
                                $isPending = in_array($statusClean, ['pending', 'menunggu', 'process', 'proses', '0', 'waiting']);
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-4 px-6 text-slate-500 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y, H:i') }}
                                </td>
                                <td class="py-4 px-6 font-bold text-[#132863] whitespace-nowrap">
                                    {{ $row->no_rekening }}
                                </td>
                                <td class="py-4 px-6 text-slate-700 whitespace-nowrap">
                                    {{ $row->username }}
                                </td>
                                <td class="py-4 px-6 text-slate-700 whitespace-nowrap">
                                    {{ $row->jenis }}
                                </td>
                                <td class="py-4 px-6 font-bold whitespace-nowrap {{ $row->tipe == '+' ? 'text-emerald-600' : 'text-red-500' }}">
                                    {{ $row->tipe }} Rp {{ number_format($row->jumlah, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-6 text-center whitespace-nowrap">
                                    @if($isDitolak)
                                        <span class="inline-block px-4 py-1 rounded-full text-xs font-semibold text-red-600 bg-red-50 border border-red-400">
                                            Ditolak
                                        </span>
                                    @elseif($isPending)
                                        <span class="inline-block px-4 py-1 rounded-full text-xs font-semibold text-amber-600 bg-amber-50 border border-amber-400">
                                            Pending
                                        </span>
                                    @else
                                        <span class="inline-block px-4 py-1 rounded-full text-xs font-semibold text-emerald-600 bg-emerald-50 border border-emerald-400">
                                            Berhasil
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-10 text-center text-slate-400 font-medium">
                                    Belum ada data transaksi nasabah.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer Paginasi -->
            <div class="flex items-center justify-between pt-2 text-sm">
                <p class="text-gray-500 font-medium">
                    Menampilkan Halaman <span class="font-bold text-[#0c235b]">{{ method_exists($transaksi, 'currentPage') ? $transaksi->currentPage() : 1 }}</span> dari <span class="font-bold text-[#0c235b]">{{ method_exists($transaksi, 'lastPage') ? $transaksi->lastPage() : 1 }}</span>
                </p>
                <div class="flex items-center gap-2">
                    @if(method_exists($transaksi, 'onFirstPage') && $transaksi->onFirstPage())
                        <button class="px-3 py-1.5 rounded-lg text-gray-400 font-medium bg-gray-100 cursor-not-allowed text-xs flex items-center">
                            <i class="fa-solid fa-chevron-left text-[10px] mr-1"></i> Sebelumnya
                        </button>
                    @else
                        <a href="{{ method_exists($transaksi, 'previousPageUrl') ? $transaksi->previousPageUrl() : '#' }}" class="px-3 py-1.5 rounded-lg text-[#0c235b] font-bold bg-blue-50 hover:bg-blue-100 transition text-xs flex items-center">
                            <i class="fa-solid fa-chevron-left text-[10px] mr-1"></i> Sebelumnya
                        </a>
                    @endif

                    @if(method_exists($transaksi, 'hasMorePages') && $transaksi->hasMorePages())
                        <a href="{{ $transaksi->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg text-[#0c235b] font-bold bg-blue-50 hover:bg-blue-100 transition text-xs flex items-center gap-1">
                            Selanjutnya <i class="fa-solid fa-chevron-right text-[10px] ml-1"></i>
                        </a>
                    @else
                        <button class="px-3 py-1.5 rounded-lg text-gray-400 font-medium bg-gray-100 cursor-not-allowed text-xs flex items-center gap-1">
                            Selanjutnya <i class="fa-solid fa-chevron-right text-[10px] ml-1"></i>
                        </button>
                    @endif
                </div>
            </div>

        </div>
    </main>

</body>
</html>