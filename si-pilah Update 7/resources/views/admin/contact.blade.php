@extends('admin.layouts.app')

@section('title', 'Kelola Contact')
@section('page-title', 'Kelola Halaman Contact')
@section('page-description', 'Edit informasi kontak yang ditampilkan ke pengunjung')

@section('content')

<div x-data="{ activeTab: 'hero' }" class="space-y-6">

    {{-- Tab Navigation --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-2">
        <div class="flex flex-wrap gap-1">
            <button @click="activeTab = 'hero'" :class="activeTab === 'hero' ? 'bg-sipilah-700 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100'" class="px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center gap-2">
                <span>🏔️</span> Hero
            </button>
            <button @click="activeTab = 'info'" :class="activeTab === 'info' ? 'bg-sipilah-700 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100'" class="px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center gap-2">
                <span>📇</span> Info Kontak
            </button>
            <button @click="activeTab = 'sosmed'" :class="activeTab === 'sosmed' ? 'bg-sipilah-700 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100'" class="px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center gap-2">
                <span>🌐</span> Sosial Media
            </button>
        </div>
    </div>

    {{-- ==================== HERO TAB ==================== --}}
    <div x-show="activeTab === 'hero'" x-transition>
        <form method="POST" action="{{ route('admin.contact.update') }}">
            @csrf
            <input type="hidden" name="section" value="contact_hero">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-1 text-lg flex items-center gap-2">🏔️ Hero Section</h3>
                <p class="text-xs text-gray-400 mb-6">Banner utama yang muncul di bagian atas halaman Contact</p>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Judul</label>
                        <input type="text" name="contact_hero_title" value="{{ $hero['title'] ?? 'Hubungi Kami' }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none">
                        <p class="text-xs text-gray-400 mt-1">Bagian judul yang dicetak tebal. Teks setelah pipe (|) akan dicetak hijau & italic. Contoh: <code class="bg-gray-100 px-1 rounded">Hubungi |Kami</code></p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Deskripsi</label>
                        <textarea name="contact_hero_description" rows="3" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none resize-none">{{ $hero['description'] ?? 'Ada pertanyaan, masukan, atau ingin berkolaborasi? Jangan ragu untuk menghubungi tim Si-Pilah.' }}</textarea>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="bg-sipilah-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-sipilah-800 transition shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Hero
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- ==================== INFO KONTAK TAB ==================== --}}
    <div x-show="activeTab === 'info'" x-transition>
        <form method="POST" action="{{ route('admin.contact.update') }}">
            @csrf
            <input type="hidden" name="section" value="contact_info">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-1 text-lg flex items-center gap-2">📇 Informasi Kontak</h3>
                <p class="text-xs text-gray-400 mb-6">Detail kontak yang ditampilkan di halaman Contact</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Email --}}
                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                        <h4 class="font-bold text-gray-700 mb-3 text-sm flex items-center gap-2">
                            <span class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center text-base">📧</span>
                            Email
                        </h4>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 mb-1">Email Utama</label>
                                <input type="email" name="contact_info_email_1" value="{{ $info['email_1'] ?? 'info@sipilah.id' }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none bg-white">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 mb-1">Email Support</label>
                                <input type="email" name="contact_info_email_2" value="{{ $info['email_2'] ?? 'support@sipilah.id' }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none bg-white">
                            </div>
                        </div>
                    </div>

                    {{-- Telepon --}}
                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                        <h4 class="font-bold text-gray-700 mb-3 text-sm flex items-center gap-2">
                            <span class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center text-base">📞</span>
                            Telepon
                        </h4>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 mb-1">Nomor Telepon</label>
                                <input type="text" name="contact_info_phone" value="{{ $info['phone'] ?? '(021) 1234-5678' }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none bg-white">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 mb-1">Jam Operasional</label>
                                <input type="text" name="contact_info_phone_hours" value="{{ $info['phone_hours'] ?? 'Senin - Jumat, 08:00 - 17:00 WIB' }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none bg-white">
                            </div>
                        </div>
                    </div>

                    {{-- Alamat --}}
                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-100 md:col-span-2">
                        <h4 class="font-bold text-gray-700 mb-3 text-sm flex items-center gap-2">
                            <span class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center text-base">📍</span>
                            Alamat
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 mb-1">Alamat Baris 1</label>
                                <input type="text" name="contact_info_address_1" value="{{ $info['address_1'] ?? 'Jl. Lingkungan Hijau No. 42' }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none bg-white">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 mb-1">Alamat Baris 2</label>
                                <input type="text" name="contact_info_address_2" value="{{ $info['address_2'] ?? 'Jakarta Barat, DKI Jakarta 11530' }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none bg-white">
                            </div>
                        </div>
                    </div>

                    {{-- Google Maps Embed --}}
                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-100 md:col-span-2">
                        <h4 class="font-bold text-gray-700 mb-3 text-sm flex items-center gap-2">
                            <span class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center text-base">🗺️</span>
                            Google Maps (Opsional)
                        </h4>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1">Embed URL Google Maps</label>
                            <input type="url" name="contact_info_maps_url" value="{{ $info['maps_url'] ?? '' }}" placeholder="https://www.google.com/maps/embed?pb=..." class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none bg-white">
                            <p class="text-xs text-gray-400 mt-1">Buka Google Maps → Klik "Bagikan" → Tab "Sematkan peta" → Salin URL dari src iframe.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="bg-sipilah-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-sipilah-800 transition shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Info Kontak
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- ==================== SOSIAL MEDIA TAB ==================== --}}
    <div x-show="activeTab === 'sosmed'" x-transition>
        <form method="POST" action="{{ route('admin.contact.update') }}">
            @csrf
            <input type="hidden" name="section" value="contact_sosmed">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-1 text-lg flex items-center gap-2">🌐 Sosial Media</h3>
                <p class="text-xs text-gray-400 mb-6">Link sosial media yang ditampilkan di halaman Contact. Kosongkan jika tidak ingin menampilkan.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                        <h4 class="font-bold text-gray-700 mb-3 text-sm flex items-center gap-2">
                            <span class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center text-base">📱</span>
                            Facebook
                        </h4>
                        <input type="url" name="contact_sosmed_facebook" value="{{ $sosmed['facebook'] ?? '' }}" placeholder="https://facebook.com/sipilah" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none bg-white">
                    </div>

                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                        <h4 class="font-bold text-gray-700 mb-3 text-sm flex items-center gap-2">
                            <span class="w-8 h-8 bg-sky-100 rounded-lg flex items-center justify-center text-base">🐦</span>
                            Twitter / X
                        </h4>
                        <input type="url" name="contact_sosmed_twitter" value="{{ $sosmed['twitter'] ?? '' }}" placeholder="https://twitter.com/sipilah" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none bg-white">
                    </div>

                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                        <h4 class="font-bold text-gray-700 mb-3 text-sm flex items-center gap-2">
                            <span class="w-8 h-8 bg-pink-100 rounded-lg flex items-center justify-center text-base">📷</span>
                            Instagram
                        </h4>
                        <input type="url" name="contact_sosmed_instagram" value="{{ $sosmed['instagram'] ?? '' }}" placeholder="https://instagram.com/sipilah" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none bg-white">
                    </div>

                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                        <h4 class="font-bold text-gray-700 mb-3 text-sm flex items-center gap-2">
                            <span class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center text-base">💬</span>
                            WhatsApp
                        </h4>
                        <input type="text" name="contact_sosmed_whatsapp" value="{{ $sosmed['whatsapp'] ?? '' }}" placeholder="6281234567890" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none bg-white">
                        <p class="text-xs text-gray-400 mt-1">Format nomor tanpa + atau spasi. Contoh: 6281234567890</p>
                    </div>

                </div>

                <div class="mt-6 pt-4 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="bg-sipilah-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-sipilah-800 transition shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Sosial Media
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Preview Link --}}
    <div class="text-center">
        <a href="{{ route('contact') }}" target="_blank" class="inline-flex items-center gap-2 text-sm text-sipilah-700 hover:text-sipilah-900 font-semibold transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            Lihat Halaman Contact →
        </a>
    </div>
</div>

@endsection
