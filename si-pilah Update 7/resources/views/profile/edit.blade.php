<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pengaturan Profil — {{ config('app.name', 'Si-Pilah') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Leaflet Map Integration -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="antialiased" style="background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 40%, #f0f9e8 100%); min-height: 100vh;">

    {{-- ── Back Button ── --}}
    <div class="w-full px-4 sm:px-6 lg:px-8 pt-6">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-green-700 hover:text-green-900 transition group">
            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>

    {{-- ── Hero Banner ── --}}
    <div class="w-full px-4 sm:px-6 lg:px-8 mt-4 mb-8">
        <div class="relative overflow-hidden rounded-2xl shadow-lg" style="background: linear-gradient(135deg, #0d3b0e 0%, #1b5e20 40%, #2e7d32 70%, #388e3c 100%);">
            <div class="absolute inset-0 opacity-[.06]" style="background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60' viewBox='0 0 60 60'%3E%3Cpath d='M30 2C30 2 15 15 15 30C15 42 22 50 30 58C38 50 45 42 45 30C45 15 30 2 30 2Z' fill='%23ffffff'/%3E%3C/svg%3E&quot;); background-size: 60px 60px;"></div>
            <div class="absolute inset-0" style="background: radial-gradient(ellipse 500px 400px at 80% 50%, rgba(76,175,80,.2) 0%, transparent 70%);"></div>

            <div class="relative px-8 py-10 flex flex-col sm:flex-row items-start sm:items-center gap-6">
                <div class="flex-shrink-0">
                    @if(auth()->user()->profile_photo)
                        <img src="{{ asset('profile-photos/' . auth()->user()->profile_photo) }}"
                             alt="Profile Photo"
                             class="w-20 h-20 rounded-2xl object-cover shadow-inner"
                             style="border: 3px solid rgba(255,255,255,.3);">
                    @else
                        <div class="w-20 h-20 rounded-2xl flex items-center justify-center text-3xl font-extrabold text-green-800 shadow-inner" style="background: linear-gradient(135deg, #a5d6a7, #c8e6c9); border: 3px solid rgba(255,255,255,.3);">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif
                </div>

                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl font-bold text-white truncate">
                        {{ auth()->user()->name }}
                    </h1>
                    <p class="text-green-200 text-sm mt-1 flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        {{ auth()->user()->email }}
                    </p>
                    <div class="mt-3 inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold" style="background: rgba(255,255,255,.15); color: #a5d6a7; backdrop-filter: blur(8px);">
                        🌱 Eco Warrior — Mari jaga bumi bersama Si-Pilah
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Form Cards ── --}}
    <div class="w-full px-4 sm:px-6 lg:px-8 pb-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Profile Photo Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-green-100/80 overflow-hidden hover:shadow-md transition-shadow duration-300">
                <div class="px-6 py-4 border-b border-green-50 flex items-center gap-3" style="background: linear-gradient(90deg, #f0fdf4, #ffffff);">
                    <span class="flex items-center justify-center w-9 h-9 rounded-xl bg-green-100 text-green-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </span>
                    <div>
                        <h3 class="text-base font-bold text-gray-800">Foto Profil</h3>
                        <p class="text-xs text-gray-500">Upload foto profil Anda (maks. 2MB, format: JPG, PNG, WEBP)</p>
                    </div>
                </div>
                <div class="px-6 py-6">
                    <div class="flex items-center gap-6 mb-6">
                        <div class="flex-shrink-0">
                            @if(auth()->user()->profile_photo)
                                <img src="{{ asset('profile-photos/' . auth()->user()->profile_photo) }}"
                                     alt="Foto Profil"
                                     id="photoPreview"
                                     class="w-24 h-24 rounded-2xl object-cover border-2 border-green-200 shadow-sm">
                            @else
                                <div id="photoPreview" class="w-24 h-24 rounded-2xl bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center text-4xl font-extrabold text-green-700 border-2 border-green-200 shadow-sm">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-700">
                                @if(auth()->user()->profile_photo)
                                    Foto profil saat ini
                                @else
                                    Belum ada foto profil
                                @endif
                            </p>
                            <p class="text-xs text-gray-400 mt-1">Disarankan ukuran 200×200 piksel</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('profile.photo.update') }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label for="profile_photo" class="block text-sm font-medium text-gray-700 mb-2">Pilih Foto Baru</label>
                            <input type="file"
                                   id="profile_photo"
                                   name="profile_photo"
                                   accept="image/jpeg,image/png,image/webp"
                                   onchange="previewPhoto(this)"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 file:cursor-pointer file:transition cursor-pointer border border-gray-200 rounded-xl">
                            <p class="text-xs text-gray-400 mt-1.5">Maks. 2MB · Format: JPG, JPEG, PNG, WEBP</p>
                            @error('profile_photo')
                                <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-3 pt-1">
                            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-700 text-white text-sm font-semibold rounded-xl hover:bg-green-800 transition shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                Upload Foto
                            </button>
                            @if (session('status') === 'photo-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition.opacity.duration.500ms x-init="setTimeout(() => show = false, 3000)"
                                   class="text-sm font-medium text-green-700 bg-green-50 px-3 py-1.5 rounded-lg">✅ Foto diperbarui!</p>
                            @endif
                        </div>
                    </form>

                    @if(auth()->user()->profile_photo)
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <form method="POST" action="{{ route('profile.photo.delete') }}" onsubmit="return confirm('Yakin ingin menghapus foto profil?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-2 text-sm font-semibold text-red-600 hover:text-red-700 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus Foto Profil
                                </button>
                            </form>
                            @if (session('status') === 'photo-deleted')
                                <p x-data="{ show: true }" x-show="show" x-transition.opacity.duration.500ms x-init="setTimeout(() => show = false, 3000)"
                                   class="text-sm font-medium text-red-600 bg-red-50 px-3 py-1.5 rounded-lg mt-2">🗑️ Foto dihapus!</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            {{-- Profile Information Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-green-100/80 overflow-hidden hover:shadow-md transition-shadow duration-300">
                <div class="px-6 py-4 border-b border-green-50 flex items-center gap-3" style="background: linear-gradient(90deg, #f0fdf4, #ffffff);">
                    <span class="flex items-center justify-center w-9 h-9 rounded-xl bg-green-100 text-green-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </span>
                    <div>
                        <h3 class="text-base font-bold text-gray-800">Informasi Profil</h3>
                        <p class="text-xs text-gray-500">Perbarui nama dan alamat email akun Anda</p>
                    </div>
                </div>
                <div class="px-6 py-6">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Password Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-emerald-100/80 overflow-hidden hover:shadow-md transition-shadow duration-300">
                <div class="px-6 py-4 border-b border-emerald-50 flex items-center gap-3" style="background: linear-gradient(90deg, #ecfdf5, #ffffff);">
                    <span class="flex items-center justify-center w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </span>
                    <div>
                        <h3 class="text-base font-bold text-gray-800">Keamanan Akun</h3>
                        <p class="text-xs text-gray-500">Gunakan kata sandi yang kuat untuk melindungi akun Anda</p>
                    </div>
                </div>
                <div class="px-6 py-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Delete Account Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-red-100/80 overflow-hidden hover:shadow-md transition-shadow duration-300">
                <div class="px-6 py-4 border-b border-red-50 flex items-center gap-3" style="background: linear-gradient(90deg, #fef2f2, #ffffff);">
                    <span class="flex items-center justify-center w-9 h-9 rounded-xl bg-red-100 text-red-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    </span>
                    <div>
                        <h3 class="text-base font-bold text-gray-800">Zona Bahaya</h3>
                        <p class="text-xs text-gray-500">Tindakan ini bersifat permanen dan tidak dapat dibatalkan</p>
                    </div>
                </div>
                <div class="px-6 py-6">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>

    <script>
        function previewPhoto(input) {
            const file = input.files[0];
            if (!file) return;
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran foto maksimal 2MB. File yang dipilih: ' + (file.size / 1024 / 1024).toFixed(1) + 'MB');
                input.value = '';
                return;
            }
            const preview = document.getElementById('photoPreview');
            const reader = new FileReader();
            reader.onload = function(e) {
                if (preview.tagName !== 'IMG') {
                    const img = document.createElement('img');
                    img.id = 'photoPreview';
                    img.className = 'w-24 h-24 rounded-2xl object-cover border-2 border-green-200 shadow-sm';
                    img.alt = 'Preview';
                    img.src = e.target.result;
                    preview.parentNode.replaceChild(img, preview);
                } else {
                    preview.src = e.target.result;
                }
            };
            reader.readAsDataURL(file);
        }
    </script>

</body>
</html>