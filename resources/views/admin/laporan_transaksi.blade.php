<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi - GRIDAS BANK</title>

     <!-- Favicon Logo SVG -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><circle cx='12' cy='12' r='12' fill='white'/><path d='M12 5L3 10v1h18v-1L12 5zm-6 8h2v6H6v-6zm4 0h2v6h-2v-6zm4 0h2v6h-2v-6zM4 20h16v2H4v-2z' fill='%230f172a'/></svg>">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen">

    <div class="flex">
        <!-- Sidebar Left -->
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
                    <a href="{{ route('admin.riwayat_transaksi.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition">
                        <i class="fa-solid fa-list-check w-5"></i>
                        Riwayat Transaksi
                    </a>
                    <a href="{{ route('admin.laporan_transaksi.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-[#1E75D8] text-white font-medium">
                        <i class="fa-solid fa-chart-line w-5"></i>
                        Laporan Transaksi
                    </a>
                </nav>
            </div>

            <!-- Logout Button -->
            <div class="pt-4 border-t border-blue-900/40">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-gray-200 hover:text-white transition">
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
        
        <!-- Main Content Area -->
        <main class="flex-1 p-6 md:p-10">
            <!-- Top Header -->
            <header class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900">Laporan Transaksi</h2>
                    <p class="text-sm text-slate-500">Rekapitulasi dan pembukuan seluruh transaksi nasabah.</p>
                </div>
            </header>

            <!-- Card Summary / Statistik Ringkas -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-[#2b82d9] flex items-center justify-center text-xl">
                        <i class="fa-solid fa-list-check"></i>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Total Transaksi Filtered</p>
                        <h3 class="text-2xl font-bold text-slate-900">{{ method_exists($transaksi, 'total') ? $transaksi->total() : $transaksi->count() }} Data</h3>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-money-bill-wave"></i>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Total Nominal Filtered</p>
                        <h3 class="text-2xl font-bold text-emerald-600">
                            Rp {{ number_format($totalNominal ?? 0, 0, ',', '.') }}
                        </h3>
                    </div>
                </div>
            </div>

            <!-- Main Card Container -->
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 md:p-8">
                
                <!-- Filter & Search Form -->
                <form action="{{ route('admin.laporan_transaksi.index') }}" method="GET" class="mb-8 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Search Input -->
                        <div class="relative md:col-span-2">
                            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Cari no. rekening / username..."
                                   class="w-full pl-11 pr-4 py-3 rounded-2xl border border-slate-200 text-slate-700 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-[#2b82d9] bg-slate-50/50">
                        </div>

                        <!-- Filter Jenis Transaksi -->
                        <div>
                            <select name="jenis" class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-slate-700 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-[#2b82d9] bg-slate-50/50">
                                <option value="">Semua Jenis Transaksi (Setor & Tarik)</option>
                                <option value="Setor Tunai" {{ request('jenis') == 'Setor Tunai' || request('jenis') == 'setor' ? 'selected' : '' }}>Setor Tunai</option>
                                <option value="Tarik Tunai" {{ request('jenis') == 'Tarik Tunai' || request('jenis') == 'tarik' ? 'selected' : '' }}>Tarik Tunai</option>
                            </select>
                        </div>

                        <!-- Filter Tanggal -->
                        <div>
                            <input type="date" name="tanggal" value="{{ request('tanggal') }}" 
                                   class="w-full px-4 py-3 rounded-2xl border border-slate-200 text-slate-700 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-[#2b82d9] bg-slate-50/50">
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between gap-3 pt-2">
                        <div class="flex items-center gap-2">
                            <button type="submit" class="px-5 py-2.5 bg-[#2b82d9] text-white rounded-xl text-sm font-semibold hover:bg-blue-600 transition flex items-center gap-2">
                                <i class="fa-solid fa-filter"></i> Terapkan Filter
                            </button>

                            @if(request('search') || request('jenis') || request('tanggal'))
                                <a href="{{ route('admin.laporan_transaksi.index') }}" class="px-4 py-2.5 bg-slate-200 text-slate-600 rounded-xl text-sm font-semibold hover:bg-slate-300 transition">
                                    Reset
                                </a>
                            @endif
                        </div>

                        <!-- Tombol Cetak -->
                        <button type="submit" 
                                formaction="{{ route('admin.laporan_transaksi.cetak') }}" 
                                formtarget="_blank" 
                                class="px-5 py-2.5 bg-emerald-600 text-white rounded-xl text-sm font-semibold hover:bg-emerald-700 transition flex items-center gap-2">
                            <i class="fa-solid fa-print"></i> Cetak Laporan
                        </button>
                    </div>
                </form>

                <!-- Data Table -->
                <div class="overflow-x-auto rounded-2xl border border-slate-100">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-100">
                                <th class="py-4 px-6">#</th>
                                <th class="py-4 px-6">Tanggal & Waktu</th>
                                <th class="py-4 px-6">No. Rekening</th>
                                <th class="py-4 px-6">Nasabah</th>
                                <th class="py-4 px-6 text-center">Jenis Transaksi</th>
                                <th class="py-4 px-6 text-center">Status</th>
                                <th class="py-4 px-6 text-right">Nominal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                            @forelse($transaksi as $index => $item)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="py-4 px-6 text-slate-400">
                                        {{ method_exists($transaksi, 'firstItem') ? $transaksi->firstItem() + $index : $index + 1 }}
                                    </td>
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($item->created_at ?? $item->tanggal)->translatedFormat('d M Y, H:i') }}
                                    </td>
                                    <td class="py-4 px-6 font-mono text-slate-800 whitespace-nowrap">
                                        {{ $item->no_rekening }}
                                    </td>
                                    <td class="py-4 px-6 whitespace-nowrap">
                                        {{ $item->username ?? $item->nama_nasabah ?? '-' }}
                                    </td>
                                    <td class="py-4 px-6 text-center whitespace-nowrap">
                                        @if(in_array(strtolower($item->jenis_transaksi ?? $item->jenis ?? ''), ['setor', 'setor_tunai', 'setor tunai']))
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                                <i class="fa-solid fa-arrow-up text-[10px]"></i> Setor Tunai
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-600 border border-rose-200">
                                                <i class="fa-solid fa-arrow-down text-[10px]"></i> Tarik Tunai
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-center whitespace-nowrap">
                                        @if(strtolower($item->status ?? '') == 'pending')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-600 border border-amber-200">
                                                <i class="fa-solid fa-clock text-[10px]"></i> Pending
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                                <i class="fa-solid fa-circle-check text-[10px]"></i> Berhasil
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-right font-bold text-slate-900 whitespace-nowrap">
                                        Rp {{ number_format($item->nominal ?? $item->jumlah ?? 0, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-12 text-center text-slate-400 font-normal">
                                        <i class="fa-regular fa-folder-open text-4xl mb-3 block"></i>
                                        Tidak ada data laporan transaksi yang ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Custom Pagination Footer -->
                @if(method_exists($transaksi, 'currentPage'))
                <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-slate-100">
                    <p class="text-sm text-slate-500 font-medium">
                        Menampilkan Halaman <span class="font-bold text-slate-900">{{ $transaksi->currentPage() }}</span> dari <span class="font-bold text-slate-900">{{ $transaksi->lastPage() }}</span>
                    </p>

                    <div class="flex items-center gap-2">
                        @if ($transaksi->onFirstPage())
                            <span class="px-4 py-2 bg-slate-100 text-slate-400 rounded-xl text-sm font-semibold cursor-not-allowed flex items-center gap-1">
                                <i class="fa-solid fa-chevron-left text-xs"></i> Sebelumnya
                            </span>
                        @else
                            <a href="{{ $transaksi->appends(request()->query())->previousPageUrl() }}" class="px-4 py-2 bg-slate-100 text-slate-600 hover:bg-slate-200 rounded-xl text-sm font-semibold transition flex items-center gap-1">
                                <i class="fa-solid fa-chevron-left text-xs"></i> Sebelumnya
                            </a>
                        @endif

                        @if ($transaksi->hasMorePages())
                            <a href="{{ $transaksi->appends(request()->query())->nextPageUrl() }}" class="px-4 py-2 bg-blue-50 text-[#0A2558] hover:bg-blue-100 rounded-xl text-sm font-bold transition flex items-center gap-1">
                                Selanjutnya <i class="fa-solid fa-chevron-right text-xs"></i>
                            </a>
                        @else
                            <span class="px-4 py-2 bg-slate-100 text-slate-400 rounded-xl text-sm font-bold cursor-not-allowed flex items-center gap-1">
                                Selanjutnya <i class="fa-solid fa-chevron-right text-xs"></i>
                            </span>
                        @endif
                    </div>
                </div>
                @endif

            </div>
        </main>
    </div>

</body>
</html>