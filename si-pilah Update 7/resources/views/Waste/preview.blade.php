<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submission Preview</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 pb-16">

<!-- NAVBAR -->
<div class="bg-green-700 text-white h-16 flex items-center justify-center relative shadow-md">

    <a href="/waste/form?type={{ $data['type'] ?? '' }}"
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

    <h1 class="font-semibold text-lg tracking-wide">Submission Preview</h1>
</div>

<!-- CONTENT -->
<div class="flex justify-center mt-12 px-4">
    <div class="w-full max-w-3xl space-y-10">

        <!-- SUMMARY -->
        <div class="bg-white p-12 rounded-3xl shadow-lg space-y-8">

            <h2 class="text-2xl font-bold text-gray-800">Submission Summary</h2>

            <!-- NAME -->
            <div>
                <p class="text-gray-400 text-xs uppercase mb-1">Name</p>
                <p class="font-bold text-gray-800 text-lg">
                    {{ $data['name'] ?? '-' }}
                </p>
            </div>

            <hr>

            <div>
                <p class="text-gray-400 text-xs uppercase mb-2">Waste Type</p>
                <span class="bg-green-100 text-green-700 px-5 py-2 rounded-full text-sm font-bold">
                    {{ ($data['type'] ?? '') == 'organic' ? 'Organic Waste' : 'Inorganic Waste' }}
                </span>
            </div>

            <hr>

            <div>
                <p class="text-gray-400 text-xs uppercase mb-1">Category</p>
                <p class="font-bold text-gray-800 text-lg">
                    {{ $data['category'] ?? '-' }}
                </p>
            </div>

            <hr>

            <div>
                <p class="text-gray-400 text-xs uppercase mb-1">Weight</p>
                <p class="font-bold text-gray-800 text-xl">
                    {{ $data['weight'] ?? 0 }} kg
                </p>
            </div>

            <hr>

            <div>
                <p class="text-gray-400 text-xs uppercase mb-1">TPS Location</p>
                <p class="font-bold text-gray-800">
                    {{ $data['tps'] ?? '-' }}
                </p>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $data['desa'] ?? '-' }}, {{ $data['kecamatan'] ?? '-' }}, {{ $data['kota'] ?? '-' }}
                </p>
            </div>

            <hr>

            <div>
                <p class="text-gray-400 text-xs uppercase mb-3">Uploaded Image</p>
                <img src="{{ asset('storage/'.$image) }}"
                     class="w-full rounded-2xl shadow object-cover max-h-72">
            </div>

        </div>

        <!-- PROCESS FLOW -->
        <div class="bg-white p-12 rounded-3xl shadow-lg">
            <h2 class="text-xl font-bold text-gray-800 text-center mb-10">
                Waste Processing Flow
            </h2>

            <div class="relative flex items-center justify-between">
                <div class="absolute top-7 left-0 w-full h-[3px] bg-gray-200 z-0"></div>

                <div class="z-10 flex flex-col items-center w-1/3 text-center">
                    <div class="bg-orange-100 text-orange-600 w-16 h-16 rounded-full flex items-center justify-center text-2xl shadow-md">📦</div>
                    <p class="mt-4 font-bold text-lg text-gray-800">
                        {{ $data['weight'] ?? 0 }} kg
                    </p>
                    <p class="text-xs text-gray-500">Waste Input</p>
                </div>

                <div class="z-10 flex flex-col items-center w-1/3 text-center">
                    <div class="bg-blue-100 text-blue-600 w-16 h-16 rounded-full flex items-center justify-center text-2xl shadow-md">⚙️</div>
                    <p class="mt-4 font-bold text-gray-800">Processing</p>
                    <p class="text-xs text-gray-500">
                        {{ ($data['type'] ?? '') == 'organic' ? 'Eco Enzyme' : 'Fuel Conversion' }}
                    </p>
                </div>

                <div class="z-10 flex flex-col items-center w-1/3 text-center">
                    <div class="bg-green-100 text-green-600 w-16 h-16 rounded-full flex items-center justify-center text-2xl shadow-md">💧</div>
                    <p class="mt-4 font-bold text-lg text-gray-800">
                        {{ number_format($result ?? 0,2) }} L
                    </p>
                    <p class="text-xs text-gray-500">Final Output</p>
                </div>
            </div>

            <div class="mt-12 bg-gray-50 p-6 rounded-2xl text-center">
                <p class="text-sm text-gray-500 mb-2">Conversion Formula</p>
                <p class="text-lg font-semibold text-gray-800">
                    {{ ($data['type'] ?? '') == 'organic'
                        ? '1 kg = 0.5 liter eco enzyme'
                        : '1 kg = 0.8 liter fuel' }}
                </p>
                <p class="mt-3 text-gray-600">
                    {{ $data['weight'] ?? 0 }} ×
                    {{ ($data['type'] ?? '') == 'organic' ? '0.5' : '0.8' }}
                    =
                    <span class="font-bold text-green-700">
                        {{ number_format($result ?? 0,2) }} liters
                    </span>
                </p>
            </div>
        </div>

        <!-- RESULT -->
        <div class="bg-gradient-to-br from-green-700 to-green-900 text-white p-12 rounded-3xl shadow-xl text-center">
            <p class="uppercase text-sm opacity-80 mb-2">Calculated Result</p>
            <h1 class="text-5xl font-extrabold mb-2">
                {{ number_format($result ?? 0,2) }} L
            </h1>
        </div>

        <!-- BUTTON -->
        <div class="space-y-3">

            <form action="/waste/store" method="POST">
                @csrf

                <input type="hidden" name="name" value="{{ $data['name'] ?? '' }}">
                <input type="hidden" name="type" value="{{ $data['type'] ?? '' }}">
                <input type="hidden" name="category" value="{{ $data['category'] ?? '' }}">
                <input type="hidden" name="weight" value="{{ $data['weight'] ?? '' }}">
                <input type="hidden" name="tps" value="{{ $data['tps'] ?? '' }}">
                <input type="hidden" name="desa" value="{{ $data['desa'] ?? '' }}">
                <input type="hidden" name="kecamatan" value="{{ $data['kecamatan'] ?? '' }}">
                <input type="hidden" name="kota" value="{{ $data['kota'] ?? '' }}">
                <input type="hidden" name="image" value="{{ $image }}">
                <input type="hidden" name="result" value="{{ $result ?? 0 }}">

                <button class="w-full bg-green-700 hover:bg-green-800 text-white py-4 rounded-2xl font-bold text-lg">
                    Confirm Submit
                </button>
            </form>

            <a href="/waste/form?type={{ $data['type'] ?? '' }}"
               class="block text-center border-2 border-green-700 text-green-700 py-4 rounded-2xl font-bold hover:bg-green-50 transition">
               Edit Submission
            </a>

        </div>

    </div>
</div>

</body>
</html>