<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Poin - Si-Pilah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .bg-sipilah-green { background-color: #1b5e20; }
        .text-sipilah-green { color: #1b5e20; }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .float { animation: float 3s ease-in-out infinite; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

@include('partials.navbar', ['variant' => 'dashboard'])

<div class="w-full px-6 md:px-10 lg:px-16 py-10">

    {{-- HERO --}}
    <div class="relative bg-sipilah-green rounded-3xl px-10 py-8 shadow-xl mb-8 overflow-hidden">
        <div class="absolute right-0 top-0 w-64 h-64 bg-green-700 rounded-full -translate-y-1/2 translate-x-1/2 opacity-40"></div>
        <div class="absolute right-20 bottom-0 w-40 h-40 bg-green-600 rounded-full translate-y-1/2 opacity-30"></div>

        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <p class="text-green-300 text-sm mb-1">Halo, {{ auth()->user()->name ?? 'User' }} 👋</p>
                <h1 class="text-3xl font-bold text-white mb-2">Poin & Reward Kamu 🏆</h1>
                <p class="text-green-200 text-sm">Kumpulkan poin dari laporan & setor sampah!</p>
                <div class="flex gap-3 mt-5 flex-wrap">
                    <a href="{{ route('reports.create') }}"
                       class="bg-white text-green-800 px-5 py-2.5 rounded-full font-bold text-sm hover:bg-green-50 transition shadow">
                        📋 Buat Laporan
                    </a>
                    <a href="/dashboard"
                       class="border border-white text-white px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-white hover:text-green-800 transition">
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>

            {{-- TOTAL POIN + TUKAR BUTTON --}}
            <div class="flex flex-col gap-3 min-w-[180px]">
                <div class="bg-white/10 backdrop-blur border border-white/20 rounded-2xl px-8 py-5 text-center">
                    <div class="text-4xl mb-2 float">⭐</div>
                    <p class="text-green-200 text-xs font-semibold uppercase tracking-wider">Total Poin</p>
                    <h2 class="text-5xl font-extrabold text-white mt-1">{{ $totalPoints }}</h2>
                    <p class="text-green-300 text-xs mt-1">poin terkumpul</p>
                </div>
                <a href="{{ route('rewards.redeem') }}"
                   class="bg-yellow-400 text-green-900 px-5 py-3 rounded-2xl font-bold text-sm text-center hover:bg-yellow-300 transition shadow">
                    🎁 Tukar Poin
                </a>
            </div>
        </div>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 text-center">
            <div class="text-2xl mb-1">📋</div>
            <p class="text-2xl font-bold text-sipilah-green">{{ $rewards->where('type', 'laporan')->count() }}</p>
            <p class="text-xs text-gray-500 mt-1">Laporan Selesai</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 text-center">
            <div class="text-2xl mb-1">♻️</div>
            <p class="text-2xl font-bold text-sipilah-green">{{ $rewards->where('type', 'setor')->count() }}</p>
            <p class="text-xs text-gray-500 mt-1">Setor Sampah</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 text-center">
            <div class="text-2xl mb-1">🎁</div>
            <p class="text-2xl font-bold text-sipilah-green">{{ $rewards->sum('points') }}</p>
            <p class="text-xs text-gray-500 mt-1">Total Poin Didapat</p>
        </div>
    </div>

    {{-- RIWAYAT --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-bold text-gray-800 text-lg">📜 Riwayat Poin</h3>
            <span class="text-sm text-gray-400">{{ $rewards->count() }} transaksi</span>
        </div>

        @forelse($rewards as $reward)
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50 hover:bg-gray-50 transition">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-xl
                        {{ $reward->type === 'setor' ? 'bg-blue-50' : ($reward->type === 'manual' ? 'bg-yellow-50' : 'bg-green-50') }}">
                        {{ $reward->type === 'setor' ? '♻️' : ($reward->type === 'manual' ? '🎁' : '📋') }}
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">{{ $reward->description ?? 'Reward diterima' }}</p>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-xs px-2 py-0.5 rounded-full font-medium
                                {{ $reward->type === 'setor' ? 'bg-blue-100 text-blue-600' : ($reward->type === 'manual' ? 'bg-yellow-100 text-yellow-600' : 'bg-green-100 text-green-600') }}">
                                {{ $reward->type === 'setor' ? 'Setor Sampah' : ($reward->type === 'manual' ? 'Dari Admin' : 'Laporan Sampah') }}
                            </span>
                            <span class="text-xs text-gray-400">
                                {{ $reward->created_at->translatedFormat('d F Y, H:i') }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="text-green-600 font-bold text-lg">+{{ $reward->points }} Poin</div>
            </div>
        @empty
            <div class="p-16 text-center">
                <div class="text-7xl mb-4 float">🏆</div>
                <h2 class="text-xl font-bold text-gray-800 mb-2">Belum ada riwayat poin</h2>
                <p class="text-gray-400 text-sm mb-6">Buat laporan atau setor sampah untuk mendapatkan poin!</p>
                <a href="{{ route('reports.create') }}"
                   class="bg-sipilah-green text-white px-8 py-3 rounded-xl text-sm font-bold hover:bg-green-700 transition shadow-md inline-block">
                    + Buat Laporan
                </a>
            </div>
        @endforelse
    </div>

</div>

@include('partials.footer')
</body>
</html>