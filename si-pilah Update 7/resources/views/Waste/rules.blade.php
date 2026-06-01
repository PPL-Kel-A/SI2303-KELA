<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Aturan & Ketentuan</title>
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
        <h1 class="text-xl font-semibold">Aturan & Ketentuan</h1>
        <p class="text-sm opacity-90">Kebijakan penting untuk penyetoran sampah</p>
    </div>
</div>

<!-- CONTENT -->
<div class="flex justify-center mt-10 px-6">
    <div class="w-full max-w-xl space-y-6">

        <!-- ALERT -->
        <div class="bg-gradient-to-r from-red-500 to-orange-500 text-white p-5 rounded-2xl shadow-md">
            <h2 class="font-semibold mb-1">Harap Dibaca</h2>
            <p class="text-sm opacity-90">
                Pelanggaran aturan dapat menyebabkan penolakan data atau penangguhan akun.
                Pastikan membaca seluruh ketentuan sebelum menyetor sampah.
            </p>
        </div>

        <!-- RULE LIST -->
        <div class="space-y-4">

            <!-- RULE 1 -->
            <div class="bg-white p-5 rounded-2xl shadow-md border">
                <h3 class="font-semibold">Sampah harus sesuai kategori</h3>
                <p class="text-sm text-gray-500 mt-1">
                    Pastikan sampah yang disetor sesuai dengan kategori yang dipilih.
                    Data yang tidak sesuai akan ditolak.
                </p>
            </div>

            <!-- RULE 2 -->
            <div class="bg-white p-5 rounded-2xl shadow-md border">
                <h3 class="font-semibold">Data tidak valid akan ditolak</h3>
                <p class="text-sm text-gray-500 mt-1">
                    Informasi yang tidak akurat (berat, jenis, foto) dapat menyebabkan penolakan tanpa poin.
                </p>
            </div>

            <!-- RULE 3 -->
            <div class="bg-white p-5 rounded-2xl shadow-md border">
                <h3 class="font-semibold">Poin hanya untuk data valid</h3>
                <p class="text-sm text-gray-500 mt-1">
                    Poin akan diberikan setelah admin melakukan validasi dan memastikan data benar.
                </p>
            </div>

            <!-- RULE 4 -->
            <div class="bg-white p-5 rounded-2xl shadow-md border">
                <h3 class="font-semibold">Data tidak dapat diubah</h3>
                <p class="text-sm text-gray-500 mt-1">
                    Setelah proses dimulai, data tidak dapat diubah. Pastikan semua informasi sudah benar.
                </p>
            </div>

            <!-- RULE 5 -->
            <div class="bg-white p-5 rounded-2xl shadow-md border">
                <h3 class="font-semibold">Wajib mengikuti kebijakan lingkungan</h3>
                <p class="text-sm text-gray-500 mt-1">
                    Semua penyetoran harus mengikuti aturan pengelolaan sampah yang berlaku.
                </p>
            </div>

        </div>

        <!-- INFO TAMBAHAN -->
        <div class="bg-white p-5 rounded-2xl shadow-md border">
            <h3 class="font-semibold mb-2">Informasi Tambahan</h3>
            <ul class="text-sm text-gray-600 space-y-1">
                <li>• Waktu validasi: 2–5 hari kerja</li>
                <li>• Pengajuan ulang dapat dilakukan jika ditolak</li>
                <li>• Pelanggaran berulang dapat menyebabkan akun dibatasi</li>
                <li>• Hubungi admin jika terjadi kendala</li>
            </ul>
        </div>

        <!-- KOMITMEN USER -->
        <div class="bg-green-800 text-white p-5 rounded-2xl shadow-md">
            <h3 class="font-semibold mb-2">Komitmen Pengguna</h3>
            <ul class="text-sm space-y-1">
                <li>✓ Memberikan data yang jujur dan akurat</li>
                <li>✓ Mengikuti aturan pengelolaan sampah</li>
                <li>✓ Menghormati proses validasi admin</li>
                <li>✓ Berkontribusi menjaga lingkungan</li>
            </ul>
        </div>

        <!-- SANKSI -->
        <div class="bg-white p-5 rounded-2xl shadow-md border">
            <h3 class="font-semibold mb-1">Konsekuensi Pelanggaran</h3>
            <p class="text-sm text-gray-600">
                Pelanggaran pertama: peringatan <br>
                Pelanggaran kedua: penangguhan sementara <br>
                Pelanggaran berat: pemblokiran akun permanen
            </p>
        </div>

        <!-- BUTTON -->
        <a href="/" 
           class="block text-center bg-green-700 text-white py-3 rounded-xl font-semibold hover:bg-green-800 transition">
            Kembali ke Beranda
        </a>

    </div>
</div>

</body>
</html>