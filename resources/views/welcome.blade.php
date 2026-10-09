<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRIDAS BANK - Bank Mini Gridas</title>
    
    <!-- Favicon Logo SVG -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><circle cx='12' cy='12' r='12' fill='white'/><path d='M12 5L3 10v1h18v-1L12 5zm-6 8h2v6H6v-6zm4 0h2v6h-2v-6zm4 0h2v6h-2v-6zM4 20h16v2H4v-2z' fill='%230f172a'/></svg>">

    <!-- Tailwind CSS (Vite / CDN) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Opsi Fallback CDN jika belum setup Vite: -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Inter & Font Awesome Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Custom Gradient untuk Tombol Purple/Pink Gradient */
        .btn-gradient-purple {
            background: linear-gradient(135deg, #a78bfa 0%, #c084fc 50%, #e879f9 100%);
        }
        .btn-gradient-purple:hover {
            opacity: 0.9;
        }
        /* Gradient Teks Gridas */
        .text-gradient-purple {
            background: linear-gradient(135deg, #a78bfa 0%, #e879f9 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="text-white min-h-screen flex flex-col justify-between selection:bg-purple-500 selection:text-white bg-cover bg-center relative" style="background-image: url('{{ asset('images/bankmini.png') }}');">

    <!-- Overlay Warna Biru Transparan di atas Background Foto Asli -->
    <div class="absolute inset-0 bg-[#03153b]/85 z-0"></div>

    <!-- NAVBAR -->
    <nav class="relative z-10 bg-gradient-to-r from-[#0a2357]/90 via-[#0d2a6b]/90 to-[#0f3482]/90 backdrop-blur-md px-6 py-4 flex items-center justify-between border-b border-blue-900/50 shadow-md">
        <!-- Logo & Brand Name -->
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-[#0a2357] shadow">
                <i class="fa-solid fa-building-columns text-xl"></i>
            </div>
            <span class="text-xl md:text-2xl font-bold tracking-wide text-white">GRIDAS BANK</span>
        </div>

        <!-- Auth Buttons Right -->
        <div class="flex items-center gap-3">
            <a href="{{ route('login') }}" class="px-5 py-1.5 rounded-full border border-blue-400/80 text-white font-medium hover:bg-blue-600/30 transition text-sm md:text-base">
                Login
            </a>
            <a href="{{ route('register') }}" class="btn-gradient-purple px-5 py-1.5 rounded-full text-white font-medium shadow transition text-sm md:text-base">
                Register
            </a>
        </div>
    </nav>

    <!-- HERO / MAIN CONTENT -->
    <main class="relative z-10 max-w-7xl mx-auto px-6 py-8 md:py-12 w-full flex-1 flex flex-col justify-center">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            
            <!-- Left Side: Information & Action -->
            <div class="lg:col-span-7 space-y-6">
                <!-- Title -->
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight">
                    Bank Mini <span class="text-gradient-purple">Gridas</span>
                </h1>
                
                <!-- Description -->
                <div class="text-blue-200/90 text-base sm:text-lg leading-relaxed max-w-xl font-normal space-y-1">
                    <p>Selamat datang di project</p>
                    <p>Bank mini gridas by kelompok 2 edutipa</p>
                    <p class="font-semibold text-white">SMKN 2 SUMEDANG</p>
                </div>

                <!-- Call to Action Buttons -->
                <div class="flex items-center gap-4 pt-2">
                    <a href="{{ route('login') }}" class="btn-gradient-purple px-7 py-2.5 rounded-full text-white font-semibold shadow-lg hover:shadow-purple-500/30 transition">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="px-7 py-2.5 rounded-full border border-pink-400 text-white font-semibold hover:bg-pink-500/20 transition">
                        Register
                    </a>
                </div>
            </div>

            <!-- Right Side: 3D Illustration / Image -->
            <div class="lg:col-span-5 flex justify-center lg:justify-end">
                <div class="relative w-full max-w-sm sm:max-w-md">
                    <img src="{{ asset('storage/image/logo bank.png') }}" 
                         alt="Bank Mini Gridas 3D Illustration" 
                         class="w-full h-auto object-contain drop-shadow-[0_15px_15px_rgba(0,0,0,0.5)] rounded-2xl">
                </div>
            </div>
        </div>

        <!-- LAYANAN KAMI SECTION -->
        <div class="mt-12 md:mt-16">
            <h2 class="text-lg font-bold text-white mb-4 tracking-wide">Layanan kami :</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">
                
                <!-- Card 1: Setor Tunai -->
                <div class="bg-[#051c4a]/85 border border-blue-500/40 rounded-xl p-4 flex items-center gap-4 hover:border-blue-400 transition cursor-pointer shadow-lg backdrop-blur-sm">
                    <div class="w-12 h-12 rounded-full bg-sky-500 flex items-center justify-center text-white shrink-0">
                        <i class="fa-solid fa-money-bill-transfer text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-white text-sm sm:text-base">Setor tunai</h3>
                        <p class="text-xs text-blue-300">Mudah dan cepat</p>
                    </div>
                </div>

                <!-- Card 2: Tarik Tunai -->
                <div class="bg-[#051c4a]/85 border border-blue-500/40 rounded-xl p-4 flex items-center gap-4 hover:border-blue-400 transition cursor-pointer shadow-lg backdrop-blur-sm">
                    <div class="w-12 h-12 rounded-full bg-sky-500 flex items-center justify-center text-white shrink-0">
                        <i class="fa-solid fa-credit-card text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-white text-sm sm:text-base">Tarik tunai</h3>
                        <p class="text-xs text-blue-300">Akses dana kapan saja</p>
                    </div>
                </div>

                <!-- Card 3: Riwayat Transaksi -->
                <div class="bg-[#051c4a]/85 border border-blue-500/40 rounded-xl p-4 flex items-center gap-4 hover:border-blue-400 transition cursor-pointer shadow-lg backdrop-blur-sm">
                    <div class="w-12 h-12 rounded-full bg-sky-500 flex items-center justify-center text-white shrink-0">
                        <i class="fa-solid fa-receipt text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-white text-sm sm:text-base">Riwayat transaksi</h3>
                        <p class="text-xs text-blue-300">Pantau semua transaksi</p>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- FOOTER SIMPLE -->
    <footer class="relative z-10 text-center py-4 text-xs text-blue-300 border-t border-blue-900/40 bg-[#03153b]/80 backdrop-blur-sm">
        &copy; {{ date('Y') }} Kelompok 2 Edutipa - SMKN 2 Sumedang. All Rights Reserved.
    </footer>

</body>
</html>