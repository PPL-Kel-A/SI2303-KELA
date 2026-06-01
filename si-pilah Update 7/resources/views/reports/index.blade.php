<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Laporan - Si-Pilah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>

    <style>
        body { font-family: 'Poppins', sans-serif; }
        .bg-sipilah-green { background-color: #1b5e20; }
        .text-sipilah-green { color: #1b5e20; }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            60% { transform: translateY(-20px); }
        }
        .float {
            animation: float 2.5s ease-in-out infinite;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@include('partials.navbar', ['variant' => 'dashboard'])

<div class="w-full px-6 md:px-10 lg:px-16 py-10">

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm font-medium mb-6"
             x-data="{ show: true }"
             x-show="show"
             x-init="setTimeout(() => show = false, 4000)"
             x-transition>
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="grid lg:grid-cols-4 gap-6 mb-10 items-stretch">

        <div class="lg:col-span-3 bg-sipilah-green text-white rounded-2xl px-10 py-6 shadow-lg">
            <div class="max-w-3xl">
                <p class="text-green-200 text-sm mb-2">
                    Halo, {{ auth()->user()->name ?? 'User' }} 👋
                </p>

                <h1 class="text-3xl font-bold leading-tight mb-3">
                    Pantau status laporanmu di sini 📋
                </h1>

                <p class="text-green-100 text-base mb-6">
                    Setiap laporan yang kamu kirim membantu menjaga lingkungan 🌱
                </p>

                <div class="flex gap-4 flex-wrap">
                    <a href="{{ route('reports.create') }}"
                       class="bg-white text-green-700 px-6 py-3 rounded-full font-bold text-sm hover:bg-gray-100 transition">
                        + Buat Laporan
                    </a>

                    <a href="/dashboard"
                       class="border border-white px-6 py-3 rounded-full text-sm font-semibold hover:bg-white hover:text-green-700 transition">
                        Kembali Ke Dashboard
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl px-6 py-6 shadow-lg border border-gray-100 flex flex-col justify-center items-center text-center">
            <div class="text-4xl mb-2">📊</div>

            <p class="text-sm text-gray-500">Total Laporan</p>

            <h2 class="text-3xl font-bold text-sipilah-green mt-1">
                {{ $reports->count() }}
            </h2>

            <p class="text-xs text-gray-400 mt-1">
                laporan telah dibuat
            </p>
        </div>

    </div>

    <div class="space-y-5">

        @forelse ($reports as $report)

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 overflow-hidden"
                 x-data="{ expanded: false, actionOpen: false }">

                <!-- Photo Section -->
                <div class="relative h-56 bg-gray-100 overflow-hidden">
                    @if($report->foto_laporan && Storage::disk('public')->exists($report->foto_laporan))
                        <img src="{{ asset('storage/' . $report->foto_laporan) }}" 
                             alt="{{ $report->judul }}"
                             class="w-full h-full object-cover hover:scale-105 transition duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                            <div class="text-center">
                                <p class="text-5xl mb-3">📸</p>
                                <p class="text-gray-400 text-sm">Tidak ada foto</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Content Section -->
                <div class="p-6">

                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1 min-w-0">
                            <h2 class="font-bold text-lg text-gray-800">{{ $report->judul }}</h2>
                            <p class="text-xs text-gray-400 mt-2">
                                📅 {{ $report->created_at->translatedFormat('d F Y, H:i') }}
                            </p>
                        </div>

                        <div class="flex items-center gap-2 ml-4">
                            @php
                                $colors = [
                                    'Menunggu' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700'],
                                    'Diproses' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700'],
                                    'Selesai' => ['bg' => 'bg-green-100', 'text' => 'text-green-700'],
                                    'Dibatalkan' => ['bg' => 'bg-red-100', 'text' => 'text-red-700']
                                ];
                                $c = $colors[$report->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-700'];
                            @endphp

                            <span class="px-3 py-1.5 rounded-full text-xs font-bold {{ $c['bg'] }} {{ $c['text'] }}">
                                {{ $report->status }}
                            </span>

                            <!-- Action Dropdown -->
                            <div class="relative">
                                <button @click="actionOpen = !actionOpen"
                                        class="text-gray-400 hover:text-gray-600 transition p-2 hover:bg-gray-100 rounded-lg">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.5 1.5H9.5V3.5H10.5V1.5ZM10.5 8.5H9.5V14.5H10.5V8.5ZM10.5 17.5H9.5V19.5H10.5V17.5Z"/>
                                    </svg>
                                </button>

                                <div x-show="actionOpen"
                                     @click.away="actionOpen = false"
                                     x-transition
                                     class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 z-10">
                                    <a href="{{ route('reports.edit', $report->id) }}"
                                       class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 border-b border-gray-100">
                                        <span>✏️</span>
                                        <span>Edit Laporan</span>
                                    </a>

                                    <form method="POST"
                                          action="{{ route('reports.destroy', $report->id) }}"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini? Foto akan otomatis dihapus.');"
                                          class="w-full">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50 text-left">
                                            <span>🗑️</span>
                                            <span>Hapus Laporan</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description and Detail Alamat -->
                    <div class="space-y-2 mb-4">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wide">Deskripsi:</p>
                            <p class="text-sm text-gray-700 line-clamp-2 leading-relaxed">
                                {{ $report->deskripsi }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wide">📍 Lokasi:</p>
                            <p class="text-sm text-gray-700 line-clamp-2 leading-relaxed">
                                {{ $report->detail_alamat ?? '-' }}
                            </p>
                        </div>
                    </div>

                    <!-- Expand Button -->
                    <button @click="expanded = !expanded"
                            class="w-full text-center text-sm text-sipilah-green font-semibold hover:text-green-700 transition py-2 rounded-lg hover:bg-green-50">
                        <span x-show="!expanded">Lihat Detail & Hasil Penanganan ↓</span>
                        <span x-show="expanded">Sembunyikan ↑</span>
                    </button>

                    <!-- Full Content (Expanded) -->
                    <div x-show="expanded"
                         x-transition
                         class="mt-6 pt-6 border-t border-gray-100"
                         style="display:none;">

                        <!-- Feedback Section -->
                        <div class="bg-gradient-to-br from-blue-50 via-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-200 shadow-sm">
                            <div class="flex items-center gap-2 mb-5 pb-4 border-b-2 border-blue-200">
                                <span class="text-2xl">💬</span>
                                <div>
                                    <h3 class="font-bold text-gray-800">Hasil Penanganan</h3>
                                    <p class="text-xs text-gray-500 mt-0.5">Respons dari admin pengelola sampah</p>
                                </div>
                            </div>
                            
                            @if($report->feedback)
                                <div class="space-y-4">
                                    <!-- Penjelasan Admin -->
                                    <div class="bg-white rounded-xl p-4 border border-blue-100 shadow-xs !text-left">
                                        <p class="text-xs font-bold text-blue-600 mb-3 uppercase tracking-wider">📝 Penjelasan Admin</p>
                                        <p class="text-sm text-gray-700  leading-relaxed text-left m-0 p-0">
                                            {{ $report->feedback->description }}
                                        </p>
                                    </div>

                                    <!-- Foto Hasil Penanganan -->
                                    @if($report->feedback->photo)
                                        <div class="bg-white rounded-xl p-4 border border-blue-100 shadow-xs">
                                            <p class="text-xs font-bold text-blue-600 mb-3 uppercase tracking-wider">📸 Foto Hasil Penanganan</p>
                                            <img src="{{ asset('storage/' . $report->feedback->photo) }}" 
                                                 alt="Foto Hasil" 
                                                 class="w-full h-56 object-cover rounded-lg border-2 border-blue-100 hover:shadow-md transition">
                                        </div>
                                    @endif

                                    <!-- Info Section -->
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        <div class="bg-white rounded-lg p-4 border border-blue-100">
                                            <p class="text-xs text-gray-600 mb-1">⏰ Diperbarui</p>
                                            <p class="text-sm font-semibold text-gray-700">
                                                {{ $report->feedback->updated_at->translatedFormat('d F Y, H:i') }}
                                            </p>
                                        </div>

                                        @if($report->feedback->admin)
                                            <div class="bg-white rounded-lg p-4 border border-blue-100">
                                                <p class="text-xs text-gray-600 mb-1">👤 Admin Pengelola</p>
                                                <p class="text-sm font-semibold text-gray-700">
                                                    {{ $report->feedback->admin->name }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Reward Status -->
                                    @if($report->is_rewarded)
                                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-4 border-2 border-green-300">
                                            <div class="flex items-center gap-3">
                                                <span class="text-2xl">⭐</span>
                                                <div>
                                                    <p class="text-sm font-bold text-green-700">Reward Diterima!</p>
                                                    <p class="text-xs text-green-600 mt-0.5">Kamu sudah mendapatkan <strong>10 poin</strong> untuk laporan ini</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="bg-white rounded-xl p-8 text-center border border-blue-100">
                                    <p class="text-3xl mb-3">⏳</p>
                                    <p class="text-sm text-blue-700 font-semibold mb-2">Laporan sedang dalam proses</p>
                                    <p class="text-xs text-gray-600">Admin akan segera memberikan hasil penanganan dan feedback untuk laporan Anda</p>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>

            </div>

        @empty

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center relative overflow-hidden">
                
                <div class="absolute inset-0 bg-gradient-to-br from-green-50 via-emerald-50 to-transparent opacity-50"></div>

                <div class="relative z-10">

                    <div class="text-7xl mb-6 float">📭</div>

                    <h2 class="text-2xl font-bold text-gray-800 mb-3">
                        Belum ada laporan
                    </h2>

                    <p class="text-gray-500 text-sm mb-8 max-w-sm mx-auto leading-relaxed">
                        Kamu belum membuat laporan. Yuk mulai kontribusi untuk menjaga lingkungan 🌱
                    </p>

                    <a href="{{ route('reports.create') }}"
                       class="bg-sipilah-green text-white px-8 py-3 rounded-xl text-sm font-bold hover:bg-green-700 transition shadow-md inline-block">
                        + Buat Laporan Pertama
                    </a>

                </div>

            </div>

        @endforelse

    </div>

</div>

@include('partials.footer')

</body>
</html>