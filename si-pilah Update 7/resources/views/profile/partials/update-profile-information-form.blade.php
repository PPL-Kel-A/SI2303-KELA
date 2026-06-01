<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <!-- Name -->
        <div>
            <x-input-label for="name" value="Nama Lengkap" />
            <x-text-input id="name" name="name" type="text" class="mt-1.5 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" placeholder="Masukkan nama lengkap" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" value="Alamat Email" />
            <x-text-input id="email" name="email" type="email" class="mt-1.5 block w-full" :value="old('email', $user->email)" required autocomplete="username" placeholder="nama@email.com" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3">
                    <p class="text-sm text-amber-700 bg-amber-50 border border-amber-200 rounded-xl px-4 py-2.5">
                        ⚠️ Email Anda belum diverifikasi.
                        <button form="send-verification" class="underline font-semibold text-amber-800 hover:text-amber-900 ml-1">
                            Kirim ulang email verifikasi
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-700 bg-green-50 border border-green-200 rounded-xl px-4 py-2.5">
                            ✅ Link verifikasi baru telah dikirim ke email Anda.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- TPS Terdekat & Kelurahan -->
        <div class="space-y-4">
            <!-- Pilihan TPS Terdekat -->
            <div>
                <x-input-label for="tps_terdekat" value="TPS Terdekat Anda (Poin Pengumpulan Sampah) *" />
                <select id="tps_terdekat" name="tps_terdekat" class="mt-1.5 block w-full rounded-xl border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required onchange="updateProfileTPS(this.value)">
                    <option value="">-- Pilih TPS Terdekat --</option>
                    <option value="TPS Kebon Jeruk" {{ old('tps_terdekat', $user->tps_terdekat) == 'TPS Kebon Jeruk' ? 'selected' : '' }}>TPS Kebon Jeruk</option>
                    <option value="TPS Palmerah" {{ old('tps_terdekat', $user->tps_terdekat) == 'TPS Palmerah' ? 'selected' : '' }}>TPS Palmerah</option>
                    <option value="TPS Grogol" {{ old('tps_terdekat', $user->tps_terdekat) == 'TPS Grogol' ? 'selected' : '' }}>TPS Grogol</option>
                    <option value="TPS Cengkareng" {{ old('tps_terdekat', $user->tps_terdekat) == 'TPS Cengkareng' ? 'selected' : '' }}>TPS Cengkareng</option>
                    <option value="TPS Kembangan" {{ old('tps_terdekat', $user->tps_terdekat) == 'TPS Kembangan' ? 'selected' : '' }}>TPS Kembangan</option>
                    <option value="TPS Slipi" {{ old('tps_terdekat', $user->tps_terdekat) == 'TPS Slipi' ? 'selected' : '' }}>TPS Slipi</option>
                    <option value="TPS Taman Sari" {{ old('tps_terdekat', $user->tps_terdekat) == 'TPS Taman Sari' ? 'selected' : '' }}>TPS Taman Sari</option>
                    <option value="TPS Kebayoran Baru" {{ old('tps_terdekat', $user->tps_terdekat) == 'TPS Kebayoran Baru' ? 'selected' : '' }}>TPS Kebayoran Baru (Selatan)</option>
                    <option value="TPS Cilandak" {{ old('tps_terdekat', $user->tps_terdekat) == 'TPS Cilandak' ? 'selected' : '' }}>TPS Cilandak (Selatan)</option>
                    <option value="TPS Menteng" {{ old('tps_terdekat', $user->tps_terdekat) == 'TPS Menteng' ? 'selected' : '' }}>TPS Menteng (Pusat)</option>
                    <option value="TPS Tanah Abang" {{ old('tps_terdekat', $user->tps_terdekat) == 'TPS Tanah Abang' ? 'selected' : '' }}>TPS Tanah Abang (Pusat)</option>
                    <option value="TPS Jatinegara" {{ old('tps_terdekat', $user->tps_terdekat) == 'TPS Jatinegara' ? 'selected' : '' }}>TPS Jatinegara (Timur)</option>
                    <option value="TPS Duren Sawit" {{ old('tps_terdekat', $user->tps_terdekat) == 'TPS Duren Sawit' ? 'selected' : '' }}>TPS Duren Sawit (Timur)</option>
                    <option value="TPS Penjaringan" {{ old('tps_terdekat', $user->tps_terdekat) == 'TPS Penjaringan' ? 'selected' : '' }}>TPS Penjaringan (Utara)</option>
                    <option value="TPS Kelapa Gading" {{ old('tps_terdekat', $user->tps_terdekat) == 'TPS Kelapa Gading' ? 'selected' : '' }}>TPS Kelapa Gading (Utara)</option>
                </select>
                <p class="text-xs text-gray-400 mt-1">Pilih TPS yang paling dekat dengan lokasi rumah Anda.</p>
                <x-input-error class="mt-2" :messages="$errors->get('tps_terdekat')" />
            </div>

            <!-- Kelurahan / Wilayah (Otomatis terisi) -->
            <div>
                <x-input-label for="kelurahan" value="Wilayah Kelurahan (Terisi Otomatis)" />
                <x-text-input id="kelurahan" name="kelurahan" type="text" class="mt-1.5 block w-full bg-gray-50 cursor-not-allowed font-medium text-gray-700" :value="old('kelurahan', $user->kelurahan)" readonly placeholder="Akan terisi otomatis setelah memilih TPS" />
                <p class="text-xs text-gray-400 mt-1">Sistem menyinkronkan jadwal truk sampah berdasarkan wilayah kelurahan TPS terdekat.</p>
                <x-input-error class="mt-2" :messages="$errors->get('kelurahan')" />
            </div>

            <!-- Mini Map TPS -->
            <div>
                <x-input-label value="Lokasi TPS Terdekat Pada Peta" />
                <div id="tpsProfileMap" class="mt-2 rounded-2xl border border-gray-200 shadow-inner overflow-hidden" style="height: 220px; z-index: 1;"></div>
            </div>
        </div>

        <script>
            const profileTpsData = {
                'TPS Kebon Jeruk': {
                    lat: -6.1886, lng: 106.7716,
                    desa: 'Kelurahan Kebon Jeruk',
                    address: 'Jl. Kebon Jeruk Raya, Jakarta Barat'
                },
                'TPS Palmerah': {
                    lat: -6.2066, lng: 106.7972,
                    desa: 'Kelurahan Palmerah',
                    address: 'Jl. Palmerah Utara, Jakarta Barat'
                },
                'TPS Grogol': {
                    lat: -6.1615, lng: 106.7860,
                    desa: 'Kelurahan Grogol',
                    address: 'Jl. Daan Mogot, Grogol, Jakarta Barat'
                },
                'TPS Cengkareng': {
                    lat: -6.1457, lng: 106.7295,
                    desa: 'Kelurahan Cengkareng Timur',
                    address: 'Jl. Daan Mogot KM.14, Cengkareng, Jakarta Barat'
                },
                'TPS Kembangan': {
                    lat: -6.1870, lng: 106.7490,
                    desa: 'Kelurahan Kembangan Utara',
                    address: 'Jl. Kembangan Raya, Kembangan, Jakarta Barat'
                },
                'TPS Slipi': {
                    lat: -6.1920, lng: 106.7985,
                    desa: 'Kelurahan Slipi',
                    address: 'Jl. S. Parman, Slipi, Jakarta Barat'
                },
                'TPS Taman Sari': {
                    lat: -6.1490, lng: 106.8125,
                    desa: 'Kelurahan Taman Sari',
                    address: 'Jl. Taman Sari Raya, Jakarta Barat'
                },
                'TPS Kebayoran Baru': {
                    lat: -6.2443, lng: 106.7973,
                    desa: 'Kelurahan Selong',
                    address: 'Jl. Selong, Kebayoran Baru, Jakarta Selatan'
                },
                'TPS Cilandak': {
                    lat: -6.2901, lng: 106.7972,
                    desa: 'Kelurahan Cilandak Barat',
                    address: 'Jl. Cilandak Raya, Jakarta Selatan'
                },
                'TPS Menteng': {
                    lat: -6.2014, lng: 106.8322,
                    desa: 'Kelurahan Menteng',
                    address: 'Jl. Menteng Raya, Jakarta Pusat'
                },
                'TPS Tanah Abang': {
                    lat: -6.2120, lng: 106.8180,
                    desa: 'Kelurahan Karet Tengsin',
                    address: 'Jl. KH. Mas Mansyur, Tanah Abang, Jakarta Pusat'
                },
                'TPS Jatinegara': {
                    lat: -6.2250, lng: 106.8790,
                    desa: 'Kelurahan Bali Mester',
                    address: 'Jl. Jatinegara Timur, Jakarta Timur'
                },
                'TPS Duren Sawit': {
                    lat: -6.2230, lng: 106.9010,
                    desa: 'Kelurahan Duren Sawit',
                    address: 'Jl. Duren Sawit Raya, Jakarta Timur'
                },
                'TPS Penjaringan': {
                    lat: -6.1274, lng: 106.7915,
                    desa: 'Kelurahan Penjaringan',
                    address: 'Jl. Pluit Raya, Penjaringan, Jakarta Utara'
                },
                'TPS Kelapa Gading': {
                    lat: -6.1550, lng: 106.9020,
                    desa: 'Kelurahan Kelapa Gading Timur',
                    address: 'Jl. Boulevard Raya, Kelapa Gading, Jakarta Utara'
                }
            };

            let pMap;
            const markers = {};

            document.addEventListener("DOMContentLoaded", function () {
                // Inisialisasi peta
                const defaultCenter = [-6.1750, 106.7750];
                const activeTpsName = document.getElementById('tps_terdekat').value;
                let initialCenter = defaultCenter;
                let initialZoom = 12;

                if (activeTpsName && profileTpsData[activeTpsName]) {
                    initialCenter = [profileTpsData[activeTpsName].lat, profileTpsData[activeTpsName].lng];
                    initialZoom = 14;
                }

                pMap = L.map('tpsProfileMap').setView(initialCenter, initialZoom);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors',
                    maxZoom: 19
                }).addTo(pMap);

                const greenIcon = L.icon({
                    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
                    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41]
                });

                const blueIcon = L.icon({
                    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
                    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41]
                });

                // Tambahkan semua marker TPS ke peta
                for (const [name, loc] of Object.entries(profileTpsData)) {
                    const isSelected = (name === activeTpsName);
                    const marker = L.marker([loc.lat, loc.lng], { icon: isSelected ? greenIcon : blueIcon })
                        .addTo(pMap)
                        .bindPopup(`<strong>${name}</strong><br><span style="font-size:12px;color:#666">${loc.address}</span>`);
                    
                    // Simpan marker
                    markers[name] = marker;

                    // Klik marker untuk memilih TPS secara otomatis
                    marker.on('click', function () {
                        document.getElementById('tps_terdekat').value = name;
                        updateProfileTPS(name);
                    });

                    if (isSelected) {
                        // Buka popup setelah map dimuat
                        setTimeout(() => {
                            marker.openPopup();
                        }, 200);
                    }
                }

                // Perbaiki rendering layout peta di dalam tab / modal
                setTimeout(() => {
                    pMap.invalidateSize();
                }, 500);
            });

            function updateProfileTPS(tpsName) {
                const greenIcon = L.icon({
                    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
                    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41]
                });

                const blueIcon = L.icon({
                    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
                    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41]
                });

                // Reset semua marker ke warna biru
                for (const [name, marker] of Object.entries(markers)) {
                    marker.setIcon(blueIcon);
                }

                if (!tpsName) {
                    document.getElementById('kelurahan').value = '';
                    pMap.setView([-6.1750, 106.7750], 12);
                    return;
                }

                const data = profileTpsData[tpsName];
                if (data) {
                    document.getElementById('kelurahan').value = data.desa;

                    pMap.flyTo([data.lat, data.lng], 15, { duration: 1 });

                    // Ubah marker terpilih menjadi warna hijau dan buka popup
                    if (markers[tpsName]) {
                        markers[tpsName].setIcon(greenIcon);
                        markers[tpsName].openPopup();
                    }
                }
            }
        </script>

        <!-- Save Button -->
        <div class="flex items-center gap-4 pt-2">
            <x-primary-button>
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Simpan Perubahan
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition.opacity.duration.500ms
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm font-medium text-green-700 bg-green-50 px-3 py-1.5 rounded-lg"
                >✅ Tersimpan!</p>
            @endif
        </div>
    </form>
</section>
