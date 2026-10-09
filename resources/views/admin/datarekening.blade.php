<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Rekening - GRIDAS BANK</title>

     <!-- Favicon Logo SVG -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><circle cx='12' cy='12' r='12' fill='white'/><path d='M12 5L3 10v1h18v-1L12 5zm-6 8h2v6H6v-6zm4 0h2v6h-2v-6zm4 0h2v6h-2v-6zM4 20h16v2H4v-2z' fill='%230f172a'/></svg>">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-[#DCE8FA] min-h-screen flex">

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
                <a href="{{ route('admin.rekening.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-[#1E75D8] text-white font-medium">
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
    <main class="flex-1 p-6">
        <div class="bg-white rounded-3xl p-8 min-h-[calc(100vh-3rem)] shadow-sm">

            <!-- Header Section -->
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-[#0A2558]">Data Rekening</h1>
                    <p class="text-sm text-gray-500">Kelola data rekening nasabah</p>
                </div>
            </div>

            <!-- Search Form -->
            <form method="GET" action="{{ route('admin.rekening.index') }}" class="mb-6">
                <div class="relative w-80">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-[#0A2558] font-bold"></i>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        placeholder="Cari no rekening atau nama" 
                        class="w-full pl-10 pr-10 py-2 border-2 border-[#0A2558] rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm text-gray-700 placeholder-gray-400"
                    >
                    @if(request('search'))
                        <a href="{{ route('admin.rekening.index') }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    @endif
                </div>
            </form>

            <!-- Table Data Rekening -->
            <div class="overflow-x-auto border border-gray-200 rounded-xl mb-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#E4EEFA] text-[#0A2558] font-bold border-b border-gray-200">
                            <th class="p-3 text-center border-r border-gray-200 w-12">No</th>
                            <th class="p-3 border-r border-gray-200">No Rekening</th>
                            <th class="p-3 border-r border-gray-200">Nama Nasabah</th>
                            <th class="p-3 border-r border-gray-200">Saldo</th>
                            <th class="p-3 text-center border-r border-gray-200 w-32">Status</th>
                            <th class="p-3 text-center w-24">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($rekening as $index => $item)
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 text-center border-r border-gray-200 text-gray-700 font-medium">
                                    {{ $rekening->firstItem() ? $rekening->firstItem() + $index : $index + 1 }}
                                </td>
                                <td class="p-3 border-r border-gray-200 text-gray-800 font-medium">
                                    {{ $item->no_rekening }}
                                </td>
                                <td class="p-3 border-r border-gray-200 text-gray-800">
                                    {{ $item->nama_nasabah ?? ($item->nasabah->name ?? '-') }}
                                </td>
                                <td class="p-3 border-r border-gray-200 text-gray-700">
                                    Rp {{ number_format($item->saldo_akhir ?? $item->saldo ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="p-3 text-center border-r border-gray-200">
                                    <span class="inline-block px-4 py-0.5 border-2 border-emerald-500 text-emerald-600 rounded-xl text-xs font-semibold">
                                        Aktif
                                    </span>
                                </td>
                                <td class="p-3 text-center">
                                    <form action="{{ route('admin.rekening.destroy', $item->no_rekening) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus rekening ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-lg transition">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-6 text-center text-gray-500">
                                    Data rekening tidak ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                @if (method_exists($rekening, 'links'))
                    {{ $rekening->links() }}
                @endif
            </div>

        </div>
    </main>

</body>
</html>