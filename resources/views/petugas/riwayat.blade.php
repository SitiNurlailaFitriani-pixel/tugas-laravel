<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRIDAS BANK - Riwayat Transaksi Petugas</title>

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
<body class="bg-[#dbe7f6] min-h-screen flex text-[#0c235b]">

    <!-- Sidebar Navigasi Kiri -->
    <aside class="w-72 bg-[#0c235b] text-white flex flex-col justify-between p-6 min-h-screen shrink-0">
        <div>
            <!-- Logo & Brand Name -->
            <div class="flex items-center gap-3.5 mb-8 px-1">
                <div class="w-11 h-11 rounded-full border-2 border-white flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-building-columns text-xl text-white"></i>
                </div>
                <h1 class="text-xl font-bold tracking-wider text-white">GRIDAS BANK</h1>
            </div>

            <!-- Menu Navigasi -->
            <nav class="space-y-3">
                <a href="{{ route('petugas.dashboard') }}" class="flex items-center gap-3.5 text-white/90 hover:bg-white/10 px-4 py-3 rounded-xl font-semibold transition text-sm">
                    <i class="fa-solid fa-house text-lg w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('petugas.nasabah') }}" class="flex items-center gap-3.5 text-white/90 hover:bg-white/10 px-4 py-3 rounded-xl font-semibold transition text-sm">
                    <i class="fa-solid fa-users text-lg w-5 text-center"></i>
                    <span>Data Nasabah</span>
                </a>

                <a href="{{ route('petugas.setortunai') }}" class="flex items-center gap-3.5 text-white/90 hover:bg-white/10 px-4 py-3 rounded-xl font-semibold transition text-sm">
                    <i class="fa-solid fa-money-bill-transfer text-lg w-5 text-center"></i>
                    <span>Setor Tunai</span>
                </a>

                <a href="{{ route('petugas.tariktunai') }}" class="flex items-center gap-3.5 text-white/90 hover:bg-white/10 px-4 py-3 rounded-xl font-semibold transition text-sm">
                    <i class="fa-solid fa-wallet text-lg w-5 text-center"></i>
                    <span>Tarik Tunai</span>
                </a>

                <!-- Navigasi Aktif: Riwayat Transaksi -->
                <a href="{{ route('petugas.riwayat') }}" class="flex items-center gap-3.5 bg-[#2582ce] text-white px-4 py-3.5 rounded-xl font-bold shadow-md transition text-sm">
                    <i class="fa-solid fa-receipt text-lg w-5 text-center"></i>
                    <span>Riwayat Transaksi</span>
                </a>
            </nav>
        </div>

        <!-- Section Logout -->
        <div class="pt-4 border-t border-white/20">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-3.5 text-white hover:text-red-300 px-2 py-2 font-bold transition w-full text-left text-sm">
                    <i class="fa-solid fa-right-from-bracket text-xl rotate-180"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Konten Utama (Kanan) -->
    <main class="flex-1 p-8 flex flex-col justify-start overflow-y-auto">
        
        <!-- Top Bar Profil Header Petugas -->
        <div class="flex justify-end items-center mb-6 pr-2">
            <div class="flex items-center gap-3 font-bold text-[#0c235b] text-base">
                <div class="w-10 h-10 bg-[#0c235b] text-white rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-user text-lg"></i>
                </div>
                <span>Petugas</span>
            </div>
        </div>

        <!-- Card Putih Utama Riwayat Transaksi -->
        <div class="flex-1 flex flex-col justify-start items-center">
            <div class="bg-white rounded-3xl shadow-sm p-8 md:p-10 w-full max-w-5xl space-y-5">
                
                <!-- Header Card -->
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-[#2582ce] rounded-full flex items-center justify-center text-white text-xl shadow-md shrink-0">
                        <i class="fa-solid fa-receipt"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-[#0c235b]">Riwayat Transaksi</h2>
                        <p class="text-slate-500 text-xs font-medium">Lihat semua transaksi anda</p>
                    </div>
                </div>

                <!-- Filter & Search Bar -->
                <form action="{{ route('nasabah.riwayat') }}" method="GET" class="w-full flex flex-col sm:flex-row items-center justify-between gap-3">
                    
                    <!-- Input Search -->
                    <div class="relative flex-1 w-full">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input 
                            type="text" 
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari transaksi..." 
                            class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-xl text-sm focus:outline-none focus:border-[#2582ce] transition"
                        >
                    </div>
                    
                    <!-- Input Tanggal & Tombol Reset -->
                    <div class="flex items-center gap-2 w-full sm:w-auto shrink-0">
                        <div class="relative w-full sm:w-56">
                            <input 
                                type="date" 
                                name="tanggal" 
                                value="{{ request('tanggal') }}"
                                onchange="this.form.submit()" 
                                class="w-full px-3 py-2 bg-white border border-gray-300 rounded-xl text-xs font-medium text-[#0c235b] focus:outline-none focus:border-[#2582ce] cursor-pointer"
                            >
                        </div>

                        @if(request('search') || request('tanggal'))
                            <a href="{{ route('nasabah.riwayat') }}" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl text-xs font-semibold transition shrink-0">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>

                <!-- Container Slide Tabel -->
                <div class="overflow-x-auto rounded-2xl border border-slate-200 mt-2">
                    <table class="w-full border-collapse text-left text-xs">
                        <!-- Header Tabel -->
                        <thead>
                            <tr class="bg-[#E2EDF8] text-[#0c235b] border-b border-slate-200">
                                <th class="py-3.5 px-4 font-bold border-r border-slate-200">Tanggal</th>
                                <th class="py-3.5 px-4 font-bold border-r border-slate-200">No. Rekening</th>
                                <th class="py-3.5 px-4 font-bold border-r border-slate-200">Username</th>
                                <th class="py-3.5 px-4 font-bold border-r border-slate-200">Tipe</th>
                                <th class="py-3.5 px-4 font-bold border-r border-slate-200">Nominal</th>
                                <th class="py-3.5 px-4 font-bold text-center">Status</th>
                            </tr>
                        </thead>

                        <!-- Body Tabel Dinamis -->
                        <tbody class="divide-y divide-slate-200 text-slate-600">
                            @forelse ($riwayatChunks as $index => $chunk)
                                @foreach ($chunk as $item)
                                    <tr class="slide-group slide-page-{{ $index }} hover:bg-slate-50 transition {{ $index !== 0 ? 'hidden' : '' }}">
                                        <!-- Tanggal Transaksi -->
                                        <td class="py-3.5 px-4 font-medium border-r border-slate-200 whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y, H:i') }}
                                        </td>
                                        
                                        <!-- Nomor Rekening -->
                                        <td class="py-3.5 px-4 font-semibold border-r border-slate-200 text-[#0c235b]">
                                            {{ $item->no_rekening ?? '-' }}
                                        </td>
                                        
                                        <!-- Username / Nama Lengkap -->
                                        <td class="py-3.5 px-4 font-medium border-r border-slate-200">
                                            {{ $item->username ?? $item->nama_lengkap ?? '-' }}
                                        </td>
                                        
                                        <!-- Tipe Transaksi -->
                                        <td class="py-3.5 px-4 font-medium border-r border-slate-200 text-slate-700">
                                            {{ $item->tipe }}
                                        </td>
                                        
                                        <!-- Nominal -->
                                        <td class="py-3.5 px-4 font-bold border-r border-slate-200 {{ $item->tipe == 'Setor Tunai' ? 'text-green-600' : 'text-red-500' }}">
                                            {{ $item->tipe == 'Setor Tunai' ? '+ ' : '- ' }}Rp {{ number_format($item->nominal, 0, ',', '.') }}
                                        </td>
                                        
                                        <!-- Status Transaksi (Dinamis: Berhasil, Pending, Ditolak) -->
                                        <td class="py-3.5 px-4 text-center">
                                            @php
                                                $status = strtolower(trim($item->status ?? 'berhasil'));
                                            @endphp

                                            @if(in_array($status, ['pending', 'menunggu']))
                                                <span class="inline-block px-3 py-1 text-[11px] font-semibold text-amber-700 bg-amber-50 border border-amber-500 rounded-lg">
                                                    Pending
                                                </span>
                                            @elseif(in_array($status, ['ditolak', 'rejected', 'failed', 'gagal', 'batal', 'cancel', 'cancelled']))
                                                <span class="inline-block px-3 py-1 text-[11px] font-semibold text-red-700 bg-red-50 border border-red-500 rounded-lg">
                                                    Ditolak
                                                </span>
                                            @else
                                                <span class="inline-block px-3 py-1 text-[11px] font-semibold text-green-700 bg-green-50 border border-green-500 rounded-lg">
                                                    Berhasil
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-slate-400 font-medium">
                                        Tidak ada data riwayat transaksi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Control Navigasi Tombol Slide -->
                @if (count($riwayatChunks) > 0)
                    <div class="flex items-center justify-between pt-2">
                        <span class="text-xs font-semibold text-slate-500">
                            Menampilkan Halaman <span id="currentSlideNum" class="text-[#0c235b] font-bold">1</span> dari <span id="totalSlideNum" class="text-[#0c235b] font-bold">{{ count($riwayatChunks) }}</span>
                        </span>

                        <div class="flex items-center gap-2">
                            <button id="btnPrev" onclick="changeSlide(-1)" class="px-3.5 py-1.5 rounded-xl bg-slate-100 text-[#0c235b] text-xs font-bold hover:bg-[#2582ce] hover:text-white transition flex items-center gap-2 disabled:opacity-40 disabled:hover:bg-slate-100 disabled:hover:text-[#0c235b] disabled:cursor-not-allowed">
                                <i class="fa-solid fa-chevron-left text-xs"></i>
                                <span>Sebelumnya</span>
                            </button>

                            <button id="btnNext" onclick="changeSlide(1)" class="px-3.5 py-1.5 rounded-xl bg-slate-100 text-[#0c235b] text-xs font-bold hover:bg-[#2582ce] hover:text-white transition flex items-center gap-2 disabled:opacity-40 disabled:hover:bg-slate-100 disabled:hover:text-[#0c235b] disabled:cursor-not-allowed">
                                <span>Selanjutnya</span>
                                <i class="fa-solid fa-chevron-right text-xs"></i>
                            </button>
                        </div>
                    </div>
                @endif

            </div>
        </div>

    </main>

    <!-- JavaScript Slide / Paging Client-Side -->
    <script>
        let currentSlide = 0;
        const totalSlides = {{ count($riwayatChunks) }};

        function updateSlideDisplay() {
            document.querySelectorAll('.slide-group').forEach(row => {
                row.classList.add('hidden');
            });

            document.querySelectorAll('.slide-page-' + currentSlide).forEach(row => {
                row.classList.remove('hidden');
            });

            const currentNumEl = document.getElementById('currentSlideNum');
            if (currentNumEl) {
                currentNumEl.textContent = currentSlide + 1;
            }

            const btnPrev = document.getElementById('btnPrev');
            const btnNext = document.getElementById('btnNext');

            if (btnPrev) btnPrev.disabled = (currentSlide === 0);
            if (btnNext) btnNext.disabled = (currentSlide === totalSlides - 1 || totalSlides === 0);
        }

        function changeSlide(direction) {
            const newSlide = currentSlide + direction;
            if (newSlide >= 0 && newSlide < totalSlides) {
                currentSlide = newSlide;
                updateSlideDisplay();
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (totalSlides > 0) {
                updateSlideDisplay();
            }
        });
    </script>

</body>
</html>