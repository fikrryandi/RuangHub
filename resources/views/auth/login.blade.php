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
        @keyframes shimmer {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .logo-animate {
            background: linear-gradient(90deg, #fff 20%, #93c5fd 40%, #fff 60%, #bfdbfe 80%, #fff 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shimmer 3s linear infinite, float 4s ease-in-out infinite;
            display: inline-block;
        }
        .logo-animate-blue {
            background: linear-gradient(90deg, #1E88E5 0%, #60a5fa 30%, #1565C0 60%, #1E88E5 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shimmer 3s linear infinite;
            display: inline-block;
        }
        .form-fade-in { animation: fadeInUp 0.6s ease-out both; }
        .form-fade-in-delay { animation: fadeInUp 0.6s ease-out 0.15s both; }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased bg-[#eef2f6]">
    <div class="min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8">
        <div class="max-w-6xl w-full bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col md:flex-row h-[750px] max-h-[90vh]">
            
            <!-- Left Side (Blue Branding) -->
            <div class="w-full md:w-1/2 relative bg-gradient-to-br from-[#1E88E5] to-[#1565C0] text-white p-10 flex flex-col justify-between hidden md:flex">
                <!-- Branding Header -->
                <div class="flex items-center space-x-3 relative z-10">
                    <img src="{{ asset('favicon.png') }}" alt="RuangHub Logo" class="w-12 h-12 rounded-xl shadow-lg object-cover">
                    <div>
                        <h1 class="text-3xl font-extrabold leading-none tracking-tight">
                            <span class="logo-animate">Ruang<span class="relative">Hub<svg class="absolute -bottom-2 left-0 w-full h-3 text-red-400" viewBox="0 0 100 20" preserveAspectRatio="none"><path d="M0,5 Q50,25 100,5" stroke="currentColor" stroke-width="8" stroke-linecap="round" fill="transparent"/></svg></span></span>
                        </h1>
                        <p class="text-blue-200 text-xs mt-2 font-medium">Room Booking System</p>
                    </div>
                </div>

                <!-- Text Content -->
                <div class="mt-12 relative z-10">
                    <h2 class="text-3xl lg:text-4xl font-bold leading-tight mb-4">
                        Booking ruang lebih mudah,<br>kerja <span class="text-blue-200">lebih produktif</span>
                    </h2>
                    <p class="text-blue-100 text-sm lg:text-base leading-relaxed max-w-md">
                        Kelola pemesanan ruang meeting, ruangan kerja, dan fasilitas lainnya dalam satu sistem yang praktis dan terintegrasi.
                    </p>
                </div>

                <!-- Logo Center Display -->
                <div class="relative flex-grow flex items-center justify-center mt-8 mb-8 z-10">
                    <div class="relative">
                        <div class="w-48 h-48 rounded-full bg-white/10 backdrop-blur-sm flex items-center justify-center shadow-2xl border border-white/20">
                            <img src="{{ asset('favicon.png') }}" alt="RuangHub" class="w-36 h-36 rounded-2xl object-cover shadow-xl">
                        </div>
                        <div class="absolute -inset-3 rounded-full border-2 border-white/20 animate-ping" style="animation-duration:3s"></div>
                        <div class="absolute -inset-6 rounded-full border border-white/10"></div>
                    </div>
                </div>

                <!-- Feature Icons -->
                <div class="grid grid-cols-4 gap-4 text-center relative z-10">
                    <div class="flex flex-col items-center">
                        <div class="bg-white/20 p-3 rounded-lg mb-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <span class="text-xs font-medium text-blue-100">Booking<br>Ruang</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="bg-white/20 p-3 rounded-lg mb-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <span class="text-xs font-medium text-blue-100">Manajemen<br>Pengguna</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="bg-white/20 p-3 rounded-lg mb-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        </div>
                        <span class="text-xs font-medium text-blue-100">Notifikasi<br>Real-time</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="bg-white/20 p-3 rounded-lg mb-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <span class="text-xs font-medium text-blue-100">Akses Aman<br>& Terpercaya</span>
                    </div>
                </div>

                <!-- Decorative Background Elements -->
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 rounded-full bg-blue-400 opacity-20 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-blue-600 opacity-30 blur-3xl"></div>
            </div>

            <!-- Right Side (Login Form) -->
            <div class="w-full md:w-1/2 p-8 md:p-12 lg:p-16 flex flex-col justify-center relative bg-white">
                
                <!-- Mobile Logo (Hidden on Desktop) -->
                <div class="flex items-center space-x-3 mb-8 md:hidden justify-center text-[#1E88E5]">
                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 4h-1V2h-2v2H8V2H6v2H5C3.89 4 3 4.9 3 6v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zm0-12H5V6h14v2zm-7 5h5v5h-5v-5z"/>
                    </svg>
                    <div>
                        <h1 class="text-2xl font-extrabold leading-none tracking-tight">
                            <span class="logo-animate-blue">Ruang<span class="relative">Hub<svg class="absolute -bottom-1 left-0 w-full h-2 text-red-500" viewBox="0 0 100 20" preserveAspectRatio="none"><path d="M0,5 Q50,25 100,5" stroke="currentColor" stroke-width="8" stroke-linecap="round" fill="transparent"/></svg></span></span>
                        </h1>
                    </div>
                </div>

                <div class="text-center mb-8">
                    <!-- Desktop Logo Centered -->
                    <div class="hidden md:flex items-center justify-center space-x-3 mb-6 text-[#1E88E5]">
                        <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 4h-1V2h-2v2H8V2H6v2H5C3.89 4 3 4.9 3 6v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zm0-12H5V6h14v2zm-7 5h5v5h-5v-5z"/>
                        </svg>
                        <div class="text-left">
                            <h1 class="text-4xl font-extrabold leading-none tracking-tight">
                                <span class="logo-animate-blue">Ruang<span class="relative">Hub<svg class="absolute -bottom-2 left-0 w-full h-3 text-red-500" viewBox="0 0 100 20" preserveAspectRatio="none"><path d="M0,5 Q50,25 100,5" stroke="currentColor" stroke-width="8" stroke-linecap="round" fill="transparent"/></svg></span></span>
                            </h1>
                            <p class="text-gray-500 text-sm mt-2 font-medium">Room Booking System</p>
                        </div>
                    </div>

                    <h2 class="text-2xl font-bold text-gray-800">Selamat Datang!</h2>
                    <p class="text-gray-500 mt-2 text-sm">Silakan login untuk melanjutkan ke sistem</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5" x-data="{ showPassword: false }">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <input id="email" class="block w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-[#1E88E5] focus:border-[#1E88E5] sm:text-sm transition-colors" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Username atau Email" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input id="password" class="block w-full pl-11 pr-12 py-3 bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-[#1E88E5] focus:border-[#1E88E5] sm:text-sm transition-colors" :type="showPassword ? 'text' : 'password'" name="password" required autocomplete="current-password" placeholder="Password" />
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <button type="button" @click="showPassword = !showPassword" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                                    <svg x-show="!showPassword" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    <svg x-show="showPassword" style="display: none;" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                                </button>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#1E88E5] shadow-sm focus:ring-[#1E88E5]" name="remember">
                            <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm font-medium text-[#1E88E5] hover:text-[#1565C0] focus:outline-none focus:underline transition-colors" href="{{ route('password.request') }}">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-md text-sm font-semibold text-white bg-[#1E88E5] hover:bg-[#1565C0] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1E88E5] transition-all transform hover:-translate-y-0.5">
                            Login &rarr;
                        </button>
                    </div>
                </form>

                <div class="mt-8 relative">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-3 bg-white text-gray-400 text-xs uppercase tracking-wide">atau</span>
                    </div>
                </div>

                <div class="mt-8">
                    <a href="/auth/google/redirect" class="w-full flex items-center justify-center py-3 px-4 border border-gray-300 rounded-xl shadow-sm bg-white text-sm font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition-colors">
                        <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/><path d="M1 1h22v22H1z" fill="none"/></svg>
                        Login dengan Google
                    </a>
                </div>

                <div class="mt-auto pt-8 text-center">
                    <p class="text-xs text-gray-400">RuangHub &copy; {{ date('Y') }}. Semua hak dilindungi.</p>
                </div>
            </div>
            
        </div>
    </div>
</body>
</html>
