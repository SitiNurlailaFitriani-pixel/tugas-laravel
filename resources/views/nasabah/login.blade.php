<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - GRIDAS BANK</title>

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
      <div class="space-y-2 pt-4">
        <h1 class="text-3xl md:text-4xl font-bold leading-tight">
          Selamat datang di<br>
          Bank Mini <span class="text-purple-300">Gridas</span>
        </h1>
        <p class="text-slate-200 text-base md:text-lg">
          Login untuk melanjutkan ke akun anda
        </p>
      </div>

      <!-- Ilustrasi Kartu & Koin -->
      <div class="pt-4 flex justify-start">
        <img 
          src="{{ asset('storage/image/login.png') }}" 
          alt="Ilustrasi Perbankan" 
          class="w-80 h-auto object-contain drop-shadow-2xl"
        >
      </div>

    </div>

    <!-- Sisi Kanan (Form Login) -->
    <div class="w-full md:w-[460px] bg-white rounded-2xl p-8 shadow-2xl">
      <h2 class="text-3xl font-bold text-[#00173f] mb-8">Login</h2>

      <!-- Alert Pesan Sukses (Hasil Redirect dari Register / Logout) -->
      @if (session('success'))
        <div class="mb-5 p-3 bg-green-100 border border-green-400 text-green-700 text-sm rounded-lg flex items-center justify-between">
          <span>{{ session('success') }}</span>
          <button onclick="this.parentElement.remove()" class="font-bold ml-2">&times;</button>
        </div>
      @endif

      <!-- Alert Pesan Error Login -->
      @if ($errors->has('login_error'))
        <div class="mb-5 p-3 bg-red-100 border border-red-400 text-red-700 text-sm rounded-lg flex items-center justify-between">
          <span>{{ $errors->first('login_error') }}</span>
          <button onclick="this.parentElement.remove()" class="font-bold ml-2">&times;</button>
        </div>
      @endif

      <!-- Form Login -->
      <form class="space-y-5" action="{{ route('login.store') }}" method="POST">
        @csrf
        
        <!-- Input Username -->
        <div class="space-y-1.5">
          <label class="block text-sm font-semibold text-[#00173f]">Username</label>
          <input 
            type="text" 
            name="username"
            value="{{ old('username') }}"
            placeholder="Masukan username" 
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
              placeholder="Masukan password" 
              required
              class="w-full px-4 py-2.5 pr-11 rounded-lg border border-[#00173f] text-[#00173f] placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-900 transition"
            >
            <!-- Tombol Toggle Eye -->
            <button 
              type="button" 
              id="togglePassword"
              class="absolute right-3 text-slate-400 hover:text-[#00173f] focus:outline-none p-1"
            >
              <!-- Icon Mata Terbuka -->
              <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
              <!-- Icon Mata Tertutup -->
              <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a10.038 10.038 0 013.682-.863c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411M3 3l18 18" />
              </svg>
            </button>
          </div>
        </div>

        <!-- Tombol Login -->
        <div class="pt-2">
          <button 
            type="submit" 
            class="w-full py-3 rounded-lg bg-gradient-to-r from-blue-500 via-blue-700 to-blue-500 text-white font-bold text-center hover:opacity-95 transition duration-200 shadow-md"
          >
            Login
          </button>
        </div>

        <!-- Link ke Register -->
        <div class="text-center pt-2">
          <p class="text-sm font-semibold text-[#00173f]">
            Belum punya akun? <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Register</a>
          </p>
        </div>

      </form>
    </div>

  </div>

  <!-- JavaScript Toggle Password -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const togglePasswordBtn = document.getElementById('togglePassword');
      const passwordInput = document.getElementById('passwordInput');
      const eyeOpen = document.getElementById('eyeOpen');
      const eyeClosed = document.getElementById('eyeClosed');

      togglePasswordBtn.addEventListener('click', function (e) {
        e.preventDefault();
        
        if (passwordInput.type === 'password') {
          passwordInput.type = 'text';
          eyeOpen.classList.add('hidden');
          eyeClosed.classList.remove('hidden');
        } else {
          passwordInput.type = 'password';
          eyeOpen.classList.remove('hidden');
          eyeClosed.classList.add('hidden');
        }
      });
    });
  </script>

</body>
</html>