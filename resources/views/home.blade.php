<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRIDAS BANK - Dashboard</title>
     <!-- Favicon Logo SVG -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><circle cx='12' cy='12' r='12' fill='white'/><path d='M12 5L3 10v1h18v-1L12 5zm-6 8h2v6H6v-6zm4 0h2v6h-2v-6zm4 0h2v6h-2v-6zM4 20h16v2H4v-2z' fill='%230f172a'/></svg>">

    
    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    </style>
</head>
<body class="bg-slate-100 min-h-screen flex">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-[#0a2558] text-white flex flex-col min-h-screen">
        <div class="p-6 flex items-center space-x-3 border-b border-blue-900">
            <div class="w-10 h-10 rounded-full bg-white text-[#0a2558] flex items-center justify-center font-bold text-xl">
                <i class="fa-solid font-bold text-[#0a2558] fa-building-columns"></i>
            </div>
            <span class="font-bold text-xl tracking-wide">GRIDAS BANK</span>
        </div>

        <nav class="flex-1 p-4 space-y-2">
            <a href="#" class="flex items-center space-x-3 px-4 py-3 bg-blue-600 rounded-xl font-medium text-white transition">
                <i class="fa-solid fa-house w-5"></i>
                <span>Dashboard</span>
            </a>
            <a href="/profil" class="flex items-center space-x-3 px-4 py-3 hover:bg-blue-900/50 text-blue-100 rounded-xl font-medium transition">
                <i class="fa-solid fa-user w-5"></i>
                <span>Profil Rekening</span>
            </a>
            <a href="/setor-tunai" class="flex items-center space-x-3 px-4 py-3 hover:bg-blue-900/50 text-blue-100 rounded-xl font-medium transition">
                <i class="fa-solid fa-[#0a2558] fa-money-bill-transfer w-5"></i>
                <span>Setor Tunai</span>
            </a>
            <a href="/tarik-tunai" class="flex items-center space-x-3 px-4 py-3 hover:bg-blue-900/50 text-blue-100 rounded-xl font-medium transition">
                <i class="fa-solid fa-[#0a2558] fa-wallet w-5"></i>
                <span>Tarik Tunai</span>
            </a>
            <a href="/riwayat" class="flex items-center space-x-3 px-4 py-3 hover:bg-blue-900/50 text-blue-100 rounded-xl font-medium transition">
                <i class="fa-solid fa-receipt w-5"></i>
                <span>Riwayat Transaksi</span>
            </a>
            <a href="/laporan" class="flex items-center space-x-3 px-4 py-3 hover:bg-blue-900/50 text-blue-100 rounded-xl font-medium transition">
                <i class="fa-solid fa-chart-line w-5"></i>
                <span>Laporan Transaksi</span>
            </a>
        </nav>
    </aside>

    <!-- CONTENT AREA -->
    <main class="flex-1 flex flex-col">
        
        <!-- HEADER TOP -->
        <header class="h-20 bg-slate-100 flex items-center justify-end px-8">
            <div class="flex items-center space-x-3 bg-white px-4 py-2 rounded-full shadow-sm">
                <div class="w-8 h-8 rounded-full bg-blue-900 text-white flex items-center justify-center font-semibold">
                    <i class="fa-solid fa-user text-sm"></i>
                </div>
                <span class="font-medium text-slate-700">{{ session('nama_pemilik') ?? 'fitri' }}</span>
            </div>
        </header>

        <!-- MAIN CONTAINER -->
        <div class="p-8 flex-1">
            <div class="bg-white rounded-3xl p-8 shadow-sm">
                
                <!-- GREETING -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-slate-800 flex items-center gap-2">
                        Selamat datang, {{ session('nama_pemilik') ?? 'fitri' }} 👋
                    </h1>
                    <p class="text-blue-900 font-semibold mt-1">
                        No Rekening : {{ session('no_rekening') ?? '777202609212564' }}
                    </p>
                </div>

                <!-- CARDS GRID -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    
                    <!-- CARD SALDO (DINAMIS DARI CONTROLLER) -->
                    <div class="bg-[#0a2558] text-white p-6 rounded-2xl flex flex-col justify-between shadow-md">
                        <span class="text-slate-300 font-medium">Saldo Anda</span>
                        <div class="my-4">
                            <h2 class="text-4xl font-extrabold tracking-tight">
                                Rp. {{ number_format($saldo_anda, 0, ',', '.') }}
                            </h2>
                        </div>
                    </div>

                    <!-- CARD TRANSAKSI TERAKHIR -->
                    <div class="border border-slate-200 rounded-2xl p-6 flex flex-col justify-between">
                        <h3 class="font-bold text-slate-800 mb-4">Transaksi Terakhir</h3>
                        
                        @if(count($transaksi_terakhir) > 0)
                            <div class="space-y-3 overflow-y-auto max-h-32">
                                @foreach($transaksi_terakhir as $trx)
                                    <div class="flex justify-between items-center text-sm border-b pb-2">
                                        <div>
                                            <p class="font-semibold text-slate-700">Setor Tunai</p>
                                            <p class="text-xs text-slate-400">{{ $trx->created_at ?? date('d-m-Y') }}</p>
                                        </div>
                                        <span class="font-bold text-emerald-600">
                                            + Rp. {{ number_format($trx->jumlah_setor ?? $trx->nominal ?? 0, 0, ',', '.') }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="flex-1 flex flex-col items-center justify-center text-slate-400 py-4">
                                <i class="fa-regular fa-folder-open text-4xl mb-2"></i>
                                <p class="text-sm">Belum ada riwayat transaksi</p>
                            </div>
                        @endif
                    </div>

                </div>

                <!-- MENU CEPAT -->
                <div>
                    <h3 class="font-bold text-slate-800 mb-4">Menu cepat</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="/setor-tunai" class="flex items-center justify-center p-4 border border-emerald-500 bg-emerald-50 text-emerald-600 rounded-2xl font-bold hover:bg-emerald-100 transition">
                            <i class="fa-solid fa-arrow-down-left-and-arrow-up-right-to-center mr-2"></i> Setor Tunai
                        </a>
                        <a href="/tarik-tunai" class="flex items-center justify-center p-4 border border-amber-500 bg-amber-50 text-amber-600 rounded-2xl font-bold hover:bg-amber-100 transition">
                            <i class="fa-solid fa-wallet mr-2"></i> Tarik Tunai
                        </a>
                        <a href="/riwayat" class="flex items-center justify-center p-4 border border-sky-500 bg-sky-50 text-sky-600 rounded-2xl font-bold hover:bg-sky-100 transition">
                            <i class="fa-solid fa-receipt mr-2"></i> Riwayat
                        </a>
                        <a href="/laporan" class="flex items-center justify-center p-4 border border-purple-500 bg-purple-50 text-purple-600 rounded-2xl font-bold hover:bg-purple-100 transition">
                            <i class="fa-solid fa-chart-line mr-2"></i> Laporan
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </main>

</body>
</html>