<header class="bg-white shadow-sm pt-4 pb-4 z-30 sticky top-0 border-b border-gray-100">
    <div class="px-8">
        <div class="flex items-center justify-between">
            <!-- Left Side: Sidebar Toggle + Page Title -->
            <div class="flex items-center gap-4 flex-1">
                <button class="text-gray-500 hover:text-blue-600 transition-colors p-2 bg-gray-50 rounded-lg" @click="toggleSidebar()">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>

                @php
                    $routeName = Route::currentRouteName();
                    $pageMap = [
                        // Karyawan
                        'karyawan.dashboard'           => ['title' => 'Dashboard',         'icon' => 'fa-house',           'color' => 'blue'],
                        'karyawan.booking.index'       => ['title' => 'Booking Ruangan',   'icon' => 'fa-calendar-check',  'color' => 'blue'],
                        'karyawan.booking.store'       => ['title' => 'Booking Ruangan',   'icon' => 'fa-calendar-check',  'color' => 'blue'],
                        'karyawan.kalender'            => ['title' => 'Kalender Ruangan',  'icon' => 'fa-calendar-days',   'color' => 'indigo'],
                        'karyawan.booking-saya.index'  => ['title' => 'Booking Saya',      'icon' => 'fa-clipboard-list',  'color' => 'teal'],
                        'karyawan.notifikasi'          => ['title' => 'Notifikasi',         'icon' => 'fa-bell',            'color' => 'orange'],
                        'karyawan.profil.index'        => ['title' => 'Profil Saya',        'icon' => 'fa-user',            'color' => 'purple'],
                        // Admin
                        'admin.dashboard'              => ['title' => 'Dashboard',          'icon' => 'fa-house',           'color' => 'blue'],
                        'booking.index'                => ['title' => 'Booking Ruangan',    'icon' => 'fa-calendar-check',  'color' => 'blue'],
                        'booking.show'                 => ['title' => 'Detail Booking',     'icon' => 'fa-calendar-check',  'color' => 'blue'],
                        'ruangan.index'                => ['title' => 'Data Ruangan',       'icon' => 'fa-building',        'color' => 'blue'],
                        'ruangan.create'               => ['title' => 'Tambah Ruangan',     'icon' => 'fa-building',        'color' => 'blue'],
                        'ruangan.edit'                 => ['title' => 'Edit Ruangan',       'icon' => 'fa-building',        'color' => 'blue'],
                        'user.index'                   => ['title' => 'Data Pengguna',      'icon' => 'fa-users',           'color' => 'purple'],
                        'approval.index'               => ['title' => 'Approval Booking',   'icon' => 'fa-check-double',    'color' => 'teal'],
                        'admin.kalender'               => ['title' => 'Kalender Ruangan',   'icon' => 'fa-calendar-days',   'color' => 'indigo'],
                        'admin.monitoring'             => ['title' => 'Monitoring',          'icon' => 'fa-chart-line',      'color' => 'orange'],
                        'admin.laporan'                => ['title' => 'Laporan',             'icon' => 'fa-file-chart-line', 'color' => 'teal'],
                        'admin.notifikasi'             => ['title' => 'Notifikasi',          'icon' => 'fa-bell',            'color' => 'orange'],
                        'admin.pengaturan'             => ['title' => 'Pengaturan',          'icon' => 'fa-gear',            'color' => 'gray'],
                        'admin.profil.index'           => ['title' => 'Profil Saya',         'icon' => 'fa-user',            'color' => 'purple'],
                    ];
                    $page = $pageMap[$routeName] ?? ['title' => 'RuangHub', 'icon' => 'fa-calendar-check', 'color' => 'blue'];
                @endphp

                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-{{ $page['color'] }}-100 text-{{ $page['color'] }}-600 rounded-xl flex items-center justify-center">
                        <i class="fa-solid {{ $page['icon'] }} text-sm"></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-gray-800 text-base leading-none">{{ $page['title'] }}</h2>
                        <p class="text-[10px] text-gray-400 leading-none mt-0.5">RuangHub · Room Booking System</p>
                    </div>
                </div>
            </div>

            <!-- Right Side: Clock, Notification, Profile -->
            <div class="flex items-center space-x-5">
                <!-- Date and Clock -->
                <div class="hidden md:flex items-center gap-3 text-gray-600 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-100"
                     x-data="{ time: new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'}) }"
                     x-init="setInterval(() => time = new Date().toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'}), 1000)">
                    <i class="fa-regular fa-calendar text-blue-500"></i>
                    <span class="text-xs font-semibold tracking-wide">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    <div class="w-px h-4 bg-gray-200"></div>
                    <i class="fa-regular fa-clock text-blue-500"></i>
                    <span class="text-xs font-bold tracking-wide" x-text="time"></span>
                </div>

                <!-- Live Indicator -->
                <div class="hidden md:flex items-center gap-1.5 bg-red-50 text-red-600 px-2.5 py-1.5 rounded-lg border border-red-100 shadow-sm animate-pulse">
                    <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                    <span class="text-[10px] font-bold tracking-wider">LIVE</span>
                </div>

                <!-- Notification Bell -->
                <div id="live-notif-container">
                    @php $headerUnreadCount = auth()->user()->notifications()->where('is_read', false)->count(); @endphp
                <div class="relative" x-data="{ notifOpen: false }">
                    <button @click="notifOpen = !notifOpen" @click.away="notifOpen = false"
                            class="flex items-center text-gray-500 hover:text-blue-600 transition-colors focus:outline-none relative p-2 bg-gray-50 hover:bg-blue-50 rounded-lg">
                        <i class="fa-regular fa-bell text-xl"></i>
                        @if($headerUnreadCount > 0)
                        <span class="absolute top-1 right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 border-2 border-white text-white text-[8px] font-bold">
                            {{ $headerUnreadCount > 9 ? '9+' : $headerUnreadCount }}
                        </span>
                        @endif
                    </button>

                    <!-- Notification Popup -->
                    <div x-show="notifOpen" x-transition class="absolute right-0 w-80 mt-2 origin-top-right bg-white border border-gray-100 rounded-2xl shadow-xl z-50 overflow-hidden" style="display: none;">
                        <div class="p-4 border-b border-gray-50 flex justify-between items-center">
                            <h3 class="font-bold text-gray-800 text-sm">Notifikasi</h3>
                            @php
                                $recentNotifs = auth()->user()->notifications()->latest()->take(5)->get();
                            @endphp
                            <a href="{{ auth()->user()->role == 'admin' ? route('admin.notifikasi') : route('karyawan.notifikasi') }}"
                               class="text-[10px] text-blue-600 font-medium hover:underline">Lihat semua</a>
                        </div>
                        <div class="max-h-80 overflow-y-auto divide-y divide-gray-50">
                            @forelse($recentNotifs as $notif)
                            @php
                                $nc = match($notif->type) {
                                    'booking'  => ['color' => 'blue',   'icon' => 'fa-calendar-check'],
                                    'approval' => ['color' => 'purple', 'icon' => 'fa-check-double'],
                                    'sistem'   => ['color' => 'orange', 'icon' => 'fa-gear'],
                                    default    => ['color' => 'teal',   'icon' => 'fa-circle-info'],
                                };
                            @endphp
                            <div class="p-4 hover:bg-gray-50 transition-colors cursor-pointer {{ !$notif->is_read ? 'bg-blue-50/20' : '' }}"
                                 @if($notif->link) onclick="window.location='{{ $notif->link }}'" @endif>
                                <div class="flex gap-3">
                                    <div class="w-8 h-8 rounded-full bg-{{ $nc['color'] }}-50 text-{{ $nc['color'] }}-500 flex items-center justify-center shrink-0">
                                        <i class="fa-solid {{ $nc['icon'] }} text-xs"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-gray-800 mb-0.5">{{ $notif->title }}</h4>
                                        <p class="text-[10px] text-gray-500 leading-relaxed mb-1">{{ Str::limit($notif->message, 60) }}</p>
                                        <span class="text-[9px] text-gray-400">{{ $notif->created_at->diffForHumans() }}</span>
                                    </div>
                                    @if(!$notif->is_read)
                                    <div class="w-2 h-2 bg-blue-500 rounded-full shrink-0 mt-1"></div>
                                    @endif
                                </div>
                            </div>
                            @empty
                            <div class="p-6 text-center text-gray-400 text-xs">
                                <i class="fa-regular fa-bell-slash text-2xl mb-2 block"></i>
                                Belum ada notifikasi
                            </div>
                            @endforelse
                        </div>
                        <a href="{{ auth()->user()->role == 'admin' ? route('admin.notifikasi') : route('karyawan.notifikasi') }}"
                           class="block text-center p-3 text-xs text-blue-600 font-bold bg-gray-50 hover:bg-blue-50 transition-colors">
                            Lihat Semua Notifikasi
                        </a>
                    </div>
                </div>
                </div>

                <!-- User Profile -->
                @php
                    $authUser  = auth()->user();
                    $authName  = $authUser->name;
                    $authRole  = $authUser->role == 'admin' ? 'Super Admin' : ucfirst($authUser->role);
                    $authImg   = $authUser->photo
                        ? $authUser->photo
                        : 'https://ui-avatars.com/api/?name=' . urlencode($authUser->name) . '&background=1D4ED8&color=fff';
                    $profilUrl = $authUser->role == 'admin' ? route('admin.profil.index') : route('karyawan.profil.index');
                @endphp
                <div class="relative group" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 focus:outline-none pl-4 border-l border-gray-200">
                        <img class="w-10 h-10 rounded-full object-cover shadow-sm border border-gray-200" src="{{ $authImg }}" alt="Avatar">
                        <div class="text-left hidden md:block">
                            <p class="text-sm font-bold text-gray-800 leading-none mb-1">{{ $authName }}</p>
                            <p class="text-[10px] text-gray-500 leading-none">{{ $authRole }}</p>
                        </div>
                        <i class="fa-solid fa-chevron-down text-[10px] text-gray-400 ml-1 transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-transition class="absolute right-0 w-48 mt-3 origin-top-right bg-white border border-gray-100 rounded-xl shadow-xl z-50 overflow-hidden" style="display: none;">
                        <div class="py-2">
                            <a href="{{ $profilUrl }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium transition-colors">
                                <i class="fa-regular fa-user mr-2 w-4 text-center"></i> Profil Saya
                            </a>
                            <div class="border-t border-gray-50 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full px-4 py-2.5 text-sm text-left text-red-600 hover:bg-red-50 font-medium transition-colors">
                                    <i class="fa-solid fa-arrow-right-from-bracket mr-2 w-4 text-center"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        setInterval(function() {
            fetch(window.location.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    
                    const currentTable = document.getElementById('live-table-body');
                    const newTable = doc.getElementById('live-table-body');
                    if (currentTable && newTable && currentTable.innerHTML !== newTable.innerHTML) {
                        currentTable.innerHTML = newTable.innerHTML;
                    }

                    const currentNotif = document.getElementById('live-notif-container');
                    const newNotif = doc.getElementById('live-notif-container');
                    if (currentNotif && newNotif) {
                        // We must carefully replace without breaking AlpineJS state of open menu
                        // Actually if we just replace innerHTML, we might lose the 'notifOpen' state from the wrapping div
                        // Let's replace just the notification badge and the list
                        const currentBadge = currentNotif.querySelector('span.absolute.top-1.right-1');
                        const newBadge = newNotif.querySelector('span.absolute.top-1.right-1');
                        
                        // Update badge
                        if(newBadge) {
                            if(!currentBadge) {
                                // Add badge
                                currentNotif.querySelector('button').insertAdjacentHTML('beforeend', newBadge.outerHTML);
                            } else if (currentBadge.innerText !== newBadge.innerText) {
                                currentBadge.innerText = newBadge.innerText;
                            }
                        } else if(currentBadge) {
                            currentBadge.remove();
                        }

                        // Update list
                        const currentList = currentNotif.querySelector('.max-h-80');
                        const newList = newNotif.querySelector('.max-h-80');
                        if (currentList && newList && currentList.innerHTML !== newList.innerHTML) {
                            currentList.innerHTML = newList.innerHTML;
                        }
                    }
                })
                .catch(err => console.error('Polling error', err));
        }, 5000);
    });
</script>