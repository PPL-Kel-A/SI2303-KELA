<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panduan Pengelolaan Sampah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        .faq-answer { transition: max-height 0.3s ease, opacity 0.3s ease, padding 0.3s ease; overflow: hidden; }
    </style>
</head>

<body class="bg-[#f8fafc] font-sans">

<div class="bg-green-700 text-white py-4 px-6 relative shadow-md">
    <a href="/" class="absolute left-6 top-1/2 -translate-y-1/2 bg-white/20 backdrop-blur-md px-4 py-2 rounded-full text-sm hover:bg-white/30 transition">
        Kembali
    </a>

    <h1 class="text-center font-semibold text-lg tracking-wide">
        Panduan
    </h1>
</div>

<div class="max-w-5xl mx-auto px-6 py-16">
    
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-800 mb-3">Panduan Pengelolaan Sampah</h2>
        <p class="text-gray-500 max-w-2xl mx-auto leading-relaxed">
            Eksplorasi sumber daya komprehensif untuk memahami proses pengelolaan sampah kami, persyaratan pengiriman, dan standar operasional.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        <a href="{{ route('process.flow') }}" class="group">
            <div class="bg-white rounded-3xl p-10 shadow-[0_4px_20px_rgba(0,0,0,0.05)] border border-gray-50 
                        hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 h-full flex flex-col items-center text-center">
                
                <div class="bg-blue-600 text-white p-5 rounded-2xl mb-6 shadow-lg shadow-blue-100 group-hover:scale-110 transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>

                <h3 class="text-xl font-bold text-gray-800 mb-2">Alur Proses</h3>
                <p class="text-gray-500 text-sm mb-6">Alur operasional langkah demi langkah</p>
                
                <span class="text-blue-600 font-medium text-sm flex items-center group-hover:underline mt-auto">
                    Pelajari selengkapnya <span class="ml-2">→</span>
                </span>
            </div>
        </a>

        <a href="{{ route('waste.process') }}" class="group">
            <div class="bg-white rounded-3xl p-10 shadow-[0_4px_20px_rgba(0,0,0,0.05)] border border-gray-50 
                        hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 h-full flex flex-col items-center text-center">
                
                <div class="bg-[#ecfdf5] text-[#10b981] p-5 rounded-2xl mb-6 group-hover:scale-110 transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </div>

                <h3 class="text-xl font-bold text-gray-800 mb-2">Proses Sampah</h3>
                <p class="text-gray-500 text-sm mb-6">Pengolahan Organik vs Anorganik</p>

                <span class="text-green-600 font-medium text-sm flex items-center group-hover:underline mt-auto">
                    Pelajari selengkapnya <span class="ml-2">→</span>
                </span>
            </div>
        </a>

        <a href="{{ route('panduan.setor') }}" class="group">
            <div class="bg-white rounded-3xl p-10 shadow-[0_4px_20px_rgba(0,0,0,0.05)] border border-gray-50 
                        hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 h-full flex flex-col items-center text-center">
                
                <div class="bg-[#f5f3ff] text-[#8b5cf6] p-5 rounded-2xl mb-6 group-hover:scale-110 transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>

                <h3 class="text-xl font-bold text-gray-800 mb-2">Panduan Pengiriman</h3>
                <p class="text-gray-500 text-sm mb-6">Praktik terbaik untuk penyerahan sampah</p>

                <span class="text-purple-600 font-medium text-sm flex items-center group-hover:underline mt-auto">
                    Pelajari selengkapnya <span class="ml-2">→</span>
                </span>
            </div>
        </a>

        <a href="{{ route('rules') }}" class="group">
            <div class="bg-white rounded-3xl p-10 shadow-[0_4px_20px_rgba(0,0,0,0.05)] border border-gray-50 
                        hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 h-full flex flex-col items-center text-center">
                
                <div class="bg-[#fff1f2] text-[#f43f5e] p-5 rounded-2xl mb-6 group-hover:scale-110 transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>

                <h3 class="text-xl font-bold text-gray-800 mb-2">Aturan & Regulasi</h3>
                <p class="text-gray-500 text-sm mb-6">Kebijakan dan persyaratan kepatuhan</p>

                <span class="text-red-500 font-medium text-sm flex items-center group-hover:underline mt-auto">
                    Pelajari selengkapnya <span class="ml-2">→</span>
                </span>
            </div>
        </a>

    </div>

    {{-- FAQ Section --}}
    <div class="mt-20 mb-8" x-data="{ active: null }">
        <div class="text-center mb-10">
            <span class="inline-block bg-green-100 text-green-700 text-xs font-bold uppercase tracking-widest px-4 py-1.5 rounded-full mb-4">FAQ</span>
            <h2 class="text-3xl font-bold text-gray-800 mb-3">Pertanyaan yang Sering Diajukan</h2>
            <p class="text-gray-500 max-w-xl mx-auto">Temukan jawaban untuk pertanyaan umum seputar pengelolaan sampah di Si-Pilah.</p>
        </div>

        <div class="max-w-3xl mx-auto space-y-4">

            {{-- FAQ 1 --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <button @click="active = active === 1 ? null : 1" class="w-full flex items-center justify-between px-7 py-5 text-left hover:bg-gray-50 transition">
                    <span class="font-semibold text-gray-800">Apa saja jenis sampah yang diterima di Si-Pilah?</span>
                    <svg class="w-5 h-5 text-gray-400 transition-transform duration-300" :class="{ 'rotate-180': active === 1 }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="active === 1" x-collapse x-cloak class="px-7 pb-5 text-sm text-gray-600 leading-relaxed">
                    Si-Pilah menerima dua kategori utama: <strong>sampah organik</strong> (sisa makanan, daun, dan bahan alami lainnya) serta <strong>sampah anorganik</strong> (plastik, kertas, logam, kaca, dan elektronik kecil). Pastikan sampah sudah dipilah dengan benar sebelum disetor ke bank sampah terdekat.
                </div>
            </div>

            {{-- FAQ 2 --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <button @click="active = active === 2 ? null : 2" class="w-full flex items-center justify-between px-7 py-5 text-left hover:bg-gray-50 transition">
                    <span class="font-semibold text-gray-800">Bagaimana cara menyetorkan sampah ke bank sampah?</span>
                    <svg class="w-5 h-5 text-gray-400 transition-transform duration-300" :class="{ 'rotate-180': active === 2 }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="active === 2" x-collapse x-cloak class="px-7 pb-5 text-sm text-gray-600 leading-relaxed">
                    Anda dapat menyetorkan sampah dengan dua cara: <strong>antar langsung</strong> ke lokasi bank sampah terdekat pada jam operasional, atau <strong>jadwalkan penjemputan</strong> melalui aplikasi Si-Pilah. Pastikan sampah sudah dipilah, dibersihkan, dan dikemas rapi sebelum disetor agar proses verifikasi berjalan lebih cepat.
                </div>
            </div>

            {{-- FAQ 3 --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <button @click="active = active === 3 ? null : 3" class="w-full flex items-center justify-between px-7 py-5 text-left hover:bg-gray-50 transition">
                    <span class="font-semibold text-gray-800">Bagaimana sistem poin reward bekerja?</span>
                    <svg class="w-5 h-5 text-gray-400 transition-transform duration-300" :class="{ 'rotate-180': active === 3 }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="active === 3" x-collapse x-cloak class="px-7 pb-5 text-sm text-gray-600 leading-relaxed">
                    Setiap kali Anda menyetorkan sampah, berat dan jenis sampah akan diverifikasi oleh petugas. Poin reward diberikan berdasarkan <strong>berat (kg)</strong> dan <strong>jenis sampah</strong> yang disetor. Poin yang terkumpul dapat ditukarkan dengan berbagai hadiah menarik atau didonasikan untuk program lingkungan.
                </div>
            </div>

            {{-- FAQ 4 --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <button @click="active = active === 4 ? null : 4" class="w-full flex items-center justify-between px-7 py-5 text-left hover:bg-gray-50 transition">
                    <span class="font-semibold text-gray-800">Apakah ada batas minimum sampah yang bisa disetor?</span>
                    <svg class="w-5 h-5 text-gray-400 transition-transform duration-300" :class="{ 'rotate-180': active === 4 }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="active === 4" x-collapse x-cloak class="px-7 pb-5 text-sm text-gray-600 leading-relaxed">
                    Tidak ada batas minimum untuk penyetoran langsung ke bank sampah. Namun, untuk layanan <strong>penjemputan ke rumah</strong>, disarankan minimal <strong>2 kg</strong> agar proses penjemputan lebih efisien. Anda bisa mengumpulkan sampah terlebih dahulu selama beberapa hari sebelum menjadwalkan penjemputan.
                </div>
            </div>

            {{-- FAQ 5 --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <button @click="active = active === 5 ? null : 5" class="w-full flex items-center justify-between px-7 py-5 text-left hover:bg-gray-50 transition">
                    <span class="font-semibold text-gray-800">Apa yang terjadi pada sampah setelah disetor?</span>
                    <svg class="w-5 h-5 text-gray-400 transition-transform duration-300" :class="{ 'rotate-180': active === 5 }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="active === 5" x-collapse x-cloak class="px-7 pb-5 text-sm text-gray-600 leading-relaxed">
                    Sampah organik akan diproses menjadi <strong>kompos</strong> atau diolah menjadi <strong>bioenergi</strong>. Sampah anorganik akan disortir ulang, kemudian dikirim ke fasilitas daur ulang mitra kami untuk diproses menjadi bahan baku baru. Seluruh proses dapat Anda pantau melalui fitur <strong>tracking</strong> di aplikasi Si-Pilah.
                </div>
            </div>

        </div>
    </div>

</div>

</body>
</html>