<!DOCTYPE html>
<html>
<head>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<style>
    #tpsMap { height: 300px; border-radius: 18px; z-index: 0; }
</style>
</head>

<body class="bg-gray-100">

<!-- NAVBAR -->
<div class="bg-green-700 text-white h-16 flex items-center justify-center relative">

    <!-- BACK -->
    <a href="/waste/select"
       class="absolute left-4 flex items-center justify-center w-10 h-10 rounded-full hover:bg-white/20 transition">
        <svg xmlns="http://www.w3.org/2000/svg"
             class="h-5 w-5"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 19l-7-7 7-7"/>
        </svg>
    </a>

    <h1 class="font-semibold text-lg tracking-wide">Waste Submission</h1>
</div>

<!-- CONTENT -->
<div class="flex justify-center mt-14 px-4">

<form id="form"
      action="/waste/preview"
      method="POST"
      enctype="multipart/form-data"
      class="bg-white p-12 rounded-3xl shadow-xl w-full max-w-3xl space-y-8">
@csrf

<input type="hidden" name="type" value="{{ $type }}">

<!-- TYPE -->
<div>
    <label class="label">Waste Type</label>
    <div class="mt-2 p-4 bg-gray-100 rounded-xl font-semibold">
        {{ $type == 'organic' ? 'Organic Waste' : 'Inorganic Waste' }}
    </div>
</div>

<!-- 🔥 NAME (TAMBAHKAN DI SINI) -->
<div>
    <label class="label">Nama *</label>
    <input type="text" name="name" required class="input" placeholder="Masukkan nama kamu">
</div>

<!-- CATEGORY -->
<div>
    <label class="label">Category *</label>
    <select name="category" required class="input">
        <option value="">Select category</option>
        <option>Food Waste</option>
        <option>Leaves</option>
        <option>Fruit Waste</option>
        <option>Plastic Bottle</option>
        <option>Plastic Bag</option>
    </select>
</div>

<!-- WEIGHT -->
<div>
    <label class="label">Weight (kg) *</label>
    <input id="weight" name="weight" type="number" step="0.1" required class="input">
</div>

<!-- TPS -->
<div>
    <label class="label">Waste Collection Point (TPS) *</label>
    <select id="tps" name="tps" required class="input" onchange="selectTPS(this.value); stepLocation(1)">
        <option value="">Select TPS</option>
        <option>TPS Kebon Jeruk</option>
        <option>TPS Palmerah</option>
        <option>TPS Grogol</option>
        <option>TPS Cengkareng</option>
        <option>TPS Kembangan</option>
        <option>TPS Slipi</option>
        <option>TPS Taman Sari</option>
        <option>TPS Kebayoran Baru</option>
        <option>TPS Cilandak</option>
        <option>TPS Menteng</option>
        <option>TPS Tanah Abang</option>
        <option>TPS Jatinegara</option>
        <option>TPS Duren Sawit</option>
        <option>TPS Penjaringan</option>
        <option>TPS Kelapa Gading</option>
    </select>
</div>

<!-- MAP PINPOINT -->
<div>
    <label class="label">Lokasi TPS di Peta</label>
    <div id="tpsMap" class="mt-2 border border-gray-200 shadow-sm"></div>
    <p class="text-xs text-gray-400 mt-2">📍 Pilih TPS di atas untuk melihat lokasinya di peta</p>
</div>

<!-- LOKASI AUTO-FILL -->
<div id="locationFields" class="hidden space-y-4">
    <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-2">
        <p class="text-xs font-semibold text-green-700 flex items-center gap-1">✅ Lokasi terisi otomatis dari TPS yang dipilih</p>
    </div>

    <!-- DESA -->
    <div>
        <label class="label">Village (Desa)</label>
        <input type="text" id="desaInput" name="desa" required readonly class="input bg-gray-50 cursor-default" placeholder="Otomatis terisi">
    </div>

    <!-- KECAMATAN -->
    <div>
        <label class="label">District (Kecamatan)</label>
        <input type="text" id="kecamatanInput" name="kecamatan" required readonly class="input bg-gray-50 cursor-default" placeholder="Otomatis terisi">
    </div>

    <!-- KOTA -->
    <div>
        <label class="label">City (Kota)</label>
        <input type="text" id="kotaInput" name="kota" required readonly class="input bg-gray-50 cursor-default" placeholder="Otomatis terisi">
    </div>
</div>

<!-- IMAGE -->
<div>
    <label class="label">Upload Image *</label>

    <label class="upload group">
        <input type="file" name="image" id="image" hidden required>

        <div id="uploadText" class="transition group-hover:scale-105">
            <p class="text-4xl mb-2">📷</p>
            <p class="text-gray-500">Click or drag image here</p>
        </div>

        <img id="preview" class="hidden rounded-xl max-h-52 mx-auto mt-3 shadow"/>
    </label>
</div>

<!-- ESTIMATED RESULT -->
<div id="resultBox"
     class="hidden bg-gradient-to-br from-green-700 to-green-900 text-white p-7 rounded-3xl shadow-xl">

    <h2 class="text-lg font-semibold mb-5 flex items-center gap-2">
        💧 Estimated Result
    </h2>

    <div class="bg-white/20 backdrop-blur-md p-6 rounded-2xl">

        <p class="text-sm opacity-80">Conversion Rate:</p>
        <p class="mb-4 text-lg">
            {{ $type == 'organic' ? '1 kg = 0.5 liter eco enzyme' : '1 kg = 0.8 liter fuel' }}
        </p>

        <hr class="opacity-30 mb-4">

        <h1 id="resultText" class="text-4xl font-bold">0.00 liters</h1>

        <p class="text-sm mt-1 opacity-90">
            {{ $type == 'organic' ? 'of eco enzyme' : 'of fuel' }}
        </p>
    </div>
</div>

<!-- BUTTON -->
<button id="btn"
    class="w-full py-4 rounded-2xl font-semibold text-lg bg-gray-300 text-white cursor-not-allowed transition">
    Preview Submission
</button>

</form>
</div>

<!-- STYLE -->
<style>
.label {
    display: block;
    margin-bottom: 6px;
    font-weight: 500;
    color: #374151;
}
.input {
    width: 100%;
    padding: 15px;
    border-radius: 14px;
    border: 1px solid #e5e7eb;
    margin-top: 4px;
}
.input:focus {
    outline: none;
    border-color: #16a34a;
    box-shadow: 0 0 0 2px rgba(22,163,74,0.2);
}
.upload {
    display: block;
    border: 2px dashed #d1d5db;
    padding: 40px;
    border-radius: 18px;
    text-align: center;
    cursor: pointer;
    transition: 0.3s;
}
.upload:hover {
    border-color: #16a34a;
    background: #f0fdf4;
}
</style>

<!-- SCRIPT -->
<script>
const weight = document.getElementById('weight');
const resultBox = document.getElementById('resultBox');
const resultText = document.getElementById('resultText');
const form = document.getElementById('form');
const btn = document.getElementById('btn');

// ── Leaflet Map with TPS Pinpoints ──
const tpsLocations = {
    'TPS Kebon Jeruk': {
        lat: -6.1886, lng: 106.7716,
        address: 'Jl. Kebon Jeruk Raya, Jakarta Barat',
        desa: 'Kelurahan Kebon Jeruk',
        kecamatan: 'Kecamatan Kebon Jeruk',
        kota: 'Jakarta Barat'
    },
    'TPS Palmerah': {
        lat: -6.2066, lng: 106.7972,
        address: 'Jl. Palmerah Utara, Jakarta Barat',
        desa: 'Kelurahan Palmerah',
        kecamatan: 'Kecamatan Palmerah',
        kota: 'Jakarta Barat'
    },
    'TPS Grogol': {
        lat: -6.1615, lng: 106.7860,
        address: 'Jl. Daan Mogot, Grogol, Jakarta Barat',
        desa: 'Kelurahan Grogol',
        kecamatan: 'Kecamatan Grogol Petamburan',
        text: 'Jakarta Barat',
        kota: 'Jakarta Barat'
    },
    'TPS Cengkareng': {
        lat: -6.1457, lng: 106.7295,
        address: 'Jl. Daan Mogot KM.14, Cengkareng, Jakarta Barat',
        desa: 'Kelurahan Cengkareng Timur',
        kecamatan: 'Kecamatan Cengkareng',
        kota: 'Jakarta Barat'
    },
    'TPS Kembangan': {
        lat: -6.1870, lng: 106.7490,
        address: 'Jl. Kembangan Raya, Kembangan, Jakarta Barat',
        desa: 'Kelurahan Kembangan Utara',
        kecamatan: 'Kecamatan Kembangan',
        kota: 'Jakarta Barat'
    },
    'TPS Slipi': {
        lat: -6.1920, lng: 106.7985,
        address: 'Jl. S. Parman, Slipi, Jakarta Barat',
        desa: 'Kelurahan Slipi',
        kecamatan: 'Kecamatan Palmerah',
        kota: 'Jakarta Barat'
    },
    'TPS Taman Sari': {
        lat: -6.1490, lng: 106.8125,
        address: 'Jl. Taman Sari Raya, Jakarta Barat',
        desa: 'Kelurahan Taman Sari',
        kecamatan: 'Kecamatan Taman Sari',
        kota: 'Jakarta Barat'
    },
    'TPS Kebayoran Baru': {
        lat: -6.2443, lng: 106.7973,
        address: 'Jl. Selong, Kebayoran Baru, Jakarta Selatan',
        desa: 'Kelurahan Selong',
        kecamatan: 'Kecamatan Kebayoran Baru',
        kota: 'Jakarta Selatan'
    },
    'TPS Cilandak': {
        lat: -6.2901, lng: 106.7972,
        address: 'Jl. Cilandak Raya, Jakarta Selatan',
        desa: 'Kelurahan Cilandak Barat',
        kecamatan: 'Kecamatan Cilandak',
        kota: 'Jakarta Selatan'
    },
    'TPS Menteng': {
        lat: -6.2014, lng: 106.8322,
        address: 'Jl. Menteng Raya, Jakarta Pusat',
        desa: 'Kelurahan Menteng',
        kecamatan: 'Kecamatan Menteng',
        kota: 'Jakarta Pusat'
    },
    'TPS Tanah Abang': {
        lat: -6.2120, lng: 106.8180,
        address: 'Jl. KH. Mas Mansyur, Tanah Abang, Jakarta Pusat',
        desa: 'Kelurahan Karet Tengsin',
        kecamatan: 'Kecamatan Tanah Abang',
        kota: 'Jakarta Pusat'
    },
    'TPS Jatinegara': {
        lat: -6.2250, lng: 106.8790,
        address: 'Jl. Jatinegara Timur, Jakarta Timur',
        desa: 'Kelurahan Bali Mester',
        kecamatan: 'Kecamatan Jatinegara',
        kota: 'Jakarta Timur'
    },
    'TPS Duren Sawit': {
        lat: -6.2230, lng: 106.9010,
        address: 'Jl. Duren Sawit Raya, Jakarta Timur',
        desa: 'Kelurahan Duren Sawit',
        kecamatan: 'Kecamatan Duren Sawit',
        kota: 'Jakarta Timur'
    },
    'TPS Penjaringan': {
        lat: -6.1274, lng: 106.7915,
        address: 'Jl. Pluit Raya, Penjaringan, Jakarta Utara',
        desa: 'Kelurahan Penjaringan',
        kecamatan: 'Kecamatan Penjaringan',
        kota: 'Jakarta Utara'
    },
    'TPS Kelapa Gading': {
        lat: -6.1550, lng: 106.9020,
        address: 'Jl. Boulevard Raya, Kelapa Gading, Jakarta Utara',
        desa: 'Kelurahan Kelapa Gading Timur',
        kecamatan: 'Kecamatan Kelapa Gading',
        kota: 'Jakarta Utara'
    }
};

const map = L.map('tpsMap').setView([-6.1750, 106.7750], 12);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors',
    maxZoom: 19
}).addTo(map);

const markers = {};
const greenIcon = L.icon({
    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
    iconSize: [25, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34],
    shadowSize: [41, 41]
});

for (const [name, loc] of Object.entries(tpsLocations)) {
    const marker = L.marker([loc.lat, loc.lng], { icon: greenIcon })
        .addTo(map)
        .bindPopup(`<strong>${name}</strong><br><span style="font-size:12px;color:#666">${loc.address}</span>`);

    // Klik marker di peta juga auto-fill
    marker.on('click', function() {
        document.getElementById('tps').value = name;
        fillLocation(name);
    });

    markers[name] = marker;
}

function fillLocation(tpsName) {
    const loc = tpsLocations[tpsName];
    if (!loc) return;

    // Show location fields & fill
    document.getElementById('locationFields').classList.remove('hidden');
    document.getElementById('desaInput').value = loc.desa;
    document.getElementById('kecamatanInput').value = loc.kecamatan;
    document.getElementById('kotaInput').value = loc.kota;

    // Trigger form validation check
    form.dispatchEvent(new Event('input'));
}

function selectTPS(tpsName) {
    if (tpsLocations[tpsName]) {
        const loc = tpsLocations[tpsName];
        map.flyTo([loc.lat, loc.lng], 16, { duration: 1 });
        markers[tpsName].openPopup();
        fillLocation(tpsName);
    }
}

function stepLocation(step) {
    // No longer needed for progressive reveal, kept for compatibility
}

weight.addEventListener('input', () => {
    let val = parseFloat(weight.value);
    if(!val) return;

    let result = {{ $type == 'organic' ? 'val * 0.5' : 'val * 0.8' }};
    resultBox.classList.remove('hidden');
    resultText.innerText = result.toFixed(2) + ' liters';
});

form.addEventListener('input', () => {
    if(form.checkValidity()){
        btn.classList.remove('bg-gray-300','cursor-not-allowed');
        btn.classList.add('bg-green-600','hover:bg-green-700');
    } else {
        btn.classList.add('bg-gray-300','cursor-not-allowed');
    }
});

document.getElementById('image').addEventListener('change', function(){
    const file = this.files[0];
    if(file){
        const preview = document.getElementById('preview');
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('hidden');
        document.getElementById('uploadText').classList.add('hidden');
    }
});
</script>

</body>
</html>