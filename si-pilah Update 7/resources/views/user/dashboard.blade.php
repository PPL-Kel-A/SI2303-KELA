<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pengguna - Si-Pilah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>

    <!-- Leaflet Map Integration -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        body { font-family: 'Poppins', sans-serif; }
        .bg-sipilah-green { background-color: #1b5e20; }
        .text-sipilah-green { color: #1b5e20; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800" x-data="{ showFeedback: false, feedbackWasteId: null, rating: 0, hoverRating: 0 }">

    @include('partials.navbar', ['variant' => 'dashboard'])

    <div class="container mx-auto px-6 py-10">
        
        <div class="bg-sipilah-green rounded-2xl p-8 text-white mb-10 shadow-lg relative overflow-hidden">
            <div class="relative z-10 w-full md:w-2/3">
                <p class="text-green-200 text-lg font-semibold mb-1 tracking-wide">
                    Halo, {{ Auth::user()->name }}! 👋
                </p>
                <h1 class="text-3xl md:text-4xl font-bold mb-2 leading-tight">
                    Terima kasih sudah menjaga bumi hari ini! 🌍
                </h1>
                <p class="text-green-100 mb-6">Setiap kilogram sampah yang Anda pilah membantu menciptakan energi bersih untuk kota kita.</p>
                
                <div class="flex gap-3 flex-wrap">
                    <a href="{{ route('waste.select') }}"
                       class="bg-white text-sipilah-green font-bold px-6 py-3 rounded-full shadow hover:bg-gray-100 transition">
                        + Setor Sampah Baru
                    </a>

                    <a href="{{ route('reports.index') }}" 
                       class="border border-white text-white font-bold px-6 py-3 rounded-full hover:bg-white/10 active:scale-95 transition">
                        Lihat Laporan Saya
                    </a>
                </div>
            </div>
        </div>

        <h2 class="text-xl font-bold text-gray-700 mb-6">Pencapaian Anda</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center space-x-4 hover:shadow-md transition">
                <div class="bg-yellow-100 p-4 rounded-full text-yellow-600 text-2xl">🎁</div>
                <div>
                    <p class="text-sm text-gray-500 font-semibold">Poin Tersedia</p>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($data['poin_reward']) }} <span class="text-sm font-normal">Pts</span></p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center space-x-4 hover:shadow-md transition">
                <div class="bg-green-100 p-4 rounded-full text-green-600 text-2xl">♻️</div>
                <div>
                    <p class="text-sm text-gray-500 font-semibold">Total Sampah Disetor</p>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($data['total_sampah'], 1) }} <span class="text-sm font-normal">Kg</span></p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center space-x-4 hover:shadow-md transition">
                <div class="bg-blue-100 p-4 rounded-full text-blue-600 text-2xl">⚡</div>
                <div>
                    <p class="text-sm text-gray-500 font-semibold">Kontribusi Energi Surya</p>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($data['energi_surya_kwh'], 1) }} <span class="text-sm font-normal">kWh</span></p>
                </div>
            </div>
        </div>

    <div class="flex justify-between items-center mb-4">
        <h2 id="riwayat-setoran" class="text-xl font-bold text-gray-700">Riwayat Setoran Terakhir</h2>
    <a href="{{ route('waste.select') }}" class="text-sm font-semibold text-sipilah-green hover:underline">+ Setor Baru</a>
</div>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-10">
    @if($riwayatSampah->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                    <tr>
                        <th class="px-5 py-3 text-left">Tipe</th>
                        <th class="px-5 py-3 text-left">Kategori</th>
                        <th class="px-5 py-3 text-left">Berat</th>
                        <th class="px-5 py-3 text-left">Hasil (L)</th>
                        <th class="px-5 py-3 text-left">Poin</th> {{-- Kolom Poin --}}
                        <th class="px-5 py-3 text-left">TPS</th>
                        <th class="px-5 py-3 text-left">Tanggal</th>
                        <th class="px-5 py-3 text-left">Status</th>
                        <th class="px-5 py-3 text-center">Aksi</th> {{-- Kolom Aksi --}}
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($riwayatSampah as $waste)
                    <tr class="hover:bg-gray-50/50">
                        <td class="px-5 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-bold {{ $waste->type === 'organic' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ ucfirst($waste->type) }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-gray-700">{{ $waste->category }}</td>
                        <td class="px-5 py-3 font-semibold text-gray-800">{{ number_format($waste->weight, 2) }} Kg</td>
                        <td class="px-5 py-3 text-gray-600">{{ number_format($waste->result, 2) }}</td>
                        
                        {{-- ====================================================== --}}
                        {{-- KOLOM POIN: BERUBAH JADI TOMBOL KLAIM JIKA BELUM DIKLAIM --}}
                        {{-- ====================================================== --}}
                        <td class="px-5 py-3 font-bold">
                            @if(($waste->status ?? 'Pending') === 'Selesai')
                                @if(!($waste->is_claimed ?? false))
                                    
                                    {{-- PERBAIKAN: Ganti <a> dengan <form> agar bisa POST --}}
                                    <form action="{{ route('waste.claim', $waste->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="text-xs bg-blue-600 text-white px-2.5 py-1.5 rounded-lg font-bold hover:bg-blue-700 transition whitespace-nowrap shadow-sm animate-pulse cursor-pointer">
                                            💰 Klaim Poin
                                        </button>
                                    </form>

                                @else
                                    {{-- Jika SUDAH diklaim --}}
                                    <span class="inline-flex flex-col items-start gap-0.5">
                                        <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-bold whitespace-nowrap">✅ Poin Sudah Diklaim</span>
                                        <span class="text-green-600 text-xs">+{{ number_format($waste->points_earned ?? ($waste->result * 10)) }} Poin</span>
                                    </span>
                                @endif
                            @else
                                <span class="text-gray-400 italic text-xs">Pending</span>
                            @endif
                        </td>
                        {{-- ====================================================== --}}

                        <td class="px-5 py-3 text-gray-500 text-xs max-w-[150px] truncate" title="{{ $waste->tps }}">{{ $waste->tps }}</td>
                        <td class="px-5 py-3 text-gray-400 text-xs">{{ $waste->created_at->format('d/m/Y H:i') }}</td>
                        
                        {{-- Kolom Status --}}
                        <td class="px-5 py-3">
                            @php
                                $statusColors = [
                                    'Pending'    => 'bg-yellow-100 text-yellow-700',
                                    'Diproses'   => 'bg-blue-100 text-blue-700',
                                    'Selesai'    => 'bg-green-100 text-green-700',
                                    'Dibatalkan' => 'bg-red-100 text-red-700',
                                ];
                                $color = $statusColors[$waste->status] ?? 'bg-gray-100 text-gray-600';
                            @endphp
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $color }}">
                                {{ $waste->status ?? 'Pending' }}
                            </span>
                        </td>

                        {{-- ====================================================== --}}
                        {{-- KOLOM AKSI: TETAP UNTUK TOMBOL BERI ULASAN --}}
                        {{-- ====================================================== --}}
                        <td class="px-5 py-3 text-center">
                            @if(($waste->status ?? 'Pending') === 'Selesai')
                                @php
                                    $hasReviewed = \App\Models\Review::where('waste_id', $waste->id)->exists();
                                @endphp

                                @if(!$hasReviewed)
                                    {{-- Tombol Beri Ulasan tetap aman di sini dan tidak hilang/terganti --}}
                                    <button @click="showFeedback = true; feedbackWasteId = {{ $waste->id }}; rating = 0;" class="text-xs bg-green-50 text-green-600 px-3 py-1.5 rounded-lg font-semibold hover:bg-green-100 transition whitespace-nowrap">
                                        Beri Ulasan
                                    </button>
                                @else
                                    <span class="text-xs text-gray-400 whitespace-nowrap bg-gray-100 px-2 py-1 rounded-md">✓ Sudah Diulas</span>
                                @endif
                            @else
                                <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>
                        {{-- ====================================================== --}}

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="py-10 text-center">
            <div class="text-4xl mb-3">🗑️</div>
            <p class="text-gray-400 font-medium text-sm">Belum ada setoran sampah. <a href="{{ route('waste.select') }}" class="text-sipilah-green font-bold hover:underline">Mulai setor →</a></p>
        </div>
    @endif
</div>

        {{-- ── Jadwal Penjemputan & TPS Terdekat ── --}}
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-700">Jadwal Penjemputan & TPS Terdekat</h2>
        </div>

        @if($tpsTerdekatUser)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
                <!-- Tabel Jadwal Truk (Col-span 2) -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center gap-2">
                        <div class="flex items-center gap-2 px-4 py-2 bg-green-50 border border-green-200 rounded-xl shadow-sm">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span class="text-xs sm:text-sm font-semibold text-green-800">Wilayah Penjemputan: {{ $kelurahanUser }}</span>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        @if($jadwalMendatang->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead class="bg-gradient-to-r from-green-50 to-emerald-50 text-gray-500 text-xs uppercase">
                                        <tr>
                                            <th class="px-5 py-3 text-left">Waktu Penjemputan</th>
                                            <th class="px-5 py-3 text-left">Kategori Sampah</th>
                                            <th class="px-5 py-3 text-left">Petugas</th>
                                            <th class="px-5 py-3 text-left">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50">
                                        @foreach($jadwalMendatang as $jadwal)
                                        @php
                                            $waktu = \Carbon\Carbon::parse($jadwal->waktu_jemput);
                                            $isToday = $waktu->isToday();
                                            $isTomorrow = $waktu->isTomorrow();
                                        @endphp
                                        <tr class="hover:bg-green-50/30 transition {{ $isToday ? 'bg-green-50/50' : '' }}">
                                            <td class="px-5 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="flex-shrink-0 w-12 h-12 rounded-xl flex flex-col items-center justify-center text-center {{ $isToday ? 'bg-green-600 text-white animate-pulse' : 'bg-gray-100 text-gray-600' }}">
                                                        <span class="text-xs font-bold leading-none">{{ $waktu->translatedFormat('d') }}</span>
                                                        <span class="text-[10px] uppercase leading-none mt-0.5">{{ $waktu->translatedFormat('M') }}</span>
                                                    </div>
                                                    <div>
                                                        <p class="font-semibold text-gray-800">{{ $waktu->translatedFormat('l, d F Y') }}</p>
                                                        <p class="text-xs text-gray-500 mt-0.5">🕐 {{ $waktu->format('H:i') }} WIB</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-5 py-4">
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                                                    ♻️ {{ $jadwal->kategori }}
                                                </span>
                                            </td>
                                            <td class="px-5 py-4">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-7 h-7 rounded-lg bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-600">
                                                        {{ strtoupper(substr($jadwal->nama_petugas, 0, 1)) }}
                                                    </div>
                                                    <span class="text-gray-700 font-medium">{{ $jadwal->nama_petugas }}</span>
                                                </div>
                                            </td>
                                            <td class="px-5 py-4">
                                                @if($isToday)
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 animate-pulse">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> 🚛 Hari Ini
                                                    </span>
                                                @elseif($isTomorrow)
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Besok
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-600">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span> {{ $waktu->diffForHumans() }}
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            {{-- Kelurahan diisi tapi belum ada jadwal --}}
                            <div class="py-12 text-center">
                                <div class="text-5xl mb-3">📅</div>
                                <p class="text-gray-500 font-semibold text-sm">Jadwal belum tersedia untuk wilayah Anda.</p>
                                <p class="text-gray-400 text-xs mt-1.5 max-w-sm mx-auto">Kami akan memberi tahu Anda begitu admin menjadwalkan penjemputan berikutnya untuk wilayah <strong>{{ $kelurahanUser }}</strong>.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Info TPS Terdekat (Col-span 1) -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex flex-col justify-between hover:shadow-md transition duration-300">
                    <div>
                        <div class="flex items-center gap-2.5 mb-4">
                            <span class="flex items-center justify-center w-9 h-9 rounded-xl bg-green-100 text-green-700 font-bold text-lg">📍</span>
                            <div>
                                <h3 class="text-sm font-bold text-gray-800">TPS Terdekat Anda</h3>
                                <p class="text-[10px] text-gray-400">Tempat Pembuangan Sampah Pilihan</p>
                            </div>
                        </div>

                        <!-- Card Detail Alamat TPS -->
                        <div class="space-y-3 bg-gradient-to-br from-green-50/60 to-emerald-50/30 border border-green-100 rounded-2xl p-4 mb-4">
                            <div>
                                <p class="text-[10px] text-green-700 font-semibold uppercase tracking-wider">Nama Lokasi</p>
                                <p class="text-sm font-extrabold text-gray-800">{{ $tpsTerdekatUser['nama'] }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] text-green-700 font-semibold uppercase tracking-wider">Alamat Lengkap</p>
                                <p class="text-xs text-gray-600 leading-relaxed font-semibold">{{ $tpsTerdekatUser['address'] }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] text-green-700 font-semibold uppercase tracking-wider">Wilayah Kelurahan</p>
                                <p class="text-xs text-gray-600 font-semibold">{{ $tpsTerdekatUser['desa'] }}</p>
                            </div>
                        </div>

                        <!-- Peta Leaflet Dashboard -->
                        <div class="mb-4">
                            <p class="text-[10px] font-semibold text-gray-500 mb-1.5 flex items-center gap-1">🗺️ Titik Lokasi Peta:</p>
                            <div id="tpsDashboardMap" class="rounded-xl border border-gray-200 overflow-hidden shadow-inner" style="height: 180px; z-index: 1;"></div>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                        <p class="text-[9px] text-gray-400 leading-relaxed max-w-[80%]">
                            ℹ️ Jadwal kedatangan truk disesuaikan otomatis dengan wilayah operasional TPS terdekat Anda.
                        </p>
                        <a href="{{ route('profile.edit') }}" class="text-[10px] text-green-600 font-bold hover:underline">Ubah TPS →</a>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    const lat = {{ $tpsTerdekatUser['lat'] }};
                    const lng = {{ $tpsTerdekatUser['lng'] }};
                    const name = "{{ $tpsTerdekatUser['nama'] }}";
                    const address = "{{ $tpsTerdekatUser['address'] }}";

                    const dMap = L.map('tpsDashboardMap', {
                        zoomControl: false,
                        attributionControl: false
                    }).setView([lat, lng], 15);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19
                    }).addTo(dMap);

                    const greenIcon = L.icon({
                        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
                        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
                        iconSize: [20, 32],
                        iconAnchor: [10, 32],
                        popupAnchor: [1, -28],
                        shadowSize: [32, 32]
                    });

                    L.marker([lat, lng], { icon: greenIcon })
                        .addTo(dMap)
                        .bindPopup(`<strong>${name}</strong><br><span style="font-size:10px;color:#666">${address}</span>`)
                        .openPopup();
                });
            </script>
        @else
            {{-- User belum mengisi / mengatur TPS Terdekat --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-10 py-10 px-6 text-center hover:shadow-md transition duration-300">
                <div class="text-5xl mb-4">📍</div>
                <h3 class="text-base font-bold text-gray-800 mb-2">Jadwal & TPS Terdekat Belum Diatur</h3>
                <p class="text-gray-400 text-xs mb-6 max-w-md mx-auto leading-relaxed">
                    Silakan pilih **TPS Terdekat** pada pengaturan profil Anda agar sistem dapat menyinkronkan jadwal truk sampah dan memetakan lokasi penjemputan secara interaktif.
                </p>
                <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-2 bg-green-700 text-white px-6 py-3 rounded-xl text-sm font-bold hover:bg-green-800 transition shadow-sm active:scale-95 duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Pilih TPS Terdekat Sekarang
                </a>
            </div>
        @endif

        <h2 class="text-xl font-bold text-gray-700 mb-6">Informasi & Edukasi</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                <div class="h-40 bg-gray-200 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80');"></div>
                <div class="p-5">
                    <span class="text-xs font-bold text-sipilah-green uppercase tracking-wider">Tips</span>
                    <h3 class="font-bold text-gray-800 mt-1">Cara Memilah Sampah Plastik di Rumah</h3>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                <div class="h-40 bg-gray-200 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1611284446314-60a58ac0deb9?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80');"></div>
                <div class="p-5">
                    <span class="text-xs font-bold text-sipilah-green uppercase tracking-wider">Info Bank Sampah</span>
                    <h3 class="font-bold text-gray-800 mt-1">Jadwal Penjemputan Area Pusat Kota</h3>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                <div class="h-40 bg-gray-200 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1497436072909-60f360e1d4b1?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80');"></div>
                <div class="p-5">
                    <span class="text-xs font-bold text-sipilah-green uppercase tracking-wider">Update Energi</span>
                    <h3 class="font-bold text-gray-800 mt-1">Bagaimana Sampahmu Menjadi Listrik?</h3>
                </div>
            </div>
        </div>

        {{-- ── FAQ Section ── --}}
        <div class="mt-14 mb-4" id="faq-section">
            <div class="text-center mb-10">
                <span class="inline-block bg-green-100 text-sipilah-green text-xs font-bold uppercase tracking-widest px-4 py-1.5 rounded-full mb-3">FAQ</span>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Pertanyaan yang Sering Diajukan</h2>
                <p class="text-gray-500 mt-2 max-w-xl mx-auto text-sm">Temukan jawaban atas pertanyaan umum seputar penggunaan Si-Pilah dan pengelolaan sampah.</p>
            </div>

            <div class="max-w-3xl mx-auto space-y-4" x-data="{ activeAccordion: null }">

                {{-- FAQ 1 --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden transition-all duration-300"
                     :class="activeAccordion === 1 ? 'ring-2 ring-green-200 shadow-md' : 'hover:shadow-md'">
                    <button @click="activeAccordion = activeAccordion === 1 ? null : 1"
                            class="w-full flex items-center justify-between px-6 py-5 text-left focus:outline-none group">
                        <div class="flex items-center gap-4">
                            <span class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center text-lg"
                                  :class="activeAccordion === 1 ? 'bg-green-600 text-white' : 'bg-green-100 text-green-600'">
                                🗑️
                            </span>
                            <span class="font-semibold text-gray-800 group-hover:text-sipilah-green transition">Bagaimana cara menyetor sampah di Si-Pilah?</span>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-300 flex-shrink-0"
                             :class="activeAccordion === 1 ? 'rotate-180 text-green-600' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="activeAccordion === 1" x-collapse x-cloak>
                        <div class="px-6 pb-5 text-sm text-gray-600 leading-relaxed border-t border-gray-50 pt-4">
                            Untuk menyetor sampah, klik tombol <strong>"+ Setor Sampah Baru"</strong> di bagian atas dashboard. Pilih jenis sampah (organik atau anorganik), masukkan kategori dan berat sampah, lalu pilih lokasi TPS terdekat. Setelah konfirmasi, setoran Anda akan tercatat dan poin reward akan otomatis ditambahkan ke akun Anda.
                        </div>
                    </div>
                </div>

                {{-- FAQ 2 --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden transition-all duration-300"
                     :class="activeAccordion === 2 ? 'ring-2 ring-green-200 shadow-md' : 'hover:shadow-md'">
                    <button @click="activeAccordion = activeAccordion === 2 ? null : 2"
                            class="w-full flex items-center justify-between px-6 py-5 text-left focus:outline-none group">
                        <div class="flex items-center gap-4">
                            <span class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center text-lg"
                                  :class="activeAccordion === 2 ? 'bg-yellow-500 text-white' : 'bg-yellow-100 text-yellow-600'">
                                🎁
                            </span>
                            <span class="font-semibold text-gray-800 group-hover:text-sipilah-green transition">Bagaimana sistem poin reward bekerja?</span>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-300 flex-shrink-0"
                             :class="activeAccordion === 2 ? 'rotate-180 text-green-600' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="activeAccordion === 2" x-collapse x-cloak>
                        <div class="px-6 pb-5 text-sm text-gray-600 leading-relaxed border-t border-gray-50 pt-4">
                            Setiap kali Anda menyetor sampah, sistem akan menghitung poin berdasarkan <strong>berat dan jenis sampah</strong> yang disetor. Poin yang terkumpul dapat ditukarkan dengan berbagai reward menarik seperti voucher belanja, produk ramah lingkungan, atau donasi untuk program lingkungan. Semakin banyak sampah yang Anda pilah, semakin besar poin yang Anda dapatkan!
                        </div>
                    </div>
                </div>

                {{-- FAQ 3 --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden transition-all duration-300"
                     :class="activeAccordion === 3 ? 'ring-2 ring-green-200 shadow-md' : 'hover:shadow-md'">
                    <button @click="activeAccordion = activeAccordion === 3 ? null : 3"
                            class="w-full flex items-center justify-between px-6 py-5 text-left focus:outline-none group">
                        <div class="flex items-center gap-4">
                            <span class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center text-lg"
                                  :class="activeAccordion === 3 ? 'bg-blue-600 text-white' : 'bg-blue-100 text-blue-600'">
                                📅
                            </span>
                            <span class="font-semibold text-gray-800 group-hover:text-sipilah-green transition">Bagaimana jadwal penjemputan sampah ditentukan?</span>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-300 flex-shrink-0"
                             :class="activeAccordion === 3 ? 'rotate-180 text-green-600' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="activeAccordion === 3" x-collapse x-cloak>
                        <div class="px-6 pb-5 text-sm text-gray-600 leading-relaxed border-t border-gray-50 pt-4">
                            Jadwal penjemputan sampah diatur oleh <strong>admin Si-Pilah</strong> berdasarkan wilayah dan ketersediaan petugas. Jadwal yang sudah ditentukan akan muncul secara otomatis di bagian "Jadwal Penjemputan Mendatang" pada dashboard Anda. Anda bisa melihat tanggal, waktu, kategori sampah, dan nama petugas yang bertugas. Pastikan sampah sudah dipilah sebelum waktu penjemputan tiba.
                        </div>
                    </div>
                </div>

                {{-- FAQ 4 --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden transition-all duration-300"
                     :class="activeAccordion === 4 ? 'ring-2 ring-green-200 shadow-md' : 'hover:shadow-md'">
                    <button @click="activeAccordion = activeAccordion === 4 ? null : 4"
                            class="w-full flex items-center justify-between px-6 py-5 text-left focus:outline-none group">
                        <div class="flex items-center gap-4">
                            <span class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center text-lg"
                                  :class="activeAccordion === 4 ? 'bg-emerald-600 text-white' : 'bg-emerald-100 text-emerald-600'">
                                ♻️
                            </span>
                            <span class="font-semibold text-gray-800 group-hover:text-sipilah-green transition">Apa saja jenis sampah yang bisa disetor?</span>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-300 flex-shrink-0"
                             :class="activeAccordion === 4 ? 'rotate-180 text-green-600' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="activeAccordion === 4" x-collapse x-cloak>
                        <div class="px-6 pb-5 text-sm text-gray-600 leading-relaxed border-t border-gray-50 pt-4">
                            Si-Pilah menerima dua jenis utama sampah: <strong>Organik</strong> (sisa makanan, daun kering, sayuran, buah-buahan busuk) dan <strong>Anorganik</strong> (plastik, kertas, logam, kaca, kardus). Pastikan sampah sudah bersih dan terpisah sebelum disetor agar proses daur ulang berjalan optimal. Sampah B3 (Bahan Berbahaya dan Beracun) seperti baterai dan elektronik memerlukan penanganan khusus.
                        </div>
                    </div>
                </div>

                {{-- FAQ 5 --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden transition-all duration-300"
                     :class="activeAccordion === 5 ? 'ring-2 ring-green-200 shadow-md' : 'hover:shadow-md'">
                    <button @click="activeAccordion = activeAccordion === 5 ? null : 5"
                            class="w-full flex items-center justify-between px-6 py-5 text-left focus:outline-none group">
                        <div class="flex items-center gap-4">
                            <span class="flex-shrink-0 w-10 h-10 rounded-xl flex items-center justify-center text-lg"
                                  :class="activeAccordion === 5 ? 'bg-amber-500 text-white' : 'bg-amber-100 text-amber-600'">
                                ⚡
                            </span>
                            <span class="font-semibold text-gray-800 group-hover:text-sipilah-green transition">Apa itu kontribusi energi surya dan bagaimana cara menghitungnya?</span>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-300 flex-shrink-0"
                             :class="activeAccordion === 5 ? 'rotate-180 text-green-600' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="activeAccordion === 5" x-collapse x-cloak>
                        <div class="px-6 pb-5 text-sm text-gray-600 leading-relaxed border-t border-gray-50 pt-4">
                            Kontribusi energi surya menunjukkan <strong>estimasi energi listrik (dalam kWh)</strong> yang dihasilkan dari proses pengolahan sampah yang Anda setor. Sampah organik diolah menjadi biogas untuk pembangkit listrik, sementara daur ulang sampah anorganik menghemat energi produksi. Angka ini dihitung berdasarkan berat dan jenis sampah yang Anda setorkan, memberikan gambaran nyata dampak positif aksi Anda terhadap lingkungan.
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    @include('partials.footer')

    <!-- FEEDBACK MODAL OVERLAY -->
    <div x-show="showFeedback" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 px-4" x-transition.opacity>
        <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden" x-show="showFeedback" x-transition.scale.origin.bottom @click.away="showFeedback = false">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 text-center text-white relative">
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                </div>
                <h2 class="text-2xl font-bold">Rate Your Experience</h2>
                <p class="text-sm text-green-100 mt-1">Help us improve Si-Pilah</p>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <form action="{{ route('reviews.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="waste_id" :value="feedbackWasteId">
                    <input type="hidden" name="rating" x-model="rating">

                    <!-- Star Rating -->
                    <div class="flex justify-center space-x-2 mb-6">
                        <template x-for="star in 5">
                            <button type="button" class="focus:outline-none transition-transform hover:scale-110"
                                    @click="rating = star"
                                    @mouseover="hoverRating = star"
                                    @mouseleave="hoverRating = 0">
                                <svg class="w-10 h-10 transition-colors" 
                                     :class="(hoverRating >= star || rating >= star) ? 'text-yellow-400' : 'text-gray-300'"
                                     fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            </button>
                        </template>
                    </div>

                    <!-- Comment Area -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Any comments? (Optional)</label>
                        <textarea name="comment" rows="3" class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none resize-none transition" placeholder="Tell us about your experience..."></textarea>
                    </div>

                    <!-- Buttons -->
                    <div class="flex flex-col space-y-3">
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-xl shadow-sm transition disabled:opacity-50 disabled:cursor-not-allowed" :disabled="rating === 0">
                            Submit Review
                        </button>
                        <button type="button" @click="showFeedback = false" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold py-3 rounded-xl transition">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ── MODAL POPUP PENGUMUMAN TERBARU ── --}}
    @if($pengumumanTerbaru)
        <div x-data="{ showAnnouncement: false }"
             x-init="if (localStorage.getItem('seen_announcement_' + {{ $pengumumanTerbaru->id }}) !== 'true') { setTimeout(() => { showAnnouncement = true; }, 800); }"
             x-show="showAnnouncement"
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto"
             style="display: none;">
            
            {{-- Backdrop overlay --}}
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"
                 x-show="showAnnouncement"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="showAnnouncement = false; localStorage.setItem('seen_announcement_' + {{ $pengumumanTerbaru->id }}, 'true');"></div>

            {{-- Modal Wrapper --}}
            <div class="flex min-h-full items-center justify-center p-4 text-center">
                <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-orange-100"
                     x-show="showAnnouncement"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    
                    {{-- Decorative top glow --}}
                    <div class="h-2 bg-gradient-to-r from-orange-500 via-amber-500 to-yellow-500"></div>

                    {{-- Close Button top right --}}
                    <button class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition focus:outline-none"
                            @click="showAnnouncement = false; localStorage.setItem('seen_announcement_' + {{ $pengumumanTerbaru->id }}, 'true');">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>

                    <div class="p-6">
                        {{-- Icon & Badge Header --}}
                        <div class="flex items-center gap-2 mb-4">
                            <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-orange-100 text-orange-600 font-bold text-sm">🔔</span>
                            <span class="text-xs font-bold text-orange-600 uppercase tracking-widest">Pengumuman Penting</span>
                        </div>

                        {{-- Title --}}
                        <h3 class="text-lg font-bold text-gray-900 mb-3 leading-snug">
                            {{ $pengumumanTerbaru->judul ?: 'Pengumuman Resmi Si-Pilah' }}
                        </h3>

                        {{-- Content --}}
                        <p class="text-sm text-gray-600 leading-relaxed bg-gray-50 border border-gray-100 rounded-2xl p-4 mb-5 max-h-[220px] overflow-y-auto">
                            {{ $pengumumanTerbaru->konten }}
                        </p>

                        {{-- Footer Info --}}
                        <div class="flex items-center justify-between text-[10px] text-gray-400 font-medium mb-6">
                            <span class="flex items-center gap-1">
                                📅 Terbit: {{ $pengumumanTerbaru->created_at->translatedFormat('d F Y, H:i') }}
                            </span>
                            <span class="flex items-center gap-1">
                                Tim Si-Pilah
                            </span>
                        </div>

                        {{-- Close Button --}}
                        <button type="button"
                                class="w-full bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white font-bold py-3 rounded-2xl transition shadow-md active:scale-95 duration-100 flex items-center justify-center gap-1.5"
                                @click="showAnnouncement = false; localStorage.setItem('seen_announcement_' + {{ $pengumumanTerbaru->id }}, 'true');">
                            <span>✅</span> Mengerti & Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</body>
</html>