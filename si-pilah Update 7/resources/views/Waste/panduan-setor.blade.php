<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Panduan Setor Sampah</title>
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
    <h1 class="text-center font-semibold text-lg tracking-wide">
        Panduan Setor Sampah
    </h1>
</div>

<!-- CONTENT -->
<div class="flex justify-center mt-10 px-6 pb-10">
    <div class="w-full max-w-5xl">

        <!-- INFO BOX -->
        <div class="bg-white rounded-2xl shadow-md p-6 mb-8 border border-gray-100">
            <div class="flex items-center gap-4">
                <div class="bg-green-100 text-green-600 p-4 rounded-xl text-xl">
                    ✔
                </div>
                <div>
                    <h2 class="font-semibold text-lg text-gray-800">
                        Ikuti Langkah Berikut
                    </h2>
                    <p class="text-sm text-gray-500">
                        Pastikan data yang kamu kirim sudah benar agar proses validasi berjalan lancar.
                    </p>
                </div>
            </div>
        </div>

        <!-- GRID STEP -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- STEP 1 -->
            <div class="bg-white p-6 rounded-2xl shadow-md border">
                <div class="flex items-start gap-4">
                    <div class="bg-orange-100 text-orange-600 p-4 rounded-xl text-xl">
                        📦
                    </div>
                    <div>
                        <span class="text-sm font-bold text-green-700">Langkah 1</span>
                        <h3 class="font-semibold text-lg text-gray-800">
                            Pisahkan Sampah
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Pisahkan sampah organik dan anorganik agar mudah diproses.
                        </p>
                    </div>
                </div>
            </div>

            <!-- STEP 2 -->
            <div class="bg-white p-6 rounded-2xl shadow-md border">
                <div class="flex items-start gap-4">
                    <div class="bg-blue-100 text-blue-600 p-4 rounded-xl text-xl">
                        💧
                    </div>
                    <div>
                        <span class="text-sm font-bold text-green-700">Langkah 2</span>
                        <h3 class="font-semibold text-lg text-gray-800">
                            Pastikan Bersih & Kering
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Bersihkan sampah dari sisa makanan atau cairan sebelum disetor.
                        </p>
                    </div>
                </div>
            </div>

            <!-- STEP 3 -->
            <div class="bg-white p-6 rounded-2xl shadow-md border">
                <div class="flex items-start gap-4">
                    <div class="bg-purple-100 text-purple-600 p-4 rounded-xl text-xl">
                        ⚖️
                    </div>
                    <div>
                        <span class="text-sm font-bold text-green-700">Langkah 3</span>
                        <h3 class="font-semibold text-lg text-gray-800">
                            Timbang dengan Benar
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Pastikan berat sampah sesuai agar hasil penukaran akurat.
                        </p>
                    </div>
                </div>
            </div>

            <!-- STEP 4 -->
            <div class="bg-white p-6 rounded-2xl shadow-md border">
                <div class="flex items-start gap-4">
                    <div class="bg-green-100 text-green-600 p-4 rounded-xl text-xl">
                        📸
                    </div>
                    <div>
                        <span class="text-sm font-bold text-green-700">Langkah 4</span>
                        <h3 class="font-semibold text-lg text-gray-800">
                            Upload Foto Jelas
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Ambil foto yang terang dan jelas untuk mempermudah validasi.
                        </p>
                    </div>
                </div>
            </div>

            <!-- STEP 5 -->
            <div class="bg-white p-6 rounded-2xl shadow-md border md:col-span-2">
                <div class="flex items-start gap-4">
                    <div class="bg-yellow-100 text-yellow-600 p-4 rounded-xl text-xl">
                        📝
                    </div>
                    <div>
                        <span class="text-sm font-bold text-green-700">Langkah 5</span>
                        <h3 class="font-semibold text-lg text-gray-800">
                            Pilih Jenis Sampah
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Pilih kategori sampah yang sesuai dengan jenis yang kamu setor.
                        </p>
                    </div>
                </div>
            </div>

        </div>

        <!-- CATATAN -->
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-xl mt-8 shadow-sm">
            <h3 class="font-semibold text-gray-800 mb-1">
                ⚠️ Catatan Penting
            </h3>
            <p class="text-sm text-gray-600">
                Mengikuti panduan ini akan mempercepat proses validasi dan memastikan kamu mendapatkan poin dengan tepat.
            </p>
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