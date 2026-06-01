@extends('admin.layouts.app')

@section('title', 'Kelola Pengumuman')
@section('page-title', 'Kelola Pengumuman')
@section('page-description', 'Buat dan jadwalkan pesan pengumuman untuk seluruh warga')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Form Tambah Pengumuman --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between">
        <div>
            <div class="flex items-center gap-2.5 mb-5">
                <span class="flex items-center justify-center w-9 h-9 rounded-xl bg-orange-50 text-orange-600 text-lg">📢</span>
                <div>
                    <h3 class="text-base font-bold text-gray-800">Buat Pengumuman Baru</h3>
                    <p class="text-xs text-gray-400">Jadwalkan pesan penting di aplikasi warga</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.announcements.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Judul Pengumuman *</label>
                    <input type="text" name="judul" required placeholder="Contoh: Info Pemadaman / Gotong Royong" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Isi Pesan Pengumuman *</label>
                    <textarea name="konten" required rows="4" placeholder="Tulis konten pengumuman di sini..." class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none resize-none"></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Mulai Tayang (Opsional)</label>
                        <input type="datetime-local" name="start_at" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none">
                        <p class="text-[10px] text-gray-400 mt-1">Kosongkan untuk langsung tayang</p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Batas Akhir (Opsional)</label>
                        <input type="datetime-local" name="end_at" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none">
                        <p class="text-[10px] text-gray-400 mt-1">Kosongkan untuk tayang selamanya</p>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-sipilah-700 text-white py-3 rounded-xl text-sm font-bold hover:bg-sipilah-800 transition shadow-sm flex items-center justify-center gap-2">
                        <span>🚀</span> Terbitkan Pengumuman
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Riwayat Pengumuman --}}
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Daftar Pengumuman ({{ $announcements->total() }})</h3>
        </div>

        <div class="divide-y divide-gray-50 overflow-y-auto max-h-[600px]">
            @forelse($announcements as $announcement)
            <div class="p-6 hover:bg-gray-50/50 transition duration-150" x-data="{ editing: false }">
                
                {{-- Mode Tampil --}}
                <div x-show="!editing" class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                    <div class="space-y-2 flex-1">
                        <div class="flex items-center gap-2 flex-wrap">
                            {{-- Judul --}}
                            <h4 class="font-bold text-gray-800 text-sm">{{ $announcement->judul ?: 'Pengumuman' }}</h4>
                            
                            {{-- Status Badge --}}
                            @php
                                $status = $announcement->status;
                                $color = 'green';
                                if ($status === 'Akan Tayang') $color = 'yellow';
                                if ($status === 'Selesai') $color = 'gray';
                            @endphp
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-{{ $color }}-100 text-{{ $color }}-700 border border-{{ $color }}-200">
                                {{ $status }}
                            </span>
                        </div>

                        {{-- Konten --}}
                        <p class="text-xs text-gray-600 leading-relaxed">{{ $announcement->konten }}</p>

                        {{-- Waktu tayang --}}
                        <div class="flex items-center gap-4 text-[10px] text-gray-400 font-medium">
                            <span class="flex items-center gap-1">
                                📅 Mulai: {{ $announcement->start_at ? $announcement->start_at->translatedFormat('d M Y, H:i') : 'Langsung' }}
                            </span>
                            <span class="flex items-center gap-1">
                                ⏳ Selesai: {{ $announcement->end_at ? $announcement->end_at->translatedFormat('d M Y, H:i') : 'Selamanya' }}
                            </span>
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex sm:flex-col sm:items-end justify-start gap-2 shrink-0 pt-2 sm:pt-0">
                        <button @click="editing = true" class="text-xs font-bold bg-blue-50 text-blue-600 px-3 py-1.5 rounded-xl hover:bg-blue-100 transition shadow-sm w-full text-center">
                            Ubah
                        </button>
                        <form method="POST" action="{{ route('admin.announcements.delete', $announcement) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs font-bold bg-red-50 text-red-600 px-3 py-1.5 rounded-xl hover:bg-red-100 transition shadow-sm w-full text-center">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Mode Edit --}}
                <div x-show="editing" style="display:none;" class="space-y-4">
                    <h5 class="text-xs font-bold text-gray-800 flex items-center gap-1">✏️ Edit Pengumuman</h5>
                    <form method="POST" action="{{ route('admin.announcements.update', $announcement) }}" class="space-y-3">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-[10px] font-semibold text-gray-500 mb-1">Judul Pengumuman</label>
                            <input type="text" name="judul" required value="{{ $announcement->judul }}" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none">
                        </div>

                        <div>
                            <label class="block text-[10px] font-semibold text-gray-500 mb-1">Konten Pengumuman</label>
                            <textarea name="konten" required rows="3" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none resize-none">{{ $announcement->konten }}</textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-semibold text-gray-500 mb-1">Mulai Tayang</label>
                                <input type="datetime-local" name="start_at" value="{{ $announcement->start_at ? $announcement->start_at->format('Y-m-d\TH:i') : '' }}" class="w-full border border-gray-200 rounded-xl px-3 py-1.5 text-xs focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none">
                            </div>

                            <div>
                                <label class="block text-[10px] font-semibold text-gray-500 mb-1">Batas Akhir</label>
                                <input type="datetime-local" name="end_at" value="{{ $announcement->end_at ? $announcement->end_at->format('Y-m-d\TH:i') : '' }}" class="w-full border border-gray-200 rounded-xl px-3 py-1.5 text-xs focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none">
                            </div>
                        </div>

                        <div class="flex gap-2 pt-2">
                            <button type="submit" class="bg-sipilah-700 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-sipilah-800 transition">
                                Simpan Perubahan
                            </button>
                            <button type="button" @click="editing = false" class="bg-gray-100 text-gray-600 px-4 py-2 rounded-xl text-xs font-bold hover:bg-gray-200 transition">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-gray-400">
                <span class="text-3xl block mb-2">📢</span>
                <p class="text-xs font-medium">Belum ada pengumuman yang diterbitkan.</p>
            </div>
            @endforelse
        </div>

        <div class="px-6 py-4 border-t border-gray-100">
            {{ $announcements->links() }}
        </div>
    </div>
</div>

@endsection
