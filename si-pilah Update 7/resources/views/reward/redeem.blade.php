<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tukar Poin - Si-Pilah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .bg-sipilah-green { background-color: #1b5e20; }
        .text-sipilah-green { color: #1b5e20; }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">

@include('partials.navbar', ['variant' => 'dashboard'])

<div class="w-full px-6 md:px-10 lg:px-16 py-10">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <a href="{{ route('rewards.index') }}" class="text-sm text-gray-400 hover:text-green-700 transition mb-2 inline-block">
                ← Kembali ke Riwayat Poin
            </a>
            <h1 class="text-3xl font-extrabold text-green-800">🎁 Tukar Poin</h1>
            <p class="text-gray-500 mt-1">Tukarkan poinmu dengan voucher belanja favorit!</p>
        </div>
        <div class="bg-sipilah-green text-white px-8 py-5 rounded-2xl shadow-lg text-center min-w-[180px]">
            <p class="text-green-200 text-xs uppercase tracking-wider font-semibold">Poin Kamu</p>
            <h2 class="text-5xl font-extrabold mt-1">{{ auth()->user()->points }}</h2>
            <p class="text-green-300 text-xs mt-1">poin tersedia</p>
        </div>
    </div>

    {{-- FLASH --}}
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl mb-6 font-medium">
            ✅ {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl mb-6 font-medium">
            ❌ {{ session('error') }}
        </div>
    @endif

    {{-- VOUCHER GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($vouchers as $voucher)
        @php $canRedeem = auth()->user()->points >= $voucher['points']; @endphp

        <div class="bg-white rounded-3xl shadow-md overflow-hidden border border-gray-100 hover:shadow-xl transition duration-300">

            {{-- TOP --}}
            <div class="relative">
                {{-- Background warna brand --}}
                <div class="h-32 {{ $voucher['bg'] }} flex items-center justify-center relative overflow-hidden">
                    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_70%_50%,white,transparent)]"></div>
                    {{-- Logo pakai img dari URL resmi --}}
                    <img src="{{ $voucher['logo_url'] }}"
                         alt="{{ $voucher['brand'] }}"
                         class="h-16 object-contain drop-shadow-md"
                         onerror="this.style.display='none'">
                </div>

                {{-- Badge poin --}}
                <div class="absolute top-3 right-3 bg-white rounded-xl px-3 py-1.5 shadow text-center">
                    <p class="text-xs text-gray-400 leading-none">Tukar</p>
                    <p class="font-extrabold text-sipilah-green text-lg leading-tight">{{ $voucher['points'] }}</p>
                    <p class="text-xs text-gray-400 leading-none">Poin</p>
                </div>
            </div>

            {{-- CONTENT --}}
            <div class="px-5 py-4">
                <div class="flex items-start justify-between mb-1">
                    <div>
                        <h2 class="font-extrabold text-gray-800 text-lg leading-tight">{{ $voucher['brand'] }}</h2>
                        <p class="text-green-600 font-bold text-sm">{{ $voucher['title'] }}</p>
                    </div>
                    <span class="bg-red-100 text-red-600 text-xs font-bold px-2 py-0.5 rounded-full mt-1">Limited</span>
                </div>

                <p class="text-gray-500 text-xs mt-2 mb-3 leading-relaxed">{{ $voucher['desc'] }}</p>

                <div class="flex items-center justify-between text-xs text-gray-400 mb-1">
                    <span>Berlaku s/d 31 Des 2026</span>
                </div>

                {{-- PROGRESS --}}
                <div class="mb-4">
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-gray-400">Poinmu: <span class="font-semibold text-gray-600">{{ auth()->user()->points }}</span></span>
                        <span class="text-gray-400">Butuh: <span class="font-semibold text-gray-600">{{ $voucher['points'] }}</span></span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-1.5">
                        <div class="h-1.5 rounded-full {{ $canRedeem ? 'bg-green-500' : 'bg-orange-400' }}"
                             style="width: {{ min(100, (auth()->user()->points / $voucher['points']) * 100) }}%">
                        </div>
                    </div>
                </div>

                <form action="{{ route('rewards.claim', ['id' => $voucher['id']]) }}" method="POST">
                    @csrf
                    @if($canRedeem)
                        <button type="submit"
                                onclick="return confirm('Tukar {{ $voucher['points'] }} poin dengan {{ $voucher['brand'] }} {{ $voucher['title'] }}?')"
                                class="w-full py-3 rounded-2xl font-bold text-sm bg-sipilah-green hover:bg-green-700 text-white transition">
                            🎁 Tukar Sekarang
                        </button>
                    @else
                        <button type="button" disabled
                                class="w-full py-3 rounded-2xl font-bold text-sm bg-gray-100 text-gray-400 cursor-not-allowed">
                            ⚠️ Poin Tidak Cukup
                        </button>
                    @endif
                </form>
            </div>
        </div>
        @endforeach
    </div>

</div>

@include('partials.footer')
</body>
</html>