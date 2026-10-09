@php
    $username = $username ?? session('username', 'Nasabah');
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRIDAS BANK - Riwayat Transaksi</title>

     <!-- Favicon Logo SVG -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><circle cx='12' cy='12' r='12' fill='white'/><path d='M12 5L3 10v1h18v-1L12 5zm-6 8h2v6H6v-6zm4 0h2v6h-2v-6zm4 0h2v6h-2v-6zM4 20h16v2H4v-2z' fill='%230f172a'/></svg>">

    <!-- CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome (Icon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Font Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-[#dbe7f6] h-screen flex text-[#0c235b] overflow-hidden">

    <!-- Sidebar Left Nasabah -->
    <aside class="w-72 bg-[#0c235b] text-white flex flex-col justify-between p-5 h-screen shrink-0">
        <div>
            <!-- Logo Grid/Bank -->
            <div class="flex items-center gap-3 mb-6 px-2">
                <div class="w-9 h-9 rounded-full border-2 border-white flex items-center justify-center">
                    <i class="fa-solid fa-building-columns text-lg"></i>
                </div>
                <h1 class="text-xl font-bold tracking-wide">GRIDAS BANK</h1>
            </div>

            <!-- Menu Sidebar khusus NASABAH -->
            <nav class="space-y-2">
                <a href="{{ route('homenasabah') }}" class="flex items-center gap-3.5 text-white/90 hover:bg-[#13327b] px-4 py-2.5 rounded-xl font-medium transition text-sm">
                    <i class="fa-solid fa-house text-base w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('profil') }}" class="flex items-center gap-3.5 text-white/90 hover:bg-[#13327b] px-4 py-2.5 rounded-xl font-medium transition text-sm">
                    <i class="fa-solid fa-user text-base w-5 text-center"></i>
                    <span>Profil Rekening</span>
                </a>
                <a href="{{ route('tariktunai') }}" class="flex items-center gap-3.5 text-white/90 hover:bg-[#13327b] px-4 py-2.5 rounded-xl font-medium transition text-sm">
                    <i class="fa-solid fa-wallet text-base w-5 text-center"></i>
                    <span>Tarik Tunai</span>
                </a>
                <!-- Riwayat Transaksi (Active) -->
                <a href="{{ route('nasabah.riwayat') }}" class="flex items-center gap-3.5 bg-[#2582ce] text-white px-4 py-2.5 rounded-xl font-semibold shadow-md transition text-sm">
                    <i class="fa-solid fa-receipt text-base w-5 text-center"></i>
                    <span>Riwayat Transaksi</span>
                </a>
            </nav>
        </div>

        <!-- Tombol Logout -->
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

    <!-- Konten Utama -->
    <main class="flex-1 p-8 h-screen overflow-y-auto">
        
        <!-- Top Bar Profil Header -->
        <div class="w-full max-w-5xl mx-auto flex justify-end mb-6">
            <a href="{{ route('profil') }}" class="flex items-center gap-2.5 text-[#0c235b] hover:opacity-80 transition font-bold text-base">
                <i class="fa-solid fa-circle-user text-3xl"></i>
                <span>{{ $username }}</span>
            </a>
        </div>

        <!-- Card Utama -->
        <div class="bg-white rounded-3xl p-8 shadow-sm w-full max-w-5xl mx-auto space-y-6">
            
            <!-- Header Halaman -->
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-[#2582ce] text-white rounded-full flex items-center justify-center text-2xl shrink-0 shadow-sm">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-[#0c235b]">Riwayat Transaksi</h2>
                    <p class="text-[#3b558e] font-medium text-sm">Lihat semua transaksi anda</p>
                </div>
            </div>

            <!-- Filter & Search Bar -->
            <form action="{{ route('nasabah.riwayat') }}" method="GET" class="flex flex-wrap items-center gap-3">
                <!-- Search Input -->
                <div class="relative flex-1 min-w-[240px]">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input 
                        type="text" 
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari transaksi..." 
                        class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-xl text-sm focus:outline-none focus:border-[#2582ce] transition"
                    >
                </div>

                <!-- Input Filter Tanggal -->
                <div class="min-w-[160px]">
                    <input 
                        type="date" 
                        name="tanggal"
                        value="{{ request('tanggal') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:outline-none focus:border-[#2582ce] text-gray-600 transition"
                        onchange="this.form.submit()"
                    >
                </div>

                <!-- Tombol Submit Cari -->
                <button type="submit" class="px-4 py-2 bg-[#2582ce] hover:bg-[#1e6cb0] text-white rounded-xl text-xs font-semibold transition">
                    Cari
                </button>
                
                <!-- Tombol Reset Filter jika sedang memfilter -->
                @if(request('search') || request('tanggal'))
                    <a href="{{ route('nasabah.riwayat') }}" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl text-xs font-semibold transition">
                        Reset
                    </a>
                @endif
            </form>

            <!-- Tabel Transaksi -->
            <div class="overflow-x-auto border border-gray-200 rounded-xl">
                <table class="w-full text-left border-collapse min-w-[650px]">
                    <thead>
                        <tr class="bg-[#eaf3fc] text-[#0c235b] text-sm">
                            <th class="py-3 px-4 font-bold">Tanggal</th>
                            <th class="py-3 px-4 font-bold">No. Rekening</th>
                            <th class="py-3 px-4 font-bold">Username</th>
                            <th class="py-3 px-4 font-bold">Tipe</th>
                            <th class="py-3 px-4 font-bold">Nominal</th>
                            <th class="py-3 px-4 font-bold text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-200">
                        @forelse ($transaksi as $item)
                            @php
                                $tipe = strtolower($item->jenis_transaksi ?? '');
                                $isSetor = ($tipe == 'setor' || $tipe == 'setor tunai');
                                // DEFAULTING STATUS: Gunakan status bawaan item tanpa berasumsi 'berhasil'
                                $status = strtolower($item->status ?? 'pending');
                            @endphp
                            <tr class="hover:bg-gray-50 transition">
                                <td class="py-3.5 px-4 text-gray-600 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($item->created_at)->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
                                </td>
                                <td class="py-3.5 px-4 font-bold text-[#0c235b] whitespace-nowrap">
                                    {{ $item->no_rekening ?? '-' }}
                                </td>
                                <td class="py-3.5 px-4 text-[#0c235b] whitespace-nowrap">
                                    {{ $username }}
                                </td>
                                <td class="py-3.5 px-4 text-[#0c235b] whitespace-nowrap">
                                    {{ $isSetor ? 'Setor Tunai' : 'Tarik Tunai' }}
                                </td>
                                <td class="py-3.5 px-4 font-bold whitespace-nowrap {{ $isSetor ? 'text-green-600' : 'text-red-500' }}">
                                    {{ $isSetor ? '+ ' : '- ' }}Rp {{ number_format($item->nominal ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                    @if($status == 'pending')
                                        <span class="px-3 py-1 border border-amber-400 bg-amber-50 text-amber-600 rounded-lg text-xs font-semibold inline-block">
                                            Pending
                                        </span>
                                    @elseif($status == 'ditolak' || $status == 'gagal')
                                        <span class="px-3 py-1 border border-red-400 bg-red-50 text-red-600 rounded-lg text-xs font-semibold inline-block">
                                            Ditolak
                                        </span>
                                    @else
                                        <span class="px-3 py-1 border border-green-400 bg-green-50 text-green-600 rounded-lg text-xs font-semibold inline-block">
                                            Berhasil
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-400 font-medium">
                                    Belum ada riwayat transaksi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer & Navigasi Paginasi Dinamis -->
            <div class="flex items-center justify-between pt-2 text-sm">
                <p class="text-gray-500 font-medium">
                    Menampilkan Halaman <span class="font-bold text-[#0c235b]">{{ $transaksi->currentPage() }}</span> 
                    dari <span class="font-bold text-[#0c235b]">{{ $transaksi->lastPage() }}</span>
                </p>
                <div class="flex items-center gap-2">
                    <!-- Tombol Sebelumnya -->
                    @if ($transaksi->onFirstPage())
                        <span class="px-3 py-1.5 rounded-lg text-gray-400 font-medium bg-gray-100 cursor-not-allowed text-xs">
                            <i class="fa-solid fa-chevron-left text-[10px] mr-1"></i> Sebelumnya
                        </span>
                    @else
                        <a href="{{ $transaksi->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg text-[#0c235b] font-bold bg-blue-50 hover:bg-blue-100 transition text-xs flex items-center">
                            <i class="fa-solid fa-chevron-left text-[10px] mr-1"></i> Sebelumnya
                        </a>
                    @endif

                    <!-- Tombol Selanjutnya -->
                    @if ($transaksi->hasMorePages())
                        <a href="{{ $transaksi->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg text-[#0c235b] font-bold bg-blue-50 hover:bg-blue-100 transition text-xs flex items-center">
                            Selanjutnya <i class="fa-solid fa-chevron-right text-[10px] ml-1"></i>
                        </a>
                    @else
                        <span class="px-3 py-1.5 rounded-lg text-gray-400 font-medium bg-gray-100 cursor-not-allowed text-xs">
                            Selanjutnya <i class="fa-solid fa-chevron-right text-[10px] ml-1"></i>
                        </span>
                    @endif
                </div>
            </div>

        </div>

    </main>

</body>
</html>