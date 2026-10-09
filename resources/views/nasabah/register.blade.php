<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Nasabah - GRIDAS BANK</title>

   <!-- Favicon Logo SVG -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'><circle cx='12' cy='12' r='12' fill='white'/><path d='M12 5L3 10v1h18v-1L12 5zm-6 8h2v6H6v-6zm4 0h2v6h-2v-6zm4 0h2v6h-2v-6zM4 20h16v2H4v-2z' fill='%230f172a'/></svg>">

  <!-- CDN Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#00173f] min-h-screen flex items-center justify-center p-4">

  <div class="w-full max-w-5xl flex flex-col md:flex-row items-center justify-between gap-8 py-8 px-4">
    
    <!-- Sisi Kiri (Branding & Ilustrasi) -->
    <div class="w-full md:w-1/2 text-white flex flex-col justify-between space-y-6">
      
      <!-- Logo & Nama Bank -->
      <div class="flex items-center space-x-3">
        <div class="bg-white p-2.5 rounded-full flex items-center justify-center text-[#00173f]">
          <svg class="w-7 h-7 fill-current" viewBox="0 0 24 24">
            <path d="M2 19h20v2H2v-2zm2-2h2v-7H4v7zm5 0h2v-7H9v7zm5 0h2v-7h-2v7zm5 0h2v-7h-2v7zM2 9l10-5 10 5H2z"/>
          </svg>
        </div>
        <span class="text-2xl font-bold tracking-wider">GRIDAS BANK</span>
      </div>

      <!-- Judul & Deskripsi -->
      <div class="space-y-3 pt-4">
        <h1 class="text-3xl md:text-4xl font-bold">Buat Akun Nasabah</h1>
        <p class="text-slate-200 text-lg leading-relaxed max-w-md">
          Mari bergabung dengan kami dan nikmati kemudahan transaksi bersama Bank Mini Gridas
        </p>
      </div>

      <!-- Ilustrasi Kartu & Koin -->
      <div class="pt-6 flex justify-start">
        <img 
          src="{{ asset('storage/image/login.png') }}" 
          alt="Ilustrasi Perbankan" 
          class="w-80 h-auto object-contain drop-shadow-2xl"
        >
      </div>

    </div>

    <!-- Sisi Kanan (Form Pendaftaran) -->
    <div class="w-full md:w-[460px] bg-white rounded-2xl p-8 shadow-2xl">
      <h2 class="text-2xl font-bold text-[#00173f] mb-6">Daftar Nasabah</h2>

      <!-- Alert Pesan Error Validasi (jika ada) -->
      @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 text-sm rounded-lg">
          <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- Form Pendaftaran -->
      <form action="{{ route('register.store') }}" method="POST" class="space-y-4">
        @csrf
        
        <!-- Input Nama Lengkap -->
        <div class="space-y-1.5">
          <label class="block text-sm font-semibold text-[#00173f]">Nama Lengkap</label>
          <input 
            type="text" 
            name="nama_rekening"
            value="{{ old('nama_rekening') }}"
            placeholder="Masukan nama lengkap" 
            required
            class="w-full px-4 py-2.5 rounded-lg border border-[#00173f] text-[#00173f] placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-900 transition"
          >
        </div>

        <!-- Input Username -->
        <div class="space-y-1.5">
          <label class="block text-sm font-semibold text-[#00173f]">Username</label>
          <input 
            type="text" 
            name="username"
            value="{{ old('username') }}"
            placeholder="Buat username" 
            required
            class="w-full px-4 py-2.5 rounded-lg border border-[#00173f] text-[#00173f] placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-900 transition"
          >
        </div>

        <!-- Input E-mail -->
        <div class="space-y-1.5">
          <label class="block text-sm font-semibold text-[#00173f]">E-mail</label>
          <input 
            type="email" 
            name="email"
            value="{{ old('email') }}"
            placeholder="Nama@gmail.com" 
            required
            class="w-full px-4 py-2.5 rounded-lg border border-[#00173f] text-[#00173f] placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-900 transition"
          >
        </div>

        <!-- Input Password dengan Fitur Show/Hide -->
        <div class="space-y-1.5">
          <label class="block text-sm font-semibold text-[#00173f]">Password</label>
          <div class="relative flex items-center">
            <input 
              id="passwordInput"
              type="password" 
              name="password"
              placeholder="Minimal 6 karakter" 
              required
              class="w-full px-4 py-2.5 pr-11 rounded-lg border border-[#00173f] text-[#00173f] placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-900 transition"
            >
            <!-- Button Eye Toggle -->
            <button 
              type="button" 
              onclick="togglePasswordVisibility()" 
              class="absolute right-3 text-slate-400 hover:text-[#00173f] focus:outline-none p-1"
            >
              <!-- Icon Mata Terbuka -->
              <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 123.257 3.257 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 0 1-4.293 5.774M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
              <!-- Icon Mata Tertutup -->
              <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hidden">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.52 10.52 0 01-4.293 5.774M6.228 6.228l11.544 11.544M9.88 9.88a3 3 0 104.24 4.24" />
              </svg>
            </button>
          </div>
        </div>

        <!-- Tombol Daftar -->
        <div class="pt-3">
          <button 
            type="submit" 
            class="w-full py-3 rounded-lg bg-gradient-to-r from-blue-500 via-blue-700 to-blue-500 text-white font-bold text-center hover:opacity-95 transition duration-200 shadow-md"
          >
            Daftar
          </button>
        </div>

        <!-- Text Footer Link ke Halaman Login -->
        <div class="text-center pt-2">
          <p class="text-sm font-semibold text-[#00173f]">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login</a>
          </p>
        </div>

      </form>
    </div>

  </div>

  <!-- JavaScript Toggle Eye Password -->
  <script>
    function togglePasswordVisibility() {
      const passwordInput = document.getElementById('passwordInput');
      const eyeOpen = document.getElementById('eyeOpen');
      const eyeClosed = document.getElementById('eyeClosed');

      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeOpen.classList.add('hidden');
        eyeClosed.classList.remove('hidden');
      } else {
        passwordInput.type = 'password';
        eyeOpen.classList.remove('hidden');
        eyeClosed.classList.add('hidden');
      }
    }
  </script>

</body>
</html>