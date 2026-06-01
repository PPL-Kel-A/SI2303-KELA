@extends('admin.layouts.app')

@section('title', 'Kelola About')
@section('page-title', 'Kelola Halaman About')
@section('page-description', 'Edit konten halaman About yang ditampilkan ke pengunjung')

@section('content')

<div x-data="{ activeTab: 'hero' }" class="space-y-6">

    {{-- Tab Navigation --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-2">
        <div class="flex flex-wrap gap-1">
            <button @click="activeTab = 'hero'" :class="activeTab === 'hero' ? 'bg-sipilah-700 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100'" class="px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center gap-2">
                <span>🏔️</span> Hero
            </button>
            <button @click="activeTab = 'visi'" :class="activeTab === 'visi' ? 'bg-sipilah-700 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100'" class="px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center gap-2">
                <span>👁️</span> Visi & Strategi
            </button>
            <button @click="activeTab = 'sejarah'" :class="activeTab === 'sejarah' ? 'bg-sipilah-700 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100'" class="px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center gap-2">
                <span>📜</span> Sejarah
            </button>
            <button @click="activeTab = 'team'" :class="activeTab === 'team' ? 'bg-sipilah-700 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100'" class="px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center gap-2">
                <span>👥</span> Tim
            </button>
            <button @click="activeTab = 'layanan'" :class="activeTab === 'layanan' ? 'bg-sipilah-700 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100'" class="px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 flex items-center gap-2">
                <span>🛠️</span> Layanan
            </button>
        </div>
    </div>

    {{-- ==================== HERO TAB ==================== --}}
    <div x-show="activeTab === 'hero'" x-transition>
        <form method="POST" action="{{ route('admin.about.update') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="section" value="hero">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-1 text-lg flex items-center gap-2">🏔️ Hero Section</h3>
                <p class="text-xs text-gray-400 mb-6">Banner utama yang muncul di bagian atas halaman About</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Badge Text</label>
                        <input type="text" name="hero_badge" value="{{ $hero['badge'] ?? 'SI-PILAH' }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Subtitle</label>
                        <input type="text" name="hero_subtitle" value="{{ $hero['subtitle'] ?? '' }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Judul Utama</label>
                        <input type="text" name="hero_title" value="{{ $hero['title'] ?? '' }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Deskripsi</label>
                        <textarea name="hero_description" rows="3" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none resize-none">{{ $hero['description'] ?? '' }}</textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Background Image</label>
                        @php $heroImg = \App\Models\AboutSetting::getImage('hero', 'background'); @endphp
                        @if($heroImg)
                            <div class="mb-3 relative inline-block">
                                <img src="{{ asset('images/about/' . $heroImg) }}" class="w-full max-w-md h-32 object-cover rounded-xl border border-gray-200">
                            </div>
                        @endif
                        <input type="file" name="hero_background" accept="image/*" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sipilah-500 outline-none file:mr-4 file:py-1 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-sipilah-50 file:text-sipilah-700">
                        <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG. Maks: 2MB. Kosongkan jika tidak ingin mengubah.</p>
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

    {{-- ==================== VISI & STRATEGI TAB ==================== --}}
    <div x-show="activeTab === 'visi'" x-transition>
        <form method="POST" action="{{ route('admin.about.update') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="section" value="visi">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-6">
                <div>
                    <h3 class="font-bold text-gray-800 mb-1 text-lg flex items-center gap-2">👁️ Visi & Strategi</h3>
                    <p class="text-xs text-gray-400 mb-6">Bagian visi dan strategi di halaman About</p>
                </div>

                {{-- Gambar Visi --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Gambar Section (kiri)</label>
                    @php $visiImg = \App\Models\AboutSetting::getImage('visi', 'image'); @endphp
                    @if($visiImg)
                        <div class="mb-3">
                            <img src="{{ asset('images/about/' . $visiImg) }}" class="w-full max-w-sm h-40 object-cover rounded-xl border border-gray-200">
                        </div>
                    @endif
                    <input type="file" name="visi_image" accept="image/*" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sipilah-500 outline-none file:mr-4 file:py-1 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-sipilah-50 file:text-sipilah-700">
                </div>

                {{-- Visi --}}
                <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                    <h4 class="font-bold text-gray-700 mb-3 text-sm">📌 Visi</h4>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1">Judul</label>
                            <input type="text" name="visi_title" value="{{ $visi['title'] ?? '' }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none bg-white">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1">Deskripsi</label>
                            <textarea name="visi_description" rows="3" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none resize-none bg-white">{{ $visi['description'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Strategi --}}
                <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                    <h4 class="font-bold text-gray-700 mb-3 text-sm">📌 Strategi</h4>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1">Judul</label>
                            <input type="text" name="strategi_title" value="{{ $strategi['title'] ?? '' }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none bg-white">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 mb-1">Deskripsi</label>
                            <textarea name="strategi_description" rows="3" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none resize-none bg-white">{{ $strategi['description'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="bg-sipilah-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-sipilah-800 transition shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Visi & Strategi
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- ==================== SEJARAH TAB ==================== --}}
    <div x-show="activeTab === 'sejarah'" x-transition>
        <form method="POST" action="{{ route('admin.about.update') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="section" value="sejarah">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-1 text-lg flex items-center gap-2">📜 Sejarah SI-Pilah</h3>
                <p class="text-xs text-gray-400 mb-6">Timeline sejarah perkembangan SI-Pilah (4 milestone)</p>

                {{-- Background Image --}}
                <div class="mb-6">
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Background Image</label>
                    @php $sejarahImg = \App\Models\AboutSetting::getImage('sejarah', 'background'); @endphp
                    @if($sejarahImg)
                        <div class="mb-3">
                            <img src="{{ asset('images/about/' . $sejarahImg) }}" class="w-full max-w-md h-28 object-cover rounded-xl border border-gray-200">
                        </div>
                    @endif
                    <input type="file" name="sejarah_background" accept="image/*" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sipilah-500 outline-none file:mr-4 file:py-1 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-sipilah-50 file:text-sipilah-700">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @for($i = 1; $i <= 4; $i++)
                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                        <h4 class="font-bold text-gray-700 mb-3 text-sm">Milestone {{ $i }}</h4>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 mb-1">Tahun</label>
                                <input type="text" name="sejarah_item_{{ $i }}_year" value="{{ $sejarah['item_'.$i.'_year'] ?? '' }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none bg-white">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 mb-1">Judul</label>
                                <input type="text" name="sejarah_item_{{ $i }}_title" value="{{ $sejarah['item_'.$i.'_title'] ?? '' }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none bg-white">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 mb-1">Deskripsi</label>
                                <textarea name="sejarah_item_{{ $i }}_desc" rows="3" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none resize-none bg-white">{{ $sejarah['item_'.$i.'_desc'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="bg-sipilah-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-sipilah-800 transition shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Sejarah
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- ==================== TEAM TAB ==================== --}}
    <div x-show="activeTab === 'team'" x-transition>
        <form method="POST" action="{{ route('admin.about.update') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="section" value="team">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-1 text-lg flex items-center gap-2">👥 Tim Kami</h3>
                <p class="text-xs text-gray-400 mb-6">Kelola anggota tim yang ditampilkan di halaman About</p>

                {{-- Team Description --}}
                <div class="mb-6">
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Deskripsi Tim</label>
                    <textarea name="team_description" rows="2" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none resize-none">{{ $team['description'] ?? '' }}</textarea>
                </div>

                {{-- Team Members --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @for($i = 1; $i <= 7; $i++)
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-green-200 to-green-500 rounded-full flex items-center justify-center text-white font-bold text-sm">{{ $i }}</div>
                            <h4 class="font-bold text-gray-700 text-sm">Anggota {{ $i }} @if($i === 1) <span class="text-xs text-sipilah-700 bg-sipilah-50 px-2 py-0.5 rounded-lg ml-1">Leader</span> @endif</h4>
                        </div>
                        <div class="space-y-2">
                            <div>
                                <label class="block text-[10px] font-semibold text-gray-400 mb-0.5 uppercase tracking-wider">Nama</label>
                                <input type="text" name="team_member_{{ $i }}_name" value="{{ $team['member_'.$i.'_name'] ?? '' }}" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none bg-white">
                            </div>
                            <div>
                                <label class="block text-[10px] font-semibold text-gray-400 mb-0.5 uppercase tracking-wider">Jabatan</label>
                                <input type="text" name="team_member_{{ $i }}_role" value="{{ $team['member_'.$i.'_role'] ?? '' }}" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none bg-white">
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="bg-sipilah-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-sipilah-800 transition shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Tim
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- ==================== LAYANAN TAB ==================== --}}
    <div x-show="activeTab === 'layanan'" x-transition>
        <form method="POST" action="{{ route('admin.about.update') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="section" value="layanan">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-800 mb-1 text-lg flex items-center gap-2">🛠️ Layanan Kami</h3>
                <p class="text-xs text-gray-400 mb-6">4 kartu layanan yang ditampilkan di halaman About</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @php
                        $layananImages = ['service-consulting.png', 'service-collection.png', 'service-recycling.png', 'service-digital.png'];
                    @endphp
                    @for($i = 1; $i <= 4; $i++)
                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                        <h4 class="font-bold text-gray-700 mb-3 text-sm flex items-center gap-2">
                            <span class="w-6 h-6 bg-sipilah-100 text-sipilah-700 rounded-lg flex items-center justify-center text-xs font-bold">{{ $i }}</span>
                            Layanan {{ $i }}
                        </h4>

                        {{-- Current image --}}
                        @php $layananImg = \App\Models\AboutSetting::getImage('layanan', 'item_'.$i.'_image'); @endphp
                        @if($layananImg)
                            <div class="mb-3">
                                <img src="{{ asset('images/about/' . $layananImg) }}" class="w-full h-24 object-cover rounded-lg border border-gray-200">
                            </div>
                        @endif

                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 mb-1">Gambar</label>
                                <input type="file" name="layanan_item_{{ $i }}_image" accept="image/*" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-sipilah-500 outline-none bg-white file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-sipilah-50 file:text-sipilah-700">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 mb-1">Judul</label>
                                <input type="text" name="layanan_item_{{ $i }}_title" value="{{ $layanan['item_'.$i.'_title'] ?? '' }}" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none bg-white">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 mb-1">Deskripsi</label>
                                <textarea name="layanan_item_{{ $i }}_desc" rows="3" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none resize-none bg-white">{{ $layanan['item_'.$i.'_desc'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="bg-sipilah-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-sipilah-800 transition shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Layanan
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Preview Link --}}
    <div class="text-center">
        <a href="{{ route('about') }}" target="_blank" class="inline-flex items-center gap-2 text-sm text-sipilah-700 hover:text-sipilah-900 font-semibold transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            Lihat Halaman About →
        </a>
    </div>
</div>

@endsection
