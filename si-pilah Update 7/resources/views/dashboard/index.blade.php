<!-- <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Si-Pilah</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

    <nav class="bg-green-600 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">♻️ Si-Pilah Admin</h1>
            <span class="text-sm">Sprint 1 - Dashboard</span>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold mb-6 text-gray-700">Overview Sistem Pengelolaan Sampah</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-green-500">
                <h3 class="text-gray-500 text-sm font-semibold mb-1">Total Sampah Terkumpul</h3>
                <p class="text-3xl font-bold text-gray-800">{{ number_format($data['total_sampah'], 2) }} <span class="text-lg text-gray-500">Kg</span></p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-yellow-500">
                <h3 class="text-gray-500 text-sm font-semibold mb-1">Sedang Diproses</h3>
                <p class="text-3xl font-bold text-gray-800">{{ number_format($data['sampah_diproses'], 2) }} <span class="text-lg text-gray-500">Kg</span></p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-blue-500">
                <h3 class="text-gray-500 text-sm font-semibold mb-1">Energi Surya Dihasilkan</h3>
                <p class="text-3xl font-bold text-gray-800">{{ number_format($data['energi_surya_kwh'], 2) }} <span class="text-lg text-gray-500">kWh</span></p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-purple-500">
                <h3 class="text-gray-500 text-sm font-semibold mb-1">Poin Reward Tersalurkan</h3>
                <p class="text-3xl font-bold text-gray-800">{{ number_format($data['poin_reward']) }} <span class="text-lg text-gray-500">Pts</span></p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
            <h3 class="text-lg font-semibold mb-4 text-gray-700">Status Sistem</h3>
            <p class="text-gray-600">
                Data di atas diambil secara langsung (*real-time*) dari *database*. Untuk melihat perubahan angka, Anda bisa menambahkan data percobaan (*dummy data*) ke dalam tabel <code>wastes</code> dan <code>rewards</code> melalui *database manager* (seperti phpMyAdmin atau DBeaver).
            </p>
        </div>
    </div>

</body>
</html> -->