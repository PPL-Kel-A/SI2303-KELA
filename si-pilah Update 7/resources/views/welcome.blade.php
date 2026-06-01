<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Si-Pilah | Sistem Pengelolaan Sampah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        html { scroll-behavior: smooth; }
        .bg-sipilah-green { background-color: #1b5e20; }
        .text-sipilah-green { color: #1b5e20; }
        .hero-pattern { background-image: url('https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80'); background-size: cover; background-position: center; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    @include('partials.navbar', ['variant' => 'welcome'])

    <div id="home" class="hero-pattern h-[500px] relative flex items-center">
        <div class="absolute inset-0 bg-black bg-opacity-60"></div> <div class="container mx-auto px-6 relative z-10 text-center md:text-left">
            <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-4 leading-tight">
                Ubah Sampahmu <br> <span class="text-green-400">Menjadi Energi.</span>
            </h1>
            <p class="text-lg text-gray-200 mb-8 max-w-2xl">
                Bergabunglah dengan ribuan warga kota lainnya. Pilah sampah dari rumah, jadwalkan penjemputan, dan dapatkan poin reward untuk setiap kilogram yang berkontribusi pada energi surya kota kita.
            </p>
            <a href="/register" class="bg-green-500 text-white font-bold text-lg px-8 py-4 rounded-full shadow-lg hover:bg-green-400 transition inline-block">
                Mulai Pilah Sekarang →
            </a>
        </div>
    </div>

    <div id="education" class="container mx-auto px-6 py-16 text-center">
        <h2 class="text-3xl font-bold text-gray-800 mb-12">Bagaimana Cara Kerjanya?</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="text-5xl mb-4">📝</div>
                <h3 class="text-xl font-bold mb-2">1. Daftar & Buat Akun</h3>
                <p class="text-gray-600">Buat akun Si-Pilah secara gratis untuk mulai melacak kontribusi dan mendapatkan akses ke jadwal bank sampah terdekat.</p>
            </div>
            <div id="waste-banks" class="p-6 bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="text-5xl mb-4">♻️</div>
                <h3 class="text-xl font-bold mb-2">2. Pilah & Setor</h3>
                <p class="text-gray-600">Pilah sampah organik dan anorganik. Jadwalkan penjemputan atau antar langsung ke fasilitas pengolahan kami.</p>
            </div>
            <div id="reward" class="p-6 bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="text-5xl mb-4">🎁</div>
                <h3 class="text-xl font-bold mb-2">3. Dapatkan Reward</h3>
                <p class="text-gray-600">Sampahmu akan dikonversi menjadi energi. Dapatkan poin untuk setiap kontribusi dan tukarkan dengan berbagai hadiah menarik.</p>
            </div>
        </div>
    </div>
    <div id="berita" class="bg-white py-16 border-t border-gray-100">
        <div class="container mx-auto px-6">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800">Berita & Informasi Terkini</h2>
                    <p class="text-gray-600 mt-2">Kabar terbaru dari pengelolaan sampah kota kita.</p>
                </div>
                <a href="#" class="hidden md:inline-block text-sipilah-green font-bold hover:underline">Lihat Semua Berita →</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse ($beritaTerkini as $berita)
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 hover:shadow-md transition group cursor-pointer">
                        <span class="text-[10px] font-bold bg-green-100 text-green-700 px-3 py-1 rounded-full uppercase tracking-wider">
                            {{ $berita->created_at->translatedFormat('d F Y') }}
                        </span>
                        
                        <h3 class="font-bold text-gray-800 mt-4 text-base group-hover:text-green-700 transition line-clamp-1">
                            {{ $berita->judul ?: 'Pengumuman Resmi' }}
                        </h3>
                        
                        <p class="text-gray-600 mt-2 text-xs leading-relaxed line-clamp-3">
                            {{ $berita->konten }}
                        </p>
                        
                        <div class="mt-4 text-xs font-bold text-sipilah-green group-hover:text-green-600">
                            Baca selengkapnya →
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-3 text-center py-10 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                        <span class="text-4xl block mb-3">📰</span>
                        <p class="text-gray-500 font-medium">Belum ada berita atau pengumuman terbaru saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    @if(count($reviews) > 0)
    <div id="feedback" class="bg-green-50 py-16 border-t border-green-100">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800">Apa Kata Mereka?</h2>
                <p class="text-gray-600 mt-2">Pengalaman warga yang telah bergabung dengan Si-Pilah.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach ($reviews as $review)
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative">
                        <div class="absolute -top-5 left-6 w-10 h-10 bg-gradient-to-tr from-green-400 to-emerald-600 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-md border-4 border-white">
                            {{ strtoupper(substr($review->user->name ?? '?', 0, 1)) }}
                        </div>
                        <div class="mt-4 flex text-yellow-400 mb-3">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                @else
                                    <svg class="w-5 h-5 text-gray-200" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                @endif
                            @endfor
                        </div>
                        @if(!empty($review->comment))
                            <p class="text-gray-600 italic">"{{ $review->comment }}"</p>
                        @endif
                        <p class="text-sm font-bold text-gray-800 mt-4">- {{ $review->user->name ?? 'Pengguna' }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    @include('partials.footer')

</body>
</html>