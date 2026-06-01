<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Select Waste Type</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: "";
            position: absolute;
            width: 300px;
            height: 300px;
            background: #d1d5db;
            border-radius: 50%;
            filter: blur(120px);
            top: 60px;
            left: 60px;
        }

        body::after {
            content: "";
            position: absolute;
            width: 300px;
            height: 300px;
            background: #c7d2fe;
            border-radius: 50%;
            filter: blur(120px);
            bottom: 60px;
            right: 60px;
        }

        .main-content {
            position: relative;
            z-index: 10;
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<div class="bg-green-700 text-white h-16 flex items-center justify-center relative">

    <a href="/" 
       class="absolute left-4 flex items-center justify-center w-10 h-10 rounded-full transition hover:bg-white/20 active:scale-95">
        <svg xmlns="http://www.w3.org/2000/svg" 
             class="h-5 w-5" 
             fill="none" 
             viewBox="0 0 24 24" 
             stroke="currentColor" 
             stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" 
                  d="M15 19l-7-7 7-7" />
        </svg>
    </a>

    <h1 class="text-lg font-semibold tracking-wide">
        Waste Submission
    </h1>

</div>

<!-- CONTENT -->
<div class="main-content flex justify-center mt-16">
    <div class="w-full max-w-lg space-y-10 text-center">

        <div>
            <h2 class="text-2xl font-semibold text-gray-800">
                Select Your Waste Category
            </h2>
            <p class="text-gray-500 mt-2 text-sm">
                Choose the type of waste to continue the submission process
            </p>
        </div>

        <!-- CARD -->
        <div class="space-y-6 text-left">

            <!-- ORGANIC -->
            <div onclick="selectCard(this, 'organic')" 
                class="card bg-white p-6 rounded-2xl shadow-md cursor-pointer transition border-2 border-transparent hover:shadow-lg">
                <div class="flex items-center space-x-5">
                    <div class="bg-gray-200 p-4 rounded-xl text-2xl">
                        🌿
                    </div>
                    <div>
                        <h2 class="font-bold text-lg">Organic Waste</h2>
                        <p class="text-gray-500">Processed into eco enzyme</p>
                        <p class="text-gray-600 text-sm mt-1">1 kg = 0.5 liter eco enzyme</p>
                    </div>
                </div>
            </div>

            <!-- INORGANIC -->
            <div onclick="selectCard(this, 'inorganic')" 
                class="card bg-white p-6 rounded-2xl shadow-md cursor-pointer transition border-2 border-transparent hover:shadow-lg">
                <div class="flex items-center space-x-5">
                    <div class="bg-gray-200 p-4 rounded-xl text-2xl">
                        ♻️
                    </div>
                    <div>
                        <h2 class="font-bold text-lg">Inorganic Waste (Plastic)</h2>
                        <p class="text-gray-500">Processed into fuel (solar)</p>
                        <p class="text-gray-600 text-sm mt-1">1 kg = 0.8 liter fuel</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- BUTTON -->
        <button id="continueBtn" onclick="goToForm()"
            class="w-full bg-gray-300 text-white py-4 rounded-xl font-bold text-lg cursor-not-allowed transition">
            Continue
        </button>

    </div>
</div>

<!-- SCRIPT -->
<script>
    let selectedType = null;

    function selectCard(selected, type) {
        let cards = document.querySelectorAll('.card');
        let button = document.getElementById('continueBtn');

        cards.forEach(card => {
            card.classList.remove('border-green-600', 'bg-green-50');
        });

        selected.classList.add('border-green-600', 'bg-green-50');

        selectedType = type;

        button.classList.remove('bg-gray-300', 'cursor-not-allowed');
        button.classList.add('bg-green-600', 'hover:bg-green-700');
    }

    function goToForm() {
        if (selectedType) {
            window.location.href = "/waste/form?type=" + selectedType;
        }
    }
</script>

</body>
</html>