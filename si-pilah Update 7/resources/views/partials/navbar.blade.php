{{-- Shared Navbar Partial --}}
{{-- Usage: @include('partials.navbar', ['variant' => 'welcome']) or 'dashboard' --}}
<nav class="bg-white border-b-4 border-green-800 shadow-sm py-4 sticky top-0 z-50">
    <div class="container mx-auto px-6 flex justify-between items-center">
        <div class="flex items-center">
            <a href="/" class="text-2xl font-extrabold text-sipilah-green italic hover:text-green-700 transition">Si-Pilah</a>
        </div>
        
        <div class="hidden md:flex space-x-8 font-bold text-sipilah-green uppercase text-sm tracking-wider items-center">
            <a href="/" class="hover:text-green-600 transition">Home</a>
            <a href="{{ route('education.index') }}" class="hover:text-green-600 transition">Education</a>
            {{-- Waste Banks Dropdown --}}
            <div class="flex items-center space-x-1 relative" x-data="{ open: false }">
                <a href="#" class="hover:text-green-600 transition">WASTE BANKS</a>
                <button @click="open = !open" class="text-xs focus:outline-none">▼</button>
                <div x-show="open" x-transition @click.away="open = false"
                     class="hidden absolute top-full left-0 mt-2 w-40 bg-white border rounded shadow-lg z-50"
                     :class="{ 'block': open, 'hidden': !open }">
                    <a href="#" class="block px-4 py-2 hover:bg-green-100">Report</a>
                    <a href="#" class="block px-4 py-2 hover:bg-green-100">Tracking</a>
                    <a href="/dashboard#riwayat-setoran" class="block px-4 py-2 hover:bg-green-100">History</a>
                    <a href="{{ route('waste.guidelines') }}" class="block px-4 py-2 hover:bg-green-100">Guidelines & Rules</a>
                </div>
            </div>

            <a href="{{ route('rewards.index') }}" 
                class="hover:text-green-600 transition">
                Reward
            </a>
            <a href="{{ route('about') }}" class="hover:text-green-600 transition {{ request()->routeIs('about') ? 'text-green-600 border-b-2 border-green-600 pb-1' : '' }}">About</a>
            <a href="{{ route('contact') }}" class="hover:text-green-600 transition {{ request()->routeIs('contact') ? 'text-green-600 border-b-2 border-green-600 pb-1' : '' }}">Contact</a>
        </div>

        <div class="flex items-center space-x-3">
            @auth
                {{-- Admin Button --}}
                @if(Auth::user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="hidden md:inline-flex items-center gap-1.5 bg-sipilah-green text-white px-4 py-2 text-xs font-bold uppercase rounded-lg shadow hover:bg-green-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Admin
                    </a>
                @endif

                {{-- User Name (welcome page only) --}}
                @if(($variant ?? 'welcome') === 'welcome')
                    <span class="hidden md:inline-block font-bold text-sm text-sipilah-green whitespace-nowrap">{{ Auth::user()->name }}</span>
                @endif

                {{-- Notification Bell --}}
                @php
                    $unreadCount = \App\Models\Announcement::where(function($q) {
                        $q->whereNull('user_id')->orWhere('user_id', auth()->id());
                    })->whereNull('read_at')->count();
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
                <div class="flex items-center" x-data="{ openProfile: false }">
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
            @else
                <a href="/login" class="font-bold text-gray-600 hover:text-sipilah-green transition uppercase text-sm">Login</a>
                <a href="/register" class="bg-sipilah-green text-white px-5 py-2 font-bold uppercase text-sm rounded shadow hover:bg-green-700 transition">Register</a>
            @endauth
        </div>
    </div>
</nav>
