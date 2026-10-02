<!DOCTYPE html>
<html lang="en" :class="{ 'dark': darkMode }" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karyawan - RuangHub</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- AlpineJS for interaction -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        /* Transitions */
        html, body, .bg-white, .bg-\[\#F0F5FB\] {
            transition: background-color 0.4s ease, border-color 0.4s ease, box-shadow 0.4s ease;
        }

        /* Light Mode Boxes - Aesthetic Glow */
        main .bg-white, header.bg-white, aside, .modal-content, [x-show*="Modal"] > div > div {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(240, 247, 255, 0.7) 100%) !important;
            backdrop-filter: blur(20px) !important;
            -webkit-backdrop-filter: blur(20px) !important;
            border: 1px solid rgba(255, 255, 255, 0.9) !important;
            box-shadow: 0 0 25px rgba(59, 130, 246, 0.15) !important; /* Glow Effect */
        }

        /* Dark Mode Overrides */
        .dark body, .dark .bg-\[\#F0F5FB\] {
            background-color: #0f172a !important; /* Very Dark Slate */
        }
        
        .dark main .bg-white, .dark header.bg-white, .dark aside, .dark .modal-content, .dark [x-show*="Modal"] > div > div {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.7) 0%, rgba(15, 23, 42, 0.8) 100%) !important;
            border: 1px solid rgba(56, 189, 248, 0.25) !important;
            box-shadow: 0 0 35px rgba(56, 189, 248, 0.15), inset 0 0 15px rgba(56, 189, 248, 0.05) !important; /* Dark Glow */
        }
        
        .dark .text-gray-800, .dark .text-gray-700, .dark .text-gray-600 {
            color: #e2e8f0 !important;
        }
        .dark .text-gray-500, .dark .text-gray-400 {
            color: #94a3b8 !important;
        }
        .dark .bg-gray-50, .dark .bg-gray-100 {
            background-color: rgba(30, 41, 59, 0.6) !important;
        }
        .dark .border-gray-100, .dark .border-gray-200 {
            border-color: rgba(51, 65, 85, 0.8) !important;
        }
        .dark input, .dark select, .dark textarea {
            background-color: rgba(15, 23, 42, 0.6) !important;
            color: #e2e8f0 !important;
            border-color: rgba(56, 189, 248, 0.3) !important;
        }
        .dark th {
            background-color: rgba(30, 41, 59, 0.9) !important;
            color: #e2e8f0 !important;
            border-color: rgba(51, 65, 85, 0.8) !important;
        }

        /* Keep headers in modals solid if they have blue gradients */
        main .bg-white .bg-gradient-to-r, .dark main .bg-white .bg-gradient-to-r {
            border: none !important;
        }
        
        /* Decorative SVG fix in dark mode */
        .dark svg path[fill="#CBE0FF"] { fill: #1e293b !important; }
        .dark svg path[fill="#DCEBFF"] { fill: #0f172a !important; }
    </style>
</head>
<body class="bg-[#F0F5FB] font-['Plus_Jakarta_Sans'] antialiased text-gray-800">
    <div class="flex h-screen overflow-hidden" x-data="{
        sidebarOpen: true,
        sidebarReady: false,
        init() {
            this.sidebarOpen = localStorage.getItem('sidebarOpen') !== 'false';
            this.$nextTick(() => { this.sidebarReady = true; });
        },
        toggleSidebar() {
            this.sidebarOpen = !this.sidebarOpen;
            localStorage.setItem('sidebarOpen', this.sidebarOpen);
        }
    }">

        <!-- Sidebar -->
        @include('components.sidebar-karyawan')

        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden bg-[#F0F5FB]">
            <!-- Decorative Background -->
            <div class="absolute top-0 left-0 w-full h-80 z-0 pointer-events-none overflow-hidden">
                <svg viewBox="0 0 1440 320" class="absolute top-0 left-0 w-full opacity-40"><path fill="#CBE0FF" fill-opacity="1" d="M0,128L48,133.3C96,139,192,149,288,149.3C384,149,480,139,576,138.7C672,139,768,149,864,165.3C960,181,1056,203,1152,192C1248,181,1344,139,1392,117.3L1440,96L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path></svg>
                <svg viewBox="0 0 1440 320" class="absolute top-0 left-0 w-full opacity-30"><path fill="#DCEBFF" fill-opacity="1" d="M0,224L60,208C120,192,240,160,360,165.3C480,171,600,213,720,202.7C840,192,960,128,1080,112C1200,96,1320,128,1380,144L1440,160L1440,0L1380,0C1320,0,1200,0,1080,0C960,0,840,0,720,0C600,0,480,0,360,0C240,0,120,0,60,0L0,0Z"></path></svg>
            </div>

            <!-- Header -->
            @include('components.header')

            <!-- Main Content -->
            <main class="w-full grow p-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>