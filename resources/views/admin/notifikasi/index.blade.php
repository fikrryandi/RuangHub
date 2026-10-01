@extends('layouts.admin')

@section('content')
<div class="relative z-10 px-8 pb-10">

    <div class="flex justify-between items-center mb-6">
        <div class="bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-100 flex items-center gap-3">
            <div class="bg-blue-100 p-2 rounded-lg text-blue-600">
                <i class="fa-solid fa-bell"></i>
            </div>
            <div>
                <p class="text-xs text-gray-500">Total Notifikasi</p>
                <p class="text-lg font-bold text-gray-800 leading-none">
                    {{ $notifications->total() }}
                    @if($unreadCount > 0)
                    <span class="text-[10px] text-teal-500 font-normal">
                        <i class="fa-solid fa-circle-dot text-red-400"></i> {{ $unreadCount }} belum dibaca
                    </span>
                    @endif
                </p>
            </div>
        </div>
        <form action="{{ route('admin.notifikasi.read-all') }}" method="POST">
            @csrf
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-colors shadow-sm shadow-blue-200 flex items-center gap-2">
                <i class="fa-solid fa-check-double"></i> Tandai Semua Dibaca
            </button>
        </form>
    </div>


    @if(session('success'))
    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
    @endif

    <!-- Table Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Tabs & Filters -->
        <div class="p-5 border-b border-gray-100 flex flex-wrap gap-4 justify-between items-center">
            <div class="flex items-center gap-2 flex-wrap">
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium shadow-sm shadow-blue-200 flex items-center gap-2 transition-colors">
                    <i class="fa-solid fa-list"></i> Semua
                    <span class="bg-white/20 px-1.5 py-0.5 rounded text-[10px]">{{ $notifications->total() }}</span>
                </button>
                <button class="px-4 py-2 bg-white text-gray-600 hover:bg-gray-50 border border-gray-200 rounded-lg text-sm font-medium flex items-center gap-2 transition-colors">
                    <i class="fa-regular fa-calendar-check text-blue-500"></i> Booking
                    <span class="bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded text-[10px]">{{ $notifications->where('type','booking')->count() }}</span>
                </button>
                <button class="px-4 py-2 bg-white text-gray-600 hover:bg-gray-50 border border-gray-200 rounded-lg text-sm font-medium flex items-center gap-2 transition-colors">
                    <i class="fa-solid fa-check-double text-purple-500"></i> Approval
                    <span class="bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded text-[10px]">{{ $notifications->where('type','approval')->count() }}</span>
                </button>
                <button class="px-4 py-2 bg-white text-gray-600 hover:bg-gray-50 border border-gray-200 rounded-lg text-sm font-medium flex items-center gap-2 transition-colors">
                    <i class="fa-solid fa-gear text-orange-500"></i> Sistem
                    <span class="bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded text-[10px]">{{ $notifications->where('type','sistem')->count() }}</span>
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 text-xs font-semibold text-gray-500 border-b border-gray-100">
                        <th class="px-5 py-4 w-32">Jenis</th>
                        <th class="px-5 py-4 w-48">Judul</th>
                        <th class="px-5 py-4">Pesan</th>
                        <th class="px-5 py-4 w-36">Waktu</th>
                        <th class="px-5 py-4 text-center w-32">Status</th>
                        <th class="px-5 py-4 text-center w-16">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600 divide-y divide-gray-50">
                    @forelse($notifications as $n)
                    @php
                        $typeConfig = match($n->type) {
                            'booking'    => ['icon' => 'fa-calendar-check', 'color' => 'blue',   'label' => 'Booking'],
                            'approval'   => ['icon' => 'fa-check-double',   'color' => 'purple', 'label' => 'Approval'],
                            'sistem'     => ['icon' => 'fa-gear',            'color' => 'orange', 'label' => 'Sistem'],
                            default      => ['icon' => 'fa-circle-info',     'color' => 'teal',   'label' => 'Informasi'],
                        };
                    @endphp
                    <tr class="hover:bg-gray-50/50 transition-colors {{ !$n->is_read ? 'bg-blue-50/30' : '' }}">
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-{{ $typeConfig['color'] }}-50 text-{{ $typeConfig['color'] }}-600 text-[11px] font-semibold border border-{{ $typeConfig['color'] }}-100 w-full justify-center">
                                <i class="fa-solid {{ $typeConfig['icon'] }}"></i> {{ $typeConfig['label'] }}
                            </span>
                        </td>
                        <td class="px-5 py-4 font-bold text-gray-800 text-xs">
                            @if(!$n->is_read)
                                <span class="inline-block w-2 h-2 bg-red-400 rounded-full mr-1 -mt-0.5"></span>
                            @endif
                            {{ $n->title }}
                        </td>
                        <td class="px-5 py-4 text-gray-600 text-xs leading-relaxed">{{ $n->message }}</td>
                        <td class="px-5 py-4 text-gray-500 text-xs">
                            <div>{{ $n->created_at->format('d M Y') }}</div>
                            <div class="text-gray-400">{{ $n->created_at->format('H:i') }}</div>
                        </td>
                        <td class="px-5 py-4 text-center">
                            @if($n->is_read)
                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-teal-50 text-teal-600 text-[10px] font-medium border border-teal-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-teal-500"></span> Dibaca
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-pink-50 text-pink-600 text-[10px] font-medium border border-pink-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-pink-500"></span> Belum Dibaca
                            </span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-center">
                            @if($n->link)
                            <a href="{{ $n->link }}" class="w-7 h-7 rounded-full bg-blue-50 text-blue-500 hover:bg-blue-100 transition-colors flex items-center justify-center mx-auto">
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                            @else
                            <button class="w-7 h-7 rounded-full bg-gray-50 text-gray-400 hover:bg-gray-200 transition-colors flex items-center justify-center mx-auto">
                                <i class="fa-solid fa-ellipsis text-[10px]"></i>
                            </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-16 text-center">
                            <div class="flex flex-col items-center gap-3 text-gray-400">
                                <i class="fa-regular fa-bell-slash text-4xl"></i>
                                <p class="text-sm font-medium">Belum ada notifikasi</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-4 border-t border-gray-100 flex items-center justify-between bg-gray-50/50">
            <span class="text-sm text-gray-500">
                Menampilkan {{ $notifications->firstItem() ?? 0 }} – {{ $notifications->lastItem() ?? 0 }}
                dari {{ $notifications->total() }} data
            </span>
            {{ $notifications->links() }}
        </div>
    </div>
</div>
@endsection
