<!DOCTYPE html>
<html lang="id">
@php
    $unreadContactMessages = \App\Models\ContactMessage::unread()->count();
@endphp
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Si-Pilah Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .scrollbar-thin::-webkit-scrollbar { width: 4px; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 2px; }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'sipilah': {
                            50: '#e8f5e9',
                            100: '#c8e6c9',
                            200: '#a5d6a7',
                            300: '#81c784',
                            400: '#66bb6a',
                            500: '#4caf50',
                            600: '#43a047',
                            700: '#388e3c',
                            800: '#2e7d32',
                            900: '#1b5e20',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50" x-data="{ sidebarOpen: true, mobileSidebar: false }">

    <div class="flex min-h-screen">

        {{-- ========== SIDEBAR (Desktop) ========== --}}
        <aside class="hidden lg:flex flex-col w-72 bg-gradient-to-b from-sipilah-900 via-sipilah-800 to-sipilah-900 text-white shadow-2xl fixed inset-y-0 left-0 z-40 overflow-y-auto scrollbar-thin">
            
            {{-- Logo --}}
            <div class="px-6 py-6 border-b border-white/10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center text-xl">♻️</div>
                    <div>
                        <h1 class="text-xl font-extrabold italic tracking-tight">Si-Pilah</h1>
                        <p class="text-xs text-green-300/70 font-medium">Admin Panel</p>
                    </div>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 px-4 py-6">
                <p class="px-4 text-[10px] font-bold uppercase tracking-widest text-green-300/50 mb-3">Menu Utama</p>

                <div class="flex flex-col gap-1 mb-6">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white font-semibold shadow-sm' : 'text-green-100/70 hover:bg-white/10' }}">
                        <span class="text-lg w-6 text-center">📊</span>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('admin.users') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.users') ? 'bg-white/20 text-white font-semibold shadow-sm' : 'text-green-100/70 hover:bg-white/10' }}">
                        <span class="text-lg w-6 text-center">👥</span>
                        <span>Users</span>
                    </a>

                    <a href="{{ route('admin.wastes') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.wastes') ? 'bg-white/20 text-white font-semibold shadow-sm' : 'text-green-100/70 hover:bg-white/10' }}">
                        <span class="text-lg w-6 text-center">🗑️</span>
                        <span>Data Sampah</span>
                    </a>

                    <a href="{{ route('admin.reports') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.reports') ? 'bg-white/20 text-white font-semibold shadow-sm' : 'text-green-100/70 hover:bg-white/10' }}">
                        <span class="text-lg w-6 text-center">📋</span>
                        <span>Laporan</span>
                    </a>
                </div>

                <p class="px-4 text-[10px] font-bold uppercase tracking-widest text-green-300/50 mb-3">Manajemen</p>

                <div class="flex flex-col gap-1">
                    <a href="{{ route('admin.rewards') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.rewards') ? 'bg-white/20 text-white font-semibold shadow-sm' : 'text-green-100/70 hover:bg-white/10' }}">
                        <span class="text-lg w-6 text-center">🎁</span>
                        <span>Reward</span>
                    </a>

                    <a href="{{ route('admin.schedules') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.schedules') ? 'bg-white/20 text-white font-semibold shadow-sm' : 'text-green-100/70 hover:bg-white/10' }}">
                        <span class="text-lg w-6 text-center">📅</span>
                        <span>Jadwal</span>
                    </a>

                    <a href="{{ route('admin.announcements') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.announcements') ? 'bg-white/20 text-white font-semibold shadow-sm' : 'text-green-100/70 hover:bg-white/10' }}">
                        <span class="text-lg w-6 text-center">📢</span>
                        <span>Pengumuman</span>
                    </a>

                    <a href="{{ route('admin.educations') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.educations') ? 'bg-white/20 text-white font-semibold shadow-sm' : 'text-green-100/70 hover:bg-white/10' }}">
                        <span class="text-lg w-6 text-center">📚</span>
                        <span>Edukasi</span>
                    </a>

                    <a href="{{ route('admin.about') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.about') ? 'bg-white/20 text-white font-semibold shadow-sm' : 'text-green-100/70 hover:bg-white/10' }}">
                        <span class="text-lg w-6 text-center">ℹ️</span>
                        <span>Halaman About</span>
                    </a>

                    <a href="{{ route('admin.contact') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.contact') ? 'bg-white/20 text-white font-semibold shadow-sm' : 'text-green-100/70 hover:bg-white/10' }}">
                        <span class="text-lg w-6 text-center">📞</span>
                        <span>Halaman Contact</span>
                    </a>

                    <a href="{{ route('admin.contact.messages') }}" 
                       class="flex items-center justify-between px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.contact.messages') ? 'bg-white/20 text-white font-semibold shadow-sm' : 'text-green-100/70 hover:bg-white/10' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-lg w-6 text-center">📨</span>
                            <span>Pesan Masuk</span>
                        </div>
                        @if($unreadContactMessages > 0)
                            <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $unreadContactMessages }}</span>
                        @endif
                    </a>

                    <a href="{{ route('admin.reviews') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.reviews') ? 'bg-white/20 text-white font-semibold shadow-sm' : 'text-green-100/70 hover:bg-white/10' }}">
                        <span class="text-lg w-6 text-center">⭐</span>
                        <span>Feedback</span>
                    </a>
                </div>
            </nav>

            {{-- Admin Info --}}
            <div class="px-4 py-4 border-t border-white/10">
                <div class="flex items-center gap-3 px-3">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-green-400 to-emerald-600 flex items-center justify-center font-bold text-sm shadow shrink-0 overflow-hidden">
                        @if(Auth::user()->profile_photo)
                            <img src="{{ asset('profile-photos/' . Auth::user()->profile_photo) }}" alt="Profile" class="w-9 h-9 rounded-full object-cover">
                        @else
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-green-300/60 truncate">Administrator</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" title="Logout" class="text-green-300/50 hover:text-red-400 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- ========== MOBILE SIDEBAR OVERLAY ========== --}}
        <div x-show="mobileSidebar" x-transition.opacity @click="mobileSidebar = false"
             class="fixed inset-0 bg-black/50 z-40 lg:hidden" style="display:none;"></div>

        <aside x-show="mobileSidebar" 
               x-transition:enter="transition transform ease-out duration-300" 
               x-transition:enter-start="-translate-x-full" 
               x-transition:enter-end="translate-x-0" 
               x-transition:leave="transition transform ease-in duration-200" 
               x-transition:leave-start="translate-x-0" 
               x-transition:leave-end="-translate-x-full"
               class="fixed inset-y-0 left-0 w-72 bg-gradient-to-b from-sipilah-900 via-sipilah-800 to-sipilah-900 text-white shadow-2xl z-50 lg:hidden overflow-y-auto scrollbar-thin" style="display:none;">
            
            <div class="px-6 py-6 border-b border-white/10 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center text-xl">♻️</div>
                    <div>
                        <h1 class="text-xl font-extrabold italic">Si-Pilah</h1>
                        <p class="text-xs text-green-300/70 font-medium">Admin Panel</p>
                    </div>
                </div>
                <button @click="mobileSidebar = false" class="text-white/50 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <nav class="px-4 py-6">
                <p class="px-4 text-[10px] font-bold uppercase tracking-widest text-green-300/50 mb-3">Menu Utama</p>
                <div class="flex flex-col gap-1 mb-6">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white font-semibold' : 'text-green-100/70 hover:bg-white/10' }}"><span class="text-lg w-6 text-center">📊</span><span>Dashboard</span></a>
                    <a href="{{ route('admin.users') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.users') ? 'bg-white/20 text-white font-semibold' : 'text-green-100/70 hover:bg-white/10' }}"><span class="text-lg w-6 text-center">👥</span><span>Users</span></a>
                    <a href="{{ route('admin.wastes') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.wastes') ? 'bg-white/20 text-white font-semibold' : 'text-green-100/70 hover:bg-white/10' }}"><span class="text-lg w-6 text-center">🗑️</span><span>Data Sampah</span></a>
                    <a href="{{ route('admin.reports') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.reports') ? 'bg-white/20 text-white font-semibold' : 'text-green-100/70 hover:bg-white/10' }}"><span class="text-lg w-6 text-center">📋</span><span>Laporan</span></a>
                </div>
                
                <p class="px-4 text-[10px] font-bold uppercase tracking-widest text-green-300/50 mb-3">Manajemen</p>
                <div class="flex flex-col gap-1">
                    <a href="{{ route('admin.rewards') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.rewards') ? 'bg-white/20 text-white font-semibold' : 'text-green-100/70 hover:bg-white/10' }}"><span class="text-lg w-6 text-center">🎁</span><span>Reward</span></a>
                    <a href="{{ route('admin.schedules') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.schedules') ? 'bg-white/20 text-white font-semibold' : 'text-green-100/70 hover:bg-white/10' }}"><span class="text-lg w-6 text-center">📅</span><span>Jadwal</span></a>
                    <a href="{{ route('admin.announcements') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.announcements') ? 'bg-white/20 text-white font-semibold' : 'text-green-100/70 hover:bg-white/10' }}"><span class="text-lg w-6 text-center">📢</span><span>Pengumuman</span></a>
                    <a href="{{ route('admin.educations') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.educations') ? 'bg-white/20 text-white font-semibold' : 'text-green-100/70 hover:bg-white/10' }}"><span class="text-lg w-6 text-center">📚</span><span>Edukasi</span></a>
                    <a href="{{ route('admin.about') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.about') ? 'bg-white/20 text-white font-semibold' : 'text-green-100/70 hover:bg-white/10' }}"><span class="text-lg w-6 text-center">ℹ️</span><span>Halaman About</span></a>
                    <a href="{{ route('admin.contact') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.contact') ? 'bg-white/20 text-white font-semibold' : 'text-green-100/70 hover:bg-white/10' }}"><span class="text-lg w-6 text-center">📞</span><span>Halaman Contact</span></a>
                    <a href="{{ route('admin.contact.messages') }}" class="flex items-center justify-between px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.contact.messages') ? 'bg-white/20 text-white font-semibold' : 'text-green-100/70 hover:bg-white/10' }}">
                        <div class="flex items-center gap-3"><span class="text-lg w-6 text-center">📨</span><span>Pesan Masuk</span></div>
                        @if($unreadContactMessages > 0)<span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $unreadContactMessages }}</span>@endif
                    </a>
                    <a href="{{ route('admin.reviews') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.reviews') ? 'bg-white/20 text-white font-semibold' : 'text-green-100/70 hover:bg-white/10' }}"><span class="text-lg w-6 text-center">⭐</span><span>Feedback</span></a>
                </div>
            </nav>
        </aside>

        {{-- ========== MAIN CONTENT ========== --}}
        <div class="flex-1 lg:ml-72">
            {{-- Top Bar --}}
            <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-lg border-b border-gray-200/50 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <button @click="mobileSidebar = true" class="lg:hidden text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>
                        <div>
                            <h2 class="text-lg font-bold text-gray-800">@yield('page-title', 'Dashboard')</h2>
                            <p class="text-xs text-gray-400">@yield('page-description', 'Overview sistem')</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="/" class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-600 px-3 py-2 rounded-lg font-medium transition" target="_blank">🌐 Lihat Situs</a>
                    </div>
                </div>
            </header>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mx-6 mt-4" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition>
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm font-medium flex items-center justify-between">
                        <span>✅ {{ session('success') }}</span>
                        <button @click="show = false" class="text-green-400 hover:text-green-600">&times;</button>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mx-6 mt-4" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition>
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm font-medium flex items-center justify-between">
                        <span>❌ {{ session('error') }}</span>
                        <button @click="show = false" class="text-red-400 hover:text-red-600">&times;</button>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mx-6 mt-4">
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm font-medium">
                        <p class="font-bold mb-1">⚠️ Terdapat kesalahan:</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- Page Content --}}
            <main class="p-6">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

</body>
</html>
