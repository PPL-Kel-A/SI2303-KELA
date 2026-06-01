<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Waste Processing</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">

<!-- HEADER -->
<div class="bg-green-700 text-white py-5 px-6 relative shadow-md">

    <a href="{{ url()->previous() }}" 
       class="absolute left-6 top-1/2 -translate-y-1/2 bg-white/20 px-4 py-2 rounded-full text-sm hover:bg-white/30 transition">
        Kembali
    </a>

    <div class="text-center">
        <h1 class="text-xl font-semibold">Proses Pengolahan Sampah</h1>
        <p class="text-sm opacity-90">Proses sampah organik vs anorganik</p>
    </div>
</div>

<!-- CONTENT -->
<div class="flex justify-center mt-12 px-6">
    <div class="w-full max-w-xl space-y-8">

        <!-- ORGANIC -->
        <div class="bg-white rounded-2xl shadow-md p-6">

            <div class="flex items-center gap-3 mb-4">
                <div class="bg-green-100 text-green-600 p-3 rounded-xl">🌿</div>
                <div>
                    <h2 class="font-semibold text-lg">Sampah Organik</h2>
                    <p class="text-sm text-gray-500">Penguraian alami</p>
                </div>
            </div>

            <!-- FLOW -->
            <div class="flex justify-between items-center mb-6">
                <div class="text-center">
                    <div class="bg-gray-100 p-4 rounded-xl">🗑️</div>
                    <p class="text-xs mt-1">Sampah</p>
                </div>

                <span>→</span>

                <div class="text-center">
                    <div class="bg-purple-100 p-4 rounded-xl">🧪</div>
                    <p class="text-xs mt-1">Fermentasi</p>
                </div>

                <span>→</span>

                <div class="text-center">
                    <div class="bg-green-100 p-4 rounded-xl">💧</div>
                    <p class="text-xs mt-1">Eco Enzyme</p>
                </div>
            </div>

            <!-- DESC -->
            <div class="bg-green-50 border border-green-200 p-4 rounded-xl text-sm">
                Sampah organik mengalami proses fermentasi selama 3–6 bulan dan menghasilkan eco enzyme.
                <div class="mt-2 text-xs text-green-700">
                    Konversi: 1 kg → 0.5 liter
                </div>
            </div>

        </div>

        <!-- INORGANIC -->
        <div class="bg-white rounded-2xl shadow-md p-6">

            <div class="flex items-center gap-3 mb-4">
                <div class="bg-blue-100 text-blue-600 p-3 rounded-xl">♻️</div>
                <div>
                    <h2 class="font-semibold text-lg">Sampah Anorganik (Plastik)</h2>
                    <p class="text-sm text-gray-500">Daur ulang lanjutan</p>
                </div>
            </div>

            <!-- FLOW GRID -->
            <div class="grid grid-cols-3 gap-4 mb-6 text-center">

                <div>
                    <div class="bg-orange-100 p-6 rounded-xl">🗑️</div>
                    <p class="text-xs mt-1">Sampah</p>
                </div>

                <div>
                    <div class="bg-purple-100 p-6 rounded-xl">📦</div>
                    <p class="text-xs mt-1">Penyortiran</p>
                </div>

                <div>
                    <div class="bg-yellow-100 p-6 rounded-xl">⚙️</div>
                    <p class="text-xs mt-1">Pengolahan</p>
                </div>

                <div class="col-span-3 flex justify-center">
                    <span class="mx-2">↓</span>
                </div>

                <div class="col-span-3 flex justify-center">
                    <div class="bg-blue-100 p-6 rounded-xl w-32">
                        ⛽
                        <p class="text-xs mt-1">Fuel</p>
                    </div>
                </div>

            </div>

            <!-- DESC -->
            <div class="bg-blue-50 border border-blue-200 p-4 rounded-xl text-sm">
                Sampah plastik disortir, dibersihkan, lalu diolah menjadi bahan bakar menggunakan metode pirolisis.
                <div class="mt-2 text-xs text-blue-700">
                    Konversi: 1 kg → 0.8 liter
                </div>
            </div>

        </div>

        <!-- KEY DIFFERENCES -->
        <div class="bg-green-800 text-white p-6 rounded-2xl shadow-md">
            <h3 class="font-semibold mb-2">Perbedaan Utama</h3>
            <ul class="text-sm space-y-1">
                <li>• Organik: proses fermentasi alami</li>
                <li>• Anorganik: menggunakan teknologi daur ulang</li>
                <li>• Keduanya mendukung kelestarian lingkungan</li>
            </ul>
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