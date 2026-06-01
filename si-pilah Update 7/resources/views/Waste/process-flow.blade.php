<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Process Flow</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">

<!-- HEADER -->
<div class="bg-green-700 text-white py-5 px-6 relative shadow-md">

    <!-- Back Elegant -->
    <a href="{{ url()->previous() }}" 
       class="absolute left-6 top-1/2 -translate-y-1/2 bg-white/20 backdrop-blur-md px-4 py-2 rounded-full text-sm hover:bg-white/30 transition">
        Kembali
    </a>

    <!-- Title -->
    <div class="text-center">
        <h1 class="text-xl font-semibold">Alur Proses</h1>
        <p class="text-sm opacity-90">Bagaimana proses pengelolaan sampah Anda berlangsung</p>
    </div>
</div>

<!-- CONTENT -->
<div class="flex justify-center mt-12 px-6">

    <div class="w-full max-w-xl relative">

        <!-- LINE (STOP AT STEP 4) -->
        <div class="absolute left-1/2 -translate-x-[170px] top-10 h-[420px] w-[2px] bg-gray-300"></div>

        <!-- STEP 1 -->
        <div class="relative mb-6">
            <div class="bg-white rounded-2xl shadow-md p-6 flex items-center gap-5 w-full">
                
                <!-- ICON -->
                <div class="bg-blue-100 text-blue-600 p-4 rounded-xl z-10">✈️</div>

                <!-- CONTENT -->
                <div>
                    <span class="text-xs bg-blue-500 text-white px-3 py-1 rounded-full">Langkah 1</span>
                    <h2 class="font-semibold mt-1 text-lg">Setor Sampah</h2>
                    <p class="text-sm text-gray-500">Pengguna mengirim data sampah beserta foto dan detail</p>
                </div>
            </div>
        </div>

        <!-- STEP 2 -->
        <div class="relative mb-6">
            <div class="bg-white rounded-2xl shadow-md p-6 flex items-center gap-5 w-full">
                <div class="bg-yellow-100 text-yellow-600 p-4 rounded-xl z-10">✔️</div>
                <div>
                    <span class="text-xs bg-yellow-500 text-white px-3 py-1 rounded-full">Langkah 2</span>
                    <h2 class="font-semibold mt-1 text-lg">Validasi Admin</h2>
                    <p class="text-sm text-gray-500">Admin memeriksa dan memvalidasi data yang dikirim</p>
                </div>
            </div>
        </div>

        <!-- STEP 3 -->
        <div class="relative mb-6">
            <div class="bg-white rounded-2xl shadow-md p-6 flex items-center gap-5 w-full">
                <div class="bg-orange-100 text-orange-600 p-4 rounded-xl z-10">⚙️</div>
                <div>
                    <span class="text-xs bg-orange-500 text-white px-3 py-1 rounded-full">Langkah 3</span>
                    <h2 class="font-semibold mt-1 text-lg">Proses Pengolahan</h2>
                    <p class="text-sm text-gray-500">Sampah diproses menjadi produk yang bermanfaat</p>
                </div>
            </div>
        </div>

        <!-- STEP 4 -->
        <div class="relative mb-10">
            <div class="bg-white rounded-2xl shadow-md p-6 flex items-center gap-5 w-full">
                <div class="bg-green-100 text-green-600 p-4 rounded-xl z-10">🏅</div>
                <div>
                    <span class="text-xs bg-green-600 text-white px-3 py-1 rounded-full">Langkah 4</span>
                    <h2 class="font-semibold mt-1 text-lg">Selesai</h2>
                    <p class="text-sm text-gray-500">Proses selesai dan pengguna mendapatkan hasil atau poin</p>
                </div>
            </div>
        </div>

        <!-- TIMELINE BOX (SAMA LEBAR) -->
        <div class="bg-green-800 text-white p-6 rounded-2xl shadow-md w-full mb-6">
            <h3 class="font-semibold text-lg mb-2">Estimasi Waktu Proses</h3>
            <p class="text-sm opacity-90">
                Seluruh proses biasanya memakan waktu sekitar 2–5 hari kerja sejak pengiriman.
            </p>

            <div class="mt-4 bg-white/20 p-4 rounded-xl text-sm">
                💡 Tips: Kirim data yang lengkap dan jelas agar proses validasi lebih cepat!
            </div>
        </div>

        <!-- BUTTON -->
        <a href="/" 
           class="block text-center bg-green-700 text-white py-3 rounded-xl font-semibold hover:bg-green-800 transition w-full">
            Kembali ke Beranda
        </a>

    </div>

</div>

</body>
</html>