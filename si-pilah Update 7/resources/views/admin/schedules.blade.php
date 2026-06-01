@extends('admin.layouts.app')

@section('title', 'Jadwal')
@section('page-title', 'Kelola Jadwal')
@section('page-description', 'Atur jadwal penjemputan sampah')

@section('content')

{{-- Form Tambah Jadwal --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
    <h3 class="font-bold text-gray-800 mb-4">➕ Tambah Jadwal Baru</h3>
    <form method="POST" action="{{ route('admin.schedules.store') }}" class="flex flex-wrap items-end gap-4">
        @csrf
        <div class="flex-1 min-w-[200px]">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Waktu Jemput</label>
            <input type="datetime-local" name="waktu_jemput" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none">
        </div>
        <div class="flex-1 min-w-[150px]">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Kategori</label>
            <input type="text" name="kategori" required placeholder="Sampah Plastik" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none">
        </div>
        <div class="flex-1 min-w-[150px]">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Nama Petugas</label>
            <input type="text" name="nama_petugas" required placeholder="Truk Tim A" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none">
        </div>
        <div class="flex-1 min-w-[150px]">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Kelurahan</label>
            <input type="text" name="kelurahan" required placeholder="Contoh: Menteng" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none">
        </div>
        <button type="submit" class="bg-sipilah-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-sipilah-800 transition shadow-sm">Tambah Jadwal</button>
    </form>
</div>

{{-- Tabel Jadwal --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="font-bold text-gray-800">Daftar Jadwal ({{ $schedules->total() }})</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">Waktu Jemput</th>
                    <th class="px-6 py-3 text-left">Kategori</th>
                    <th class="px-6 py-3 text-left">Petugas</th>
                    <th class="px-6 py-3 text-left">Kelurahan</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($schedules as $schedule)
                <tr class="hover:bg-gray-50/50" x-data="{ editing: false }">
                    {{-- View Mode --}}
                    <template x-if="!editing">
                        <td class="px-6 py-3 text-gray-400">{{ $schedule->id }}</td>
                    </template>
                    <template x-if="!editing">
                        <td class="px-6 py-3 text-gray-700 font-medium">
                            {{ \Carbon\Carbon::parse($schedule->waktu_jemput)->translatedFormat('l, d F Y - H:i') }}
                        </td>
                    </template>
                    <template x-if="!editing">
                        <td class="px-6 py-3 text-gray-600">{{ $schedule->kategori }}</td>
                    </template>
                    <template x-if="!editing">
                        <td class="px-6 py-3 text-gray-600">{{ $schedule->nama_petugas }}</td>
                    </template>
                    <template x-if="!editing">
                        <td class="px-6 py-3 text-gray-600">{{ $schedule->kelurahan ?? '-' }}</td>
                    </template>
                    <template x-if="!editing">
                        <td class="px-6 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button @click="editing = true" class="text-xs bg-blue-50 text-blue-600 px-3 py-1.5 rounded-lg font-semibold hover:bg-blue-100 transition">Edit</button>
                                <form method="POST" action="{{ route('admin.schedules.delete', $schedule) }}" onsubmit="return confirm('Yakin hapus jadwal ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs bg-red-50 text-red-600 px-3 py-1.5 rounded-lg font-semibold hover:bg-red-100 transition">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </template>

                    {{-- Edit Mode --}}
                    <template x-if="editing">
                        <td colspan="6" class="px-6 py-3">
                            <form method="POST" action="{{ route('admin.schedules.update', $schedule) }}" class="flex flex-wrap items-center gap-3">
                                @csrf @method('PUT')
                                <input type="datetime-local" name="waktu_jemput" value="{{ \Carbon\Carbon::parse($schedule->waktu_jemput)->format('Y-m-d\TH:i') }}" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none">
                                <input type="text" name="kategori" value="{{ $schedule->kategori }}" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none" placeholder="Kategori">
                                <input type="text" name="nama_petugas" value="{{ $schedule->nama_petugas }}" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none" placeholder="Petugas">
                                <input type="text" name="kelurahan" value="{{ $schedule->kelurahan }}" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none" placeholder="Kelurahan">
                                <button type="submit" class="bg-sipilah-700 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-sipilah-800 transition">Simpan</button>
                                <button type="button" @click="editing = false" class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg text-xs font-bold hover:bg-gray-200 transition">Batal</button>
                            </form>
                        </td>
                    </template>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">Belum ada jadwal</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $schedules->links() }}
    </div>
</div>

@endsection
