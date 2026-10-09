@php
    /* Ambil data nasabah dari session atau variabel controller */
    $username   = session('username', 'Nasabah');
    $namaLengkap = $nasabah->nama ?? session('nama_rekening', $username);
    $noRekening  = $nasabah->no_rekening ?? session('no_rekening', '-');
    $email       = $nasabah->email ?? session('email', '-');
    $noHp        = $nasabah->no_hp ?? session('no_hp', '-');
    $saldoAnda   = $nasabah->saldo ?? $saldo_anda ?? 0;
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRIDAS BANK - Profil Rekening</title>

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
<body class="bg-[#dbe7f6] min-h-screen flex text-[#122e6f] overflow-hidden">

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
                <!-- Dashboard -->
                <a href="{{ route('homenasabah') }}" class="flex items-center gap-3.5 text-white/90 hover:bg-[#13327b] px-4 py-2.5 rounded-xl font-medium transition text-sm">
                    <i class="fa-solid fa-house text-base w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Profil Rekening (Active) -->
                <a href="{{ route('profil') }}" class="flex items-center gap-3.5 bg-[#2582ce] text-white px-4 py-2.5 rounded-xl font-semibold shadow-md transition text-sm">
                    <i class="fa-solid fa-user text-base w-5 text-center"></i>
                    <span>Profil Rekening</span>
                </a>
                
                <!-- Tarik Tunai -->
                <a href="{{ route('tariktunai') }}" class="flex items-center gap-3.5 text-white/90 hover:bg-[#13327b] px-4 py-2.5 rounded-xl font-medium transition text-sm">
                    <i class="fa-solid fa-wallet text-base w-5 text-center"></i>
                    <span>Tarik Tunai</span>
                </a>

                <!-- Riwayat Transaksi -->
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
        
        <!-- Card Putih Utama -->
        <div class="bg-white rounded-3xl p-8 shadow-sm w-full max-w-4xl space-y-6">
            
            <!-- Header Profil -->
            <div class="flex items-center gap-4 pb-4 border-b border-gray-100">
                <div class="w-16 h-16 bg-[#0c235b] text-white rounded-full flex items-center justify-center text-3xl shrink-0 shadow-sm">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-[#0c235b]">Profil Rekening</h2>
                    <p class="text-[#3b558e] font-medium text-sm">Informasi detail akun nasabah Anda</p>
                </div>
            </div>

            <!-- Card Info Saldo Utama -->
            <div class="bg-gradient-to-r from-[#0c235b] to-[#2582ce] text-white rounded-2xl p-6 shadow-md flex justify-between items-center">
                <div>
                    <p class="text-xs uppercase font-semibold tracking-wider opacity-80">Total Saldo Aktif</p>
                    <p class="text-3xl font-extrabold mt-1">
                        Rp {{ number_format($saldoAnda, 0, ',', '.') }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center backdrop-blur-sm">
                    <i class="fa-solid fa-wallet text-2xl text-white"></i>
                </div>
            </div>

            <!-- Detail Informasi Nasabah -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                
                <!-- Nama Pemilik Rekening -->
                <div class="bg-[#f8fafc] border border-gray-200 rounded-xl p-4">
                    <span class="text-xs font-semibold text-gray-500 uppercase block mb-1">Nama Pemilik Rekening</span>
                    <span class="font-bold text-[#0c235b] text-base">{{ $namaLengkap }}</span>
                </div>

                <!-- Nomor Rekening -->
                <div class="bg-[#f8fafc] border border-gray-200 rounded-xl p-4">
                    <span class="text-xs font-semibold text-gray-500 uppercase block mb-1">Nomor Rekening</span>
                    <span class="font-bold text-[#0c235b] text-base tracking-wide">{{ $noRekening }}</span>
                </div>

                <!-- Alamat Email -->
                <div class="bg-[#f8fafc] border border-gray-200 rounded-xl p-4">
                    <span class="text-xs font-semibold text-gray-500 uppercase block mb-1">Alamat Email</span>
                    <span class="font-bold text-[#0c235b] text-base">{{ $email }}</span>
                </div>

                <!-- Nomor HP / Telepon -->
                <div class="bg-[#f8fafc] border border-gray-200 rounded-xl p-4">
                    <span class="text-xs font-semibold text-gray-500 uppercase block mb-1">Nomor Telepon / HP</span>
                    <span class="font-bold text-[#0c235b] text-base">{{ $noHp }}</span>
                </div>
              
            </div>

            <!-- Tombol Kembali ke Dashboard -->
            <div class="pt-2 flex justify-end">
                <a href="{{ route('homenasabah') }}" class="bg-[#2582ce] hover:bg-[#1a629d] text-white font-bold py-2.5 px-6 rounded-xl transition duration-200 text-sm shadow-sm flex items-center gap-2">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Kembali ke Dashboard</span>
                </a>
            </div>

        </div>

    </main>

</body>
</html>