<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRIDAS BANK - Data Nasabah (Admin)</title>

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
                <a href="{{ route('admin.nasabah.index') }}"  class="flex items-center gap-3 px-4 py-3 rounded-xl bg-[#1E75D8] text-white font-medium">
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

        <!-- Card Putih Utama -->
        <div class="bg-white rounded-3xl p-8 shadow-sm w-full space-y-6 flex-1 flex flex-col justify-between relative">
            
            <div>
                <!-- Notifikasi Berhasil -->
                @if(session('success'))
                    <div class="mb-4 p-4 bg-emerald-50 border border-emerald-500 text-emerald-700 rounded-xl text-xs font-semibold">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Header Title & Tombol Tambah Nasabah -->
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-[#0c235b]">Data Nasabah</h2>
                        <p class="text-slate-500 text-sm mt-0.5">Kelola data nasabah bank</p>
                    </div>
                    <!-- DIUBAH DI SINI: Menggunakan <button> dengan onclick openModal() agar tidak pindah halaman -->
                    <button type="button" onclick="openModal()" class="bg-[#2582ce] hover:bg-[#1d6fa8] text-white font-semibold px-5 py-2.5 rounded-xl shadow transition text-sm flex items-center gap-2 cursor-pointer">
                        <span>+ Tambah Nasabah</span>
                    </button>
                </div>

                <!-- Input Search -->
                <form action="{{ route('admin.nasabah.index') }}" method="GET" class="mb-6">
                    <div class="relative w-full max-w-md">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-[#0c235b] text-base"></i>
                        <input type="text" name="search" value="{{ $search ?? request('search') }}" placeholder="Cari nama atau username" 
                            class="w-full pl-11 pr-10 py-2.5 border-2 border-[#0c235b] rounded-full text-sm font-medium text-[#0c235b] placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-[#2582ce]">
                        @if(request('search') || !empty($search))
                            <a href="{{ route('admin.nasabah.index') }}" class="absolute right-4 top-1/2 -translate-y-1/2 text-[#0c235b] hover:text-red-500">
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
                                        <form action="{{ route('admin.nasabah.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus nasabah ini?');">
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

            <!-- Custom Pagination -->
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

    <!-- MODAL / POPUP INPUT TAMBAH NASABAH (MUNCUL DI HALAMAN INI) -->
    <div id="modalTambah" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-3xl p-8 w-full max-w-lg shadow-2xl transform transition-all">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-xl font-bold text-[#0c235b]">Tambah Nasabah Baru</h3>
                    <p class="text-slate-500 text-xs mt-0.5">Silakan isi formulir data nasabah di bawah ini</p>
                </div>
                <button type="button" onclick="closeModal()" class="text-slate-400 hover:text-red-500 text-lg transition">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Form Input (Arahkan rute store sesuai controller Anda) -->
            <form action="{{ route('admin.nasabah.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-[#0c235b] mb-1">Nama Lengkap</label>
                    <input type="text" name="nama" required placeholder="Masukkan nama lengkap" 
                        class="w-full px-4 py-2.5 border-2 border-slate-200 rounded-xl text-sm font-medium text-[#0c235b] focus:outline-none focus:border-[#2582ce]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#0c235b] mb-1">Username</label>
                    <input type="text" name="username" required placeholder="Masukkan username" 
                        class="w-full px-4 py-2.5 border-2 border-slate-200 rounded-xl text-sm font-medium text-[#0c235b] focus:outline-none focus:border-[#2582ce]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#0c235b] mb-1">E-mail</label>
                    <input type="email" name="email" required placeholder="Masukkan alamat email" 
                        class="w-full px-4 py-2.5 border-2 border-slate-200 rounded-xl text-sm font-medium text-[#0c235b] focus:outline-none focus:border-[#2582ce]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#0c235b] mb-1">Password</label>
                    <input type="password" name="password" required placeholder="Masukkan password" 
                        class="w-full px-4 py-2.5 border-2 border-slate-200 rounded-xl text-sm font-medium text-[#0c235b] focus:outline-none focus:border-[#2582ce]">
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeModal()" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-600 font-semibold text-sm hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#2582ce] hover:bg-[#1d6fa8] text-white font-semibold text-sm shadow transition">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script JavaScript untuk Toggle Modal -->
    <script>
        const modal = document.getElementById('modalTambah');

        function openModal() {
            modal.classList.remove('hidden');
        }

        function closeModal() {
            modal.classList.add('hidden');
        }

        // Tutup modal jika user klik di luar kotak putih modal
        window.onclick = function(event) {
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>