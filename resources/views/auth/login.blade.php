<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <title>Login - RuangHub</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .bg-login {
            background-color: #0d6efd;
            background-image: radial-gradient(circle at top right, #38bdf8 0%, #1d4ed8 70%);
            background-size: cover;
            background-position: center;
        }
        .glass-card {
            background: rgba(255, 255, 255, 1);
            border-radius: 1.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        .input-icon-wrapper {
            background-color: #f0f7ff;
            border: 1px solid #e0efff;
        }
        .input-icon-wrapper:focus-within {
            border-color: #3b82f6;
            background-color: #ffffff;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }
        .btn-primary {
            background: linear-gradient(to right, #2563eb, #3b82f6);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(to right, #1d4ed8, #2563eb);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
        }
        .google-btn {
            border: 1px solid #e5e7eb;
            background: white;
            transition: all 0.3s ease;
        }
        .google-btn:hover {
            background: #f9fafb;
            border-color: #d1d5db;
        }
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.6;
            z-index: 0;
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-900 bg-login min-h-screen relative overflow-hidden">
    
    <!-- Decorative Blobs and Waves -->
    <div class="blob w-96 h-96 bg-cyan-400 top-[-10%] right-[-5%]"></div>
    <div class="blob w-[30rem] h-[30rem] bg-blue-600 bottom-[-20%] left-[-10%]"></div>
    
    <div class="absolute inset-0 z-0 opacity-20" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 30px 30px;"></div>

    <!-- Curved Shape at Bottom -->
    <svg class="absolute bottom-0 left-0 w-full h-auto text-blue-900/10 z-0 pointer-events-none" viewBox="0 0 1440 320" preserveAspectRatio="none">
        <path fill="currentColor" fill-opacity="1" d="M0,256L48,229.3C96,203,192,149,288,154.7C384,160,480,224,576,218.7C672,213,768,139,864,128C960,117,1056,171,1152,197.3C1248,224,1344,224,1392,224L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
    </svg>

    <div class="min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8">
        <div class="w-full max-w-7xl flex flex-col lg:flex-row items-center gap-12 xl:gap-20 relative z-10">
            
            <!-- Left Content (Text & Illustration) -->
            <div class="hidden lg:flex w-full lg:w-3/5 flex-col justify-center">
                <!-- Header/Logo -->
                <div class="flex items-center space-x-4 mb-8">
                    <img src="{{ asset('favicon.png') }}" alt="RuangHub Logo" class="w-16 h-16 object-contain drop-shadow-lg">
                    <div>
                        <h1 class="text-4xl font-extrabold text-white tracking-tight leading-none">RuangHub</h1>
                        <p class="text-blue-100 text-sm mt-1 font-medium">Room Booking System</p>
                    </div>
                </div>

                <!-- Text -->
                <div class="max-w-2xl mb-8">
                    <h2 class="text-4xl xl:text-5xl font-bold text-white leading-tight mb-4">
                        Booking ruang lebih mudah,<br>kerja <span class="text-blue-200">lebih produktif</span>
                    </h2>
                    <p class="text-blue-100 text-lg leading-relaxed max-w-lg">
                        Kelola pemesanan ruang meeting, ruangan kerja, dan fasilitas lainnya dalam satu sistem yang praktis dan terintegrasi.
                    </p>
                </div>

                <!-- Features / Icons Row -->
                <div class="flex flex-wrap gap-8 text-center mt-auto">
                    <div class="flex flex-col items-center">
                        <div class="w-14 h-14 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center mb-3 text-white shadow-lg">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <span class="text-sm font-semibold text-white">Booking<br>Ruang</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-14 h-14 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center mb-3 text-white shadow-lg">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <span class="text-sm font-semibold text-white">Manajemen<br>Pengguna</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-14 h-14 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center mb-3 text-white shadow-lg">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        </div>
                        <span class="text-sm font-semibold text-white">Notifikasi<br>Real-time</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-14 h-14 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center mb-3 text-white shadow-lg">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <span class="text-sm font-semibold text-white">Akses Aman<br>& Terpercaya</span>
                    </div>
                </div>
                
                <!-- Illustration (absolute overlaying the middle) -->
                <div class="absolute right-0 top-1/2 transform -translate-y-1/2 translate-x-1/4 pointer-events-none z-0 xl:translate-x-1/3">
                    <img src="{{ asset('images/login-illustration.jpg') }}" alt="Illustration" class="w-96 lg:w-[32rem] object-contain drop-shadow-2xl mix-blend-screen" onerror="this.style.display='none'">
                </div>
            </div>

            <!-- Right Content / Form Card -->
            <div class="w-full lg:w-2/5 max-w-md">
                <div class="glass-card p-8 sm:p-10 w-full relative z-10">
                    <!-- Form Header -->
                    <div class="flex items-center space-x-3 mb-6">
                        <img src="{{ asset('favicon.png') }}" alt="RuangHub Logo" class="w-10 h-10 object-contain drop-shadow-sm">
                        <div>
                            <h1 class="text-2xl font-bold text-blue-600 tracking-tight leading-none">RuangHub</h1>
                            <p class="text-gray-500 text-[11px] font-medium mt-0.5">Room Booking System</p>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900">Selamat Datang!</h2>
                        <p class="text-gray-500 text-sm mt-1">Silakan login untuk melanjutkan ke sistem</p>
                    </div>

                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-5" x-data="{ showPassword: false, email: '{{ old('email') }}', password: '' }">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <div class="relative flex items-center input-icon-wrapper rounded-xl overflow-hidden transition-all duration-300">
                                <div class="pl-4 pr-3 py-3 text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <input id="email" class="w-full bg-transparent border-none text-gray-900 focus:ring-0 sm:text-sm py-3 px-0 placeholder-gray-400" type="email" name="email" x-model="email" required autofocus autocomplete="username" placeholder="fikriyandi@ruanghub.com" />
                                
                                <button type="button" x-show="email.length > 0" @click="email = ''" class="pr-4 pl-2 text-gray-400 hover:text-gray-600 focus:outline-none">
                                    <div class="bg-gray-200 rounded-full p-0.5">
                                        <svg class="w-3 h-3 text-gray-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    </div>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div>
                            <div class="relative flex items-center input-icon-wrapper rounded-xl overflow-hidden transition-all duration-300">
                                <div class="pl-4 pr-3 py-3 text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </div>
                                <input id="password" class="w-full bg-transparent border-none text-gray-900 focus:ring-0 sm:text-sm py-3 px-0 placeholder-gray-400" :type="showPassword ? 'text' : 'password'" name="password" x-model="password" required autocomplete="current-password" placeholder="•••••••••" />
                                
                                <button type="button" @click="showPassword = !showPassword" class="pr-4 pl-2 text-gray-400 hover:text-gray-600 focus:outline-none">
                                    <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    <svg x-show="showPassword" style="display: none;" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between mt-4">
                            <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                                <div class="relative flex items-center">
                                    <input id="remember_me" type="checkbox" class="peer h-4 w-4 rounded bg-blue-50 border-blue-300 text-blue-600 focus:ring-blue-500 cursor-pointer" name="remember" checked>
                                </div>
                                <span class="ml-2 text-sm text-gray-600 group-hover:text-gray-900 transition-colors">Ingat saya</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors focus:outline-none focus:underline" href="{{ route('password.request') }}">
                                    Lupa password?
                                </a>
                            @endif
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full flex items-center justify-center py-3 px-4 rounded-xl text-sm font-bold text-white btn-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-md">
                                Login 
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>
                    </form>

                    <div class="mt-8 relative">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center">
                            <span class="px-4 bg-white text-gray-400 text-xs uppercase font-medium tracking-widest">ATAU</span>
                        </div>
                    </div>

                    <div class="mt-8">
                        <a href="/auth/google/redirect" class="w-full flex items-center justify-center py-3 px-4 rounded-xl text-sm font-semibold text-gray-700 google-btn focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 shadow-sm">
                            <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/><path d="M1 1h22v22H1z" fill="none"/></svg>
                            Login dengan Google
                        </a>
                    </div>

                    <div class="mt-10 text-center">
                        <p class="text-[11px] text-gray-400 font-medium">RuangHub &copy; {{ date('Y') }}. Semua hak dilindungi.</p>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</body>
</html>
