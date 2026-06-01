<nav x-data="{ open: false }" class="bg-green-50 border-b border-green-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- KIRI -->
            <div class="flex items-center space-x-8">

                <!-- LOGO -->
                <div class="text-xl font-bold text-green-700">
                    Si-Pilah
                </div>

                <!-- MENU -->
                <div class="hidden sm:flex items-center space-x-6 font-medium">

                    <!-- BERANDA -->
                    <a href="{{ route('dashboard') }}"
                       class="px-3 py-2 rounded-md transition 
                       {{ request()->routeIs('dashboard') 
                            ? 'bg-green-100 text-green-700 font-semibold' 
                            : 'text-gray-600 hover:text-green-600' }}">
                        Beranda
                    </a>

                    <!-- EDUKASI -->
                    <a href="{{ route('education.index') }}"
                       class="px-3 py-2 rounded-md transition 
                       {{ request()->routeIs('education.*') 
                            ? 'bg-green-100 text-green-700 font-semibold' 
                            : 'text-gray-600 hover:text-green-600' }}">
                        Edukasi
                    </a>

                </div>
            </div>

            <!-- KANAN (USER) -->
            <div class="hidden sm:flex items-center space-x-4">
                @auth
                    {{-- Notification Bell --}}
                    @php
                        $unreadCount = \App\Models\Announcement::where('created_at', '>=', now()->subDays(3))->count();
                    @endphp
                    <a href="{{ route('announcements.index') }}" class="relative p-2 rounded-xl hover:bg-green-50 transition group" title="Pengumuman">
                        <svg class="w-5 h-5 text-gray-500 group-hover:text-green-700 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        @if($unreadCount > 0)
                            <span class="absolute -top-0.5 -right-0.5 flex h-4 min-w-[16px] items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white px-1 shadow-sm">
                                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                            </span>
                        @endif
                    </a>

                    {{-- Profile Avatar with Dropdown --}}
                    <div class="flex items-center space-x-3" x-data="{ openProfile: false }">
                        <span class="font-bold text-sm text-green-700 whitespace-nowrap">
                            {{ Auth::user()->name }}
                        </span>
                        <div class="relative">
                            <button @click="openProfile = !openProfile" class="rounded-full bg-gradient-to-tr from-green-400 to-[#1b5e20] p-[2.5px] hover:scale-105 transition-transform duration-300 shadow-sm focus:outline-none">
                                @if(Auth::user()->profile_photo)
                                    <img src="{{ asset('profile-photos/' . Auth::user()->profile_photo) }}" alt="Profile" class="h-9 w-9 rounded-full object-cover">
                                @else
                                    <span class="h-full w-full flex items-center justify-center rounded-full bg-white text-[#1b5e20] font-extrabold text-lg px-3 py-1">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </span>
                                @endif
                            </button>
                            <div x-show="openProfile" x-transition @click.away="openProfile = false"
                                class="absolute right-0 mt-2 w-44 bg-white border rounded-lg shadow-lg z-50"
                                :class="{ 'block': openProfile, 'hidden': !openProfile }" style="display: none;">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 rounded-t-lg">Pengaturan Profil</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-b-lg">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>

            <!-- HAMBURGER -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="p-2 rounded-md text-green-600 hover:bg-green-100">

                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />

                        <path :class="{'hidden': ! open, 'inline-flex': open }"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>

                </button>
            </div>

        </div>
    </div>

    <!-- MOBILE MENU -->
    <div x-show="open" class="sm:hidden px-4 pb-4">

        <a href="{{ route('dashboard') }}"
           class="block py-2 px-3 rounded-md transition
           {{ request()->routeIs('dashboard') 
                ? 'bg-green-100 text-green-700 font-semibold' 
                : 'text-gray-600 hover:text-green-600' }}">
            Beranda
        </a>

        <a href="{{ route('education.index') }}"
           class="block py-2 px-3 rounded-md transition
           {{ request()->routeIs('education.*') 
                ? 'bg-green-100 text-green-700 font-semibold' 
                : 'text-gray-600 hover:text-green-600' }}">
            Edukasi
        </a>

        @auth
            <div class="mt-3 text-sm text-green-700 font-semibold">
                {{ Auth::user()->name }}
            </div>
        @endauth

    </div>
</nav>