<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman - Si-Pilah</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .bg-sipilah-green {
            background-color: #1b5e20;
        }
        .text-sipilah-green {
            color: #1b5e20;
        }
        /* Sembunyikan elemen sebelum Alpine selesai dimuat untuk menghindari flicker */
        [x-cloak] { 
            display: none !important; 
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

    @include('partials.navbar', ['variant' => 'dashboard'])

    <div class="min-h-screen pb-16" style="background: linear-gradient(135deg, #f0fdf4 0%, #f8fafc 50%, #ecfdf5 100%);">

        {{-- Alpine.js Initialization dengan support Arsip --}}
        <div class="container mx-auto px-4 sm:px-6 py-10 max-w-5xl" 
             x-data="{ 
                activeTab: 'semua',
                archivedList: JSON.parse(localStorage.getItem('archived_announcements') || '[]'),
                allAnnouncements: [
                    @foreach($announcements as $ann)
                    @php
                        $t = strtolower($ann->judul);
                        $kat = (str_contains($t, 'selesai') || str_contains($t, 'berhasil')) ? 'pengolahan' : (str_contains($t, 'kegiatan') ? 'kegiatan' : 'pengumuman');
                    @endphp
                    { id: {{ $ann->id }}, kategori: '{{ $kat }}' },
                    @endforeach
                ],
                get activeCount() {
                    if (this.activeTab === 'arsip') {
                        return this.allAnnouncements.filter(a => this.archivedList.includes(a.id)).length;
                    }
                    return this.allAnnouncements.filter(a => {
                        if (this.archivedList.includes(a.id)) return false;
                        return this.activeTab === 'semua' || this.activeTab === a.kategori;
                    }).length;
                },
                archive(id) {
                    if(!this.archivedList.includes(id)) {
                        this.archivedList.push(id);
                        localStorage.setItem('archived_announcements', JSON.stringify(this.archivedList));
                    }
                },
                unarchive(id) {
                    this.archivedList = this.archivedList.filter(item => item !== id);
                    localStorage.setItem('archived_announcements', JSON.stringify(this.archivedList));
                }
             }">

            {{-- PAGE HEADER --}}
            <div class="mb-10">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#1b5e20] hover:text-green-900 transition group mb-5">
                    <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali ke Dashboard
                </a>

                <div class="flex items-center gap-5">
                    <div class="w-16 h-16 rounded-[22px] flex items-center justify-center shadow-md bg-sipilah-green">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Pengumuman</h1>
                        <p class="text-[15px] text-gray-500 mt-1">Kabar terbaru dan informasi penting dari Si-Pilah</p>
                    </div>
                </div>
            </div>

            {{-- FILTER TABS JENIS NOTIFIKASI --}}
            <div class="mb-8 w-full overflow-x-auto pb-2">
                <div class="bg-white p-1.5 rounded-full inline-flex border border-gray-200 shadow-sm min-w-max">
                    <button @click="activeTab = 'semua'" 
                            :class="activeTab === 'semua' ? 'bg-sipilah-green text-white shadow-md' : 'text-gray-500 hover:text-[#1b5e20] hover:bg-green-50'"
                            class="px-7 py-2.5 rounded-full text-[14px] font-semibold transition-all duration-300">
                        Semua Notifikasi
                    </button>
                    <button @click="activeTab = 'pengolahan'" 
                            :class="activeTab === 'pengolahan' ? 'bg-sipilah-green text-white shadow-md' : 'text-gray-500 hover:text-[#1b5e20] hover:bg-green-50'"
                            class="px-7 py-2.5 rounded-full text-[14px] font-semibold transition-all duration-300">
                        Pengolahan
                    </button>
                    <button @click="activeTab = 'kegiatan'" 
                            :class="activeTab === 'kegiatan' ? 'bg-sipilah-green text-white shadow-md' : 'text-gray-500 hover:text-[#1b5e20] hover:bg-green-50'"
                            class="px-7 py-2.5 rounded-full text-[14px] font-semibold transition-all duration-300">
                        Kegiatan
                    </button>
                    <button @click="activeTab = 'pengumuman'" 
                            :class="activeTab === 'pengumuman' ? 'bg-sipilah-green text-white shadow-md' : 'text-gray-500 hover:text-[#1b5e20] hover:bg-green-50'"
                            class="px-7 py-2.5 rounded-full text-[14px] font-semibold transition-all duration-300">
                        Pengumuman
                    </button>
                    <button @click="activeTab = 'arsip'" 
                            :class="activeTab === 'arsip' ? 'bg-sipilah-green text-white shadow-md' : 'text-gray-500 hover:text-[#1b5e20] hover:bg-green-50'"
                            class="px-7 py-2.5 rounded-full text-[14px] font-semibold transition-all duration-300 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                        Arsip
                    </button>
                </div>
            </div>

            {{-- ANNOUNCEMENTS CONTAINER --}}
            @if($announcements->count() > 0)
                <div class="space-y-4 w-full" x-show="activeCount > 0">
                    @foreach($announcements as $announcement)
                    @php
                        $title = strtolower($announcement->judul);

                        if (str_contains($title, 'selesai') || str_contains($title, 'berhasil')) {
                            $color = 'green';
                            $badge = 'SELESAI';
                            $kategori = 'pengolahan';
                        } elseif (str_contains($title, 'kegiatan')) {
                            $color = 'orange';
                            $badge = 'KEGIATAN';
                            $kategori = 'kegiatan';
                        } else {
                            $color = 'blue';
                            $badge = 'PENGUMUMAN';
                            $kategori = 'pengumuman';
                        }
                    @endphp

                    {{-- ELEGAN DAN RAPI BOX --}}
                    <div x-cloak 
                         x-show="(activeTab === 'arsip' && archivedList.includes({{ $announcement->id }})) || (activeTab !== 'arsip' && !archivedList.includes({{ $announcement->id }}) && (activeTab === 'semua' || activeTab === '{{ $kategori }}'))"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         class="group w-full bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 flex items-stretch
                            {{ $color == 'green' ? 'border-l-[6px] border-l-green-500' : '' }}
                            {{ $color == 'orange' ? 'border-l-[6px] border-l-orange-500' : '' }}
                            {{ $color == 'blue' ? 'border-l-[6px] border-l-blue-500' : '' }}">

                        {{-- INNER CARD LAYOUT (Simetris Sempurna Vertikal & Horizontal) --}}
                        <div class="w-full flex flex-col sm:flex-row sm:items-center justify-between gap-5 p-5 sm:p-6">
                            
                            {{-- LEFT INFO SECTION --}}
                            <div class="flex items-center gap-5 flex-1 min-w-0">
                                {{-- SOLID BOX ICON --}}
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl flex items-center justify-center text-white shadow-inner
                                        {{ $color == 'green' ? 'bg-green-600' : '' }}
                                        {{ $color == 'orange' ? 'bg-orange-500' : '' }}
                                        {{ $color == 'blue' ? 'bg-blue-600' : '' }}">

                                        @if($color == 'green')
                                            <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        @elseif($color == 'orange')
                                            <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        @else
                                            <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h8m-8 4h5m-6 7l-4-4V5a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H7l-4 4z"/>
                                            </svg>
                                        @endif
                                    </div>
                                </div>

                                {{-- TEXT WRAPPER --}}
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-base sm:text-lg font-bold text-gray-800 leading-snug group-hover:text-[#1b5e20] transition-colors duration-200">
                                        {{ $announcement->judul }}
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500 leading-relaxed">
                                        {{ $announcement->konten }}
                                    </p>

                                    {{-- METADATA --}}
                                    <div class="mt-2.5 flex items-center gap-3 text-xs text-gray-400 font-medium">
                                        <div class="flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span>{{ $announcement->created_at->diffForHumans() }}</span>
                                        </div>
                                        <span class="text-gray-200">|</span>
                                        <div class="flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            <span>Tim Si-Pilah</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- RIGHT BADGE & ACTION ROW (Sejajar Sempurna Secara Vertikal) --}}
                            <div class="flex flex-col sm:flex-row items-center justify-between sm:justify-end gap-3 shrink-0 sm:pl-4 border-t border-gray-50 sm:border-t-0 pt-3 sm:pt-0">
                                @if(isset($badge) && !str_contains(strtolower($announcement->judul), 'daur ulang'))
                                    <div class="flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold tracking-wider
                                        {{ $color == 'green' ? 'bg-green-50 text-green-700 border border-green-100' : '' }}
                                        {{ $color == 'orange' ? 'bg-orange-50 text-orange-700 border border-orange-100' : '' }}
                                        {{ $color == 'blue' ? 'bg-blue-50 text-blue-700 border border-blue-100' : '' }}">
                                        <span class="w-1.5 h-1.5 rounded-full
                                            {{ $color == 'green' ? 'bg-green-500' : '' }}
                                            {{ $color == 'orange' ? 'bg-orange-500' : '' }}
                                            {{ $color == 'blue' ? 'bg-blue-500' : '' }}">
                                        </span>
                                        {{ $badge }}
                                    </div>
                                @endif

                                {{-- Archive Button --}}
                                <button x-show="!archivedList.includes({{ $announcement->id }})" @click.prevent="archive({{ $announcement->id }})" class="text-gray-400 hover:text-red-500 bg-white hover:bg-red-50 border border-gray-200 hover:border-red-200 transition-all px-3 py-1.5 rounded-lg flex items-center gap-1.5 text-xs font-semibold shadow-sm focus:outline-none">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                                    Arsipkan
                                </button>
                                
                                {{-- Unarchive Button --}}
                                <button x-show="archivedList.includes({{ $announcement->id }})" @click.prevent="unarchive({{ $announcement->id }})" class="text-gray-400 hover:text-green-600 bg-white hover:bg-green-50 border border-gray-200 hover:border-green-200 transition-all px-3 py-1.5 rounded-lg flex items-center gap-1.5 text-xs font-semibold shadow-sm focus:outline-none">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                    Kembalikan
                                </button>
                            </div>
                            
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif

            {{-- DYNAMIC EMPTY STATE (Akan muncul jika Tab yang diklik tidak memiliki data) --}}
            <div x-cloak 
                 x-show="activeCount === 0"
                 class="bg-white rounded-[24px] border border-gray-200 shadow-sm py-20 text-center w-full">
                <div class="w-20 h-20 mx-auto rounded-full bg-green-50 flex items-center justify-center mb-5 border border-green-100">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2" x-text="activeTab === 'arsip' ? 'Belum Ada Arsip' : 'Belum Ada Pengumuman'"></h3>
                <p class="text-[15px] text-gray-400 max-w-sm mx-auto leading-relaxed">
                    <span x-show="activeTab !== 'arsip'">Saat ini informasi pada kategori <span class="font-semibold text-sipilah-green" x-text="activeTab"></span> belum tersedia.</span>
                    <span x-show="activeTab === 'arsip'">Anda belum mengarsipkan pengumuman apa pun.</span>
                </p>
            </div>

            {{-- PAGINATION --}}
            @if($announcements->count() > 0)
                <div class="mt-8" x-show="activeTab === 'semua'">
                    {{ $announcements->links() }}
                </div>
            @endif

        </div>
    </div>

    @include('partials.footer')

</body>
</html>