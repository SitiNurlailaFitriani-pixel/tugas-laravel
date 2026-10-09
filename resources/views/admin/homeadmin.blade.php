<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Admin - GRIDAS BANK</title>

     <!-- Favicon Logo SVG -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><circle cx='12' cy='12' r='12' fill='white'/><path d='M12 5L3 10v1h18v-1L12 5zm-6 8h2v6H6v-6zm4 0h2v6h-2v-6zm4 0h2v6h-2v-6zM4 20h16v2H4v-2z' fill='%230f172a'/></svg>">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Alpine.js untuk interaksi Dropdown Lonceng Notifikasi -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-[#DCE8FA] min-h-screen flex">

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
                <a href="{{ route('admin.homeadmin') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-[#1E75D8] text-white font-medium">
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
                <a href="{{ route('admin.laporan_transaksi.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#13326C] text-gray-200 transition">
                    <i class="fa-solid fa-chart-line w-5"></i>
                    Laporan Transaksi
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

    <!-- Main Content Area -->
    <main class="flex-1 p-6">
        <div class="bg-white rounded-3xl p-8 min-h-[calc(100vh-3rem)] shadow-sm">

            <!-- Alert Flash Message -->
            @if(session('success'))
                <div class="mb-6 bg-emerald-100 border border-emerald-400 text-emerald-800 px-4 py-3 rounded-2xl text-sm font-semibold flex items-center justify-between">
                    <span><i class="fa-solid fa-circle-check mr-2 text-emerald-600"></i> {{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-2xl text-sm font-semibold flex items-center justify-between">
                    <span><i class="fa-solid fa-triangle-exclamation mr-2 text-red-600"></i> {{ session('error') }}</span>
                </div>
            @endif

            <!-- Top Header & Lonceng Notifikasi -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-[#0A2558]">Dashboard Admin</h1>

                <!-- Notification & Profile Area -->
                <div class="flex items-center gap-4">
                    
                    <!-- Lonceng Notifikasi -->
                    <div class="relative" x-data="{ open: false }">
                        <!-- Tombol Lonceng -->
                        <button @click="open = !open" class="relative p-3 bg-[#E4EEFA] text-[#0A2558] rounded-full hover:bg-[#d5e4f7] transition focus:outline-none">
                            <i class="fa-solid fa-bell text-lg"></i>
                            
                            <!-- Badge Angka Merah jika ada transaksi Pending -->
                            @if(isset($totalPendingCount) && $totalPendingCount > 0)
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[11px] font-bold rounded-full h-5 w-5 flex items-center justify-center animate-pulse">
                                    {{ $totalPendingCount }}
                                </span>
                            @endif
                        </button>

                        <!-- Menu Dropdown Notifikasi -->
                        <div x-show="open" 
                             @click.away="open = false" 
                             x-transition
                             class="absolute right-0 mt-3 w-80 sm:w-96 bg-white rounded-2xl shadow-xl border border-slate-100 z-50 overflow-hidden"
                             style="display: none;">
                            
                            <!-- Header Dropdown -->
                            <div class="bg-[#0A2558] text-white px-4 py-3 flex justify-between items-center">
                                <h3 class="font-bold text-sm flex items-center gap-2">
                                    <i class="fa-solid fa-clock-rotate-left"></i> Konfirmasi Transaksi
                                </h3>
                                <span class="bg-amber-400 text-[#0A2558] text-xs font-extrabold px-2.5 py-0.5 rounded-full">
                                    {{ $totalPendingCount ?? 0 }} Pending
                                </span>
                            </div>

                            <!-- List Notifikasi Transaksi -->
                            <div class="max-h-80 overflow-y-auto divide-y divide-slate-100">
                                @forelse($notifikasiPending ?? [] as $notif)
                                    <div class="p-3.5 hover:bg-slate-50 transition flex items-start gap-3">
                                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-white shrink-0 mt-1 bg-amber-500">
                                            <i class="fa-solid fa-hand-holding-dollar text-sm"></i>
                                        </div>
                                        <div class="flex-1 text-xs">
                                            <div class="flex justify-between font-bold text-[#0A2558]">
                                                <span>{{ $notif->nama_nasabah }}</span>
                                                <span class="text-[10px] text-slate-400 font-normal">
                                                    {{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}
                                                </span>
                                            </div>
                                            <p class="text-slate-600 mt-0.5">
                                                Pengajuan <span class="font-semibold text-slate-800">{{ $notif->jenis }}</span> 
                                                sebesar <span class="font-bold text-emerald-600">Rp {{ number_format($notif->jumlah, 0, ',', '.') }}</span>
                                            </p>
                                            <p class="text-[11px] text-slate-400 italic mt-0.5">
                                                Rekening: {{ $notif->no_rekening }}
                                            </p>
                                            
                                            <!-- Tombol Akses Cepat Langsung Setujui / Tolak -->
                                            <div class="mt-2.5 flex items-center gap-2">
                                                <!-- Form Setujui -->
                                                <form action="{{ route('admin.tarik_tunai.setujui', $notif->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1 rounded-lg text-[11px] font-semibold transition flex items-center gap-1">
                                                        <i class="fa-solid fa-check"></i> Setujui
                                                    </button>
                                                </form>

                                                <!-- Form Tolak -->
                                                <form action="{{ route('admin.tarik_tunai.tolak', $notif->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg text-[11px] font-semibold transition flex items-center gap-1" onclick="return confirm('Yakin ingin menolak pengajuan ini?')">
                                                        <i class="fa-solid fa-xmark"></i> Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-6 text-center text-slate-400 text-xs">
                                        <i class="fa-regular fa-bell-slash text-2xl mb-2 block text-slate-300"></i>
                                        Tidak ada pengajuan transaksi yang perlu dikonfirmasi saat ini.
                                    </div>
                                @endforelse
                            </div>

                        </div>
                    </div>

                    <!-- User Profile Badge -->
                    <div class="flex items-center gap-2.5 text-[#0A2558] font-bold pl-2 border-l border-slate-200">
                        <i class="fa-solid fa-circle-user text-2xl"></i>
                        <span>Admin</span>
                    </div>

                </div>
            </div>

            <!-- Statistics Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                <!-- Card 1: Total Nasabah -->
                <div class="border-2 border-[#0A2558] rounded-2xl p-4 flex items-center gap-4">
                    <div class="bg-[#0A2558] text-white p-4 rounded-full w-14 h-14 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-users text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-[#0A2558]">Total Nasabah</p>
                        <p class="text-2xl font-bold text-[#0A2558]">{{ $totalNasabah }}</p>
                    </div>
                </div>

                <!-- Card 2: Total Rekening -->
                <div class="border-2 border-[#0A2558] rounded-2xl p-4 flex items-center gap-4">
                    <div class="bg-[#0A2558] text-white p-4 rounded-full w-14 h-14 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-id-card text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-[#0A2558]">Total Rekening</p>
                        <p class="text-2xl font-bold text-[#0A2558]">{{ $totalRekening }}</p>
                    </div>
                </div>

                <!-- Card 3: Total Transaksi -->
                <div class="border-2 border-[#0A2558] rounded-2xl p-4 flex items-center gap-4">
                    <div class="bg-[#0A2558] text-white p-4 rounded-full w-14 h-14 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-list-ol text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-[#0A2558]">Total Transaksi</p>
                        <p class="text-2xl font-bold text-[#0A2558]">{{ $totalTransaksi }}</p>
                    </div>
                </div>

            </div>

            <!-- Table Section: Transaksi Terbaru -->
            <h2 class="text-xl font-bold text-[#0A2558] mb-4">Transaksi hari ini</h2>

            <div class="overflow-x-auto border border-gray-200 rounded-xl">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#E4EEFA] text-[#0A2558] font-bold border-b border-gray-200">
                            <th class="p-4 text-center border-r border-gray-200 w-1/4">Tanggal</th>
                            <th class="p-4 text-center border-r border-gray-200 w-1/4">Jenis</th>
                            <th class="p-4 text-center border-r border-gray-200 w-1/4">Jumlah</th>
                            <th class="p-4 text-center w-1/4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($transaksiHariIni as $transaksi)
                            @php
                                $statusLower = strtolower($transaksi->status ?? '');
                                $isPending   = in_array($statusLower, ['pending', '0', 'menunggu', 'process', 'proses']);
                                $isDitolak   = in_array($statusLower, ['ditolak', 'gagal', 'reject', 'canceled', '2']);
                            @endphp
                            <tr class="hover:bg-gray-50 text-center">
                                <td class="p-4 border-r border-gray-200 text-gray-700">
                                    {{ $transaksi->created_at ? \Carbon\Carbon::parse($transaksi->created_at)->format('d/m/Y H:i') : '-' }}
                                </td>
                                <td class="p-4 border-r border-gray-200 text-gray-700 font-medium">
                                    {{ $transaksi->jenis }}
                                </td>
                                <td class="p-4 border-r border-gray-200 text-gray-700 font-semibold">
                                    Rp {{ number_format($transaksi->jumlah ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="p-4 text-center">
                                    @if($isPending)
                                        <span class="inline-block px-4 py-1 border-2 border-amber-500 text-amber-600 bg-amber-50 rounded-xl text-xs font-semibold">
                                            Pending
                                        </span>
                                    @elseif($isDitolak)
                                        <span class="inline-block px-4 py-1 border-2 border-red-500 text-red-600 bg-red-50 rounded-xl text-xs font-semibold">
                                            {{ $transaksi->status }}
                                        </span>
                                    @else
                                        <span class="inline-block px-4 py-1 border-2 border-emerald-500 text-emerald-600 bg-emerald-50 rounded-xl text-xs font-semibold">
                                            {{ $transaksi->status }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-6 text-center text-gray-500">
                                    Belum ada data transaksi hari ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </main>

</body>
</html>