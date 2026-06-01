<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submission Success</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

@php
    // Ambil data dari object $submission (jika akses via dashboard) atau session
    $type = $submission->type ?? session('type', 'organic');
    $name = $submission->name ?? session('name', '-');
    $weight = $submission->weight ?? session('weight', 0);
    $category = $submission->category ?? session('category', '-');
    $tps = $submission->tps ?? session('tps', '-');
    $desa = $submission->desa ?? session('desa', '-');
    $kecamatan = $submission->kecamatan ?? session('kecamatan', '-');
    $kota = $submission->kota ?? session('kota', '-');
    $result = $submission->result ?? session('result', 0);
    $waste_id = $submission->id ?? session('waste_id', null);
    $status = $submission->status ?? session('status', 'Pending');

    // LOGIKA PENGECEKAN KLAIM (Tanpa kolom database tambahan)
    $is_claimed = false;
    $points_earned = 0;
    
    if ($waste_id) {
        $rewardRecord = \App\Models\Reward::where('user_id', auth()->id())
                        ->where('description', 'like', '%[ID: ' . $waste_id . ']%')
                        ->first();
        
        if ($rewardRecord) {
            $is_claimed = true;
            $points_earned = $rewardRecord->points;
        }
    }
@endphp

<body class="bg-gray-100 min-h-screen flex items-center justify-center relative">

<div class="w-full max-w-xl px-4 z-10">

    <div class="flex justify-center mb-6">
        <div class="w-20 h-20 bg-green-600 rounded-full flex items-center justify-center text-white text-3xl shadow-lg">
            ✓
        </div>
    </div>

    <h1 class="text-3xl font-bold text-center text-gray-800 mb-2">
        Submission Successful!
    </h1>

    <p class="text-center text-gray-500 mb-8">
        Your waste has been successfully submitted
    </p>

    <div class="bg-gradient-to-r from-green-500 to-green-700 text-white p-6 rounded-2xl shadow-lg mb-6">
        <p class="text-sm opacity-90">Estimated Processed Result</p>
        <h2 class="text-4xl font-bold">
            {{ number_format($result, 2) }} <span class="text-lg">liters</span>
        </h2>
        <p class="text-sm opacity-90 mt-1">
            {{ $type == 'organic' ? 'Eco Enzyme' : 'Fuel (solar)' }}
        </p>
    </div>

    @if(strtolower($status) == 'selesai')
        <div class="bg-green-50 border border-green-200 p-5 rounded-xl mb-4">
            <p class="font-semibold text-green-700">Status: Selesai</p>
            <p class="text-sm text-green-600">Your submission has been verified and fully processed</p>
        </div>
    @else
        <div class="bg-yellow-50 border border-yellow-200 p-5 rounded-xl mb-4">
            <p class="font-semibold text-yellow-700">Status: Pending</p>
            <p class="text-sm text-yellow-600">Your submission is being reviewed and processed</p>
        </div>
    @endif

    <div id="point-claim-container">
        @if(strtolower($status) == 'selesai')
            @if(!$is_claimed)
                <button id="btn-claim-point" data-id="{{ $waste_id }}" data-result="{{ $result }}"
                        class="w-full bg-blue-50 hover:bg-blue-100 border border-blue-200 p-4 rounded-xl mb-6 text-center text-sm text-blue-600 font-bold transition duration-200 block shadow-sm cursor-pointer hover:scale-[1.01]">
                    🎁 Klik untuk Klaim Poin
                </button>
            @else
                <div class="bg-green-100 border border-green-300 p-4 rounded-xl mb-6 text-center text-sm text-green-700 font-bold">
                    🎉 Anda telah mengklaim {{ $points_earned }} Poin!
                </div>
            @endif
        @else
            <div class="bg-blue-50 border border-blue-200 p-4 rounded-xl mb-6 text-center text-sm text-blue-600">
                🎁 You will earn points after validation
            </div>
        @endif
    </div>

    <div class="bg-white p-6 rounded-2xl shadow mb-6">
        <h3 class="font-bold text-gray-700 mb-4">Submission Details</h3>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div><p class="text-gray-400">Name</p><p class="font-semibold">{{ $name }}</p></div>
            <div><p class="text-gray-400">Category</p><p class="font-semibold">{{ $category }}</p></div>
            <div><p class="text-gray-400">Waste Type</p><p class="font-semibold">{{ $type == 'organic' ? 'Organic Waste' : 'Inorganic Waste' }}</p></div>
            <div><p class="text-gray-400">Weight</p><p class="font-semibold">{{ $weight }} kg</p></div>
            <div class="col-span-2"><p class="text-gray-400">Location</p><p class="font-semibold">{{ $tps }} - {{ $desa }}, {{ $kecamatan }}, {{ $kota }}</p></div>
        </div>
    </div>

    <a href="/dashboard" class="block w-full bg-green-600 hover:bg-green-700 text-white text-center py-4 rounded-2xl font-bold shadow transition">
        Back to Dashboard
    </a>
</div>

<script>
document.getElementById('btn-claim-point')?.addEventListener('click', function() {
    const btn = this;
    const wasteId = btn.getAttribute('data-id');
    
    btn.innerText = 'Memproses...';
    btn.disabled = true;

    fetch(`/waste/claim-point/${wasteId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('point-claim-container').innerHTML = `
                <div class="bg-green-100 border border-green-300 p-4 rounded-xl mb-6 text-center text-sm text-green-700 font-bold">
                    🎉 ${data.message}
                </div>
            `;
        } else {
            alert(data.message || 'Gagal mengklaim poin.');
            btn.innerText = '🎁 Klik untuk Klaim Poin';
            btn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kendala saat memproses klaim poin.');
        btn.innerText = '🎁 Klik untuk Klaim Poin';
        btn.disabled = false;
    });
});
</script>
</body>
</html>