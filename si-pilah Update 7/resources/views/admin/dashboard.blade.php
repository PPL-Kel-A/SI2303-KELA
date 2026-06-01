@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-description', 'Ringkasan data dan statistik Si-Pilah')

@section('content')

{{-- Stats Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition group">
        <div class="flex items-center justify-between mb-3">
            <div class="w-11 h-11 bg-blue-50 rounded-xl flex items-center justify-center text-xl group-hover:scale-110 transition">👥</div>
            <span class="text-xs font-bold text-blue-500 bg-blue-50 px-2 py-1 rounded-full">Users</span>
        </div>
        <p class="text-2xl font-bold text-gray-800">{{ number_format($data['total_users']) }}</p>
        <p class="text-xs text-gray-400 mt-1">Total pengguna terdaftar</p>
    </div>

    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition group">
        <div class="flex items-center justify-between mb-3">
            <div class="w-11 h-11 bg-green-50 rounded-xl flex items-center justify-center text-xl group-hover:scale-110 transition">♻️</div>
            <span class="text-xs font-bold text-green-500 bg-green-50 px-2 py-1 rounded-full">Sampah</span>
        </div>
        <p class="text-2xl font-bold text-gray-800">{{ number_format($data['total_sampah'], 1) }} <span class="text-sm font-normal text-gray-400">Kg</span></p>
        <p class="text-xs text-gray-400 mt-1">Total sampah terkumpul</p>
    </div>

    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition group">
        <div class="flex items-center justify-between mb-3">
            <div class="w-11 h-11 bg-yellow-50 rounded-xl flex items-center justify-center text-xl group-hover:scale-110 transition">⚡</div>
            <span class="text-xs font-bold text-yellow-600 bg-yellow-50 px-2 py-1 rounded-full">Energi</span>
        </div>
        <p class="text-2xl font-bold text-gray-800">{{ number_format($data['total_energi'], 1) }} <span class="text-sm font-normal text-gray-400">kWh</span></p>
        <p class="text-xs text-gray-400 mt-1">Energi surya dihasilkan</p>
    </div>

    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition group">
        <div class="flex items-center justify-between mb-3">
            <div class="w-11 h-11 bg-purple-50 rounded-xl flex items-center justify-center text-xl group-hover:scale-110 transition">🎁</div>
            <span class="text-xs font-bold text-purple-500 bg-purple-50 px-2 py-1 rounded-full">Reward</span>
        </div>
        <p class="text-2xl font-bold text-gray-800">{{ number_format($data['total_poin']) }} <span class="text-sm font-normal text-gray-400">Pts</span></p>
        <p class="text-xs text-gray-400 mt-1">Poin reward tersalurkan</p>
    </div>
</div>

{{-- Second Row Stats --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-11 h-11 bg-red-50 rounded-xl flex items-center justify-center text-xl">📋</div>
        <div>
            <p class="text-xl font-bold text-gray-800">{{ $data['laporan_aktif'] }} <span class="text-sm font-normal text-gray-400">/ {{ $data['total_laporan'] }}</span></p>
            <p class="text-xs text-gray-400">Laporan aktif / total</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-11 h-11 bg-teal-50 rounded-xl flex items-center justify-center text-xl">📅</div>
        <div>
            <p class="text-xl font-bold text-gray-800">{{ $data['total_jadwal'] }}</p>
            <p class="text-xs text-gray-400">Jadwal penjemputan</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-11 h-11 bg-orange-50 rounded-xl flex items-center justify-center text-xl">📢</div>
        <div>
            <p class="text-xl font-bold text-gray-800">{{ $data['total_pengumuman'] }}</p>
            <p class="text-xs text-gray-400">Pengumuman aktif</p>
        </div>
    </div>
</div>

{{-- Recent Tables --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Laporan Terbaru --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Laporan Terbaru</h3>
            <a href="{{ route('admin.reports') }}" class="text-xs text-sipilah-700 font-semibold hover:underline">Lihat Semua →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                    <tr>
                        <th class="px-6 py-3 text-left">User</th>
                        <th class="px-6 py-3 text-left">Judul</th>
                        <th class="px-6 py-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($laporanTerbaru as $laporan)
                    <tr class="hover:bg-gray-50/50">
                        <td class="px-6 py-3 font-medium text-gray-700">{{ $laporan->user->name ?? '-' }}</td>
                        <td class="px-6 py-3 text-gray-600 truncate max-w-[150px]">{{ $laporan->judul }}</td>
                        <td class="px-6 py-3">
                            @php
                                $colors = ['Menunggu' => 'yellow', 'Diproses' => 'blue', 'Selesai' => 'green', 'Dibatalkan' => 'red'];
                                $c = $colors[$laporan->status] ?? 'gray';
                            @endphp
                            <span class="px-2 py-1 rounded-full text-xs font-bold bg-{{ $c }}-100 text-{{ $c }}-700">{{ $laporan->status }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="px-6 py-8 text-center text-gray-400">Belum ada laporan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Setoran Sampah Terbaru --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Setoran Sampah Terbaru</h3>
            <a href="{{ route('admin.wastes') }}" class="text-xs text-sipilah-700 font-semibold hover:underline">Lihat Semua →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                    <tr>
                        <th class="px-6 py-3 text-left">Nama</th>
                        <th class="px-6 py-3 text-left">Tipe</th>
                        <th class="px-6 py-3 text-left">Berat</th>
                        <th class="px-6 py-3 text-left">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($wastesTerbaru as $waste)
                    <tr class="hover:bg-gray-50/50">
                        <td class="px-6 py-3 font-medium text-gray-700">{{ $waste->name ?? '-' }}</td>
                        <td class="px-6 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-bold {{ $waste->type === 'organic' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ ucfirst($waste->type) }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-gray-600">{{ number_format($waste->weight, 1) }} Kg</td>
                        <td class="px-6 py-3 text-gray-400 text-xs">{{ $waste->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-6 py-8 text-center text-gray-400">Belum ada data sampah</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- ── PENGUMUMAN & PENJADWALAN TAYANG ── --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-8">
    {{-- Form Tambah Pengumuman (Col-span 1) --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between">
        <div>
            <div class="flex items-center gap-2.5 mb-5">
                <span class="flex items-center justify-center w-9 h-9 rounded-xl bg-orange-50 text-orange-600 text-lg">📢</span>
                <div>
                    <h3 class="text-base font-bold text-gray-800">Buat Pengumuman Baru</h3>
                    <p class="text-xs text-gray-400">Terbitkan pesan terjadwal untuk warga</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.announcements.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Judul Pengumuman *</label>
                    <input type="text" name="judul" required placeholder="Contoh: Pemadaman Listrik / Kerja Bakti" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Isi Pesan Pengumuman *</label>
                    <textarea name="konten" required rows="3" placeholder="Tulis konten pengumuman di sini..." class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none resize-none"></textarea>
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

    {{-- Riwayat Pengumuman (Col-span 2) --}}
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Riwayat Pengumuman</h3>
            <span class="text-xs font-bold bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">{{ count($announcements) }} Pesan</span>
        </div>

        <div class="overflow-y-auto max-h-[500px] divide-y divide-gray-50">
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
    </div>
</div>

@endsection
