@extends('admin.layouts.app')

@section('title', 'Laporan')
@section('page-title', 'Kelola Laporan')
@section('page-description', 'Kelola semua laporan dari pengguna')

@section('content')

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <h3 class="font-bold text-gray-800">Daftar Laporan ({{ $reports->total() }})</h3>
        <form method="GET" action="{{ route('admin.reports') }}" class="flex gap-2 flex-wrap">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau deskripsi..." class="border border-gray-200 rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none w-48">
            <select name="status" class="border border-gray-200 rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none">
                <option value="">Semua Status</option>
                @foreach(['Menunggu', 'Diproses', 'Selesai', 'Dibatalkan'] as $s)
                    <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ $s }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-gray-700 transition">🔍 Cari</button>
            @if(request('search') || request('status'))
                <a href="{{ route('admin.reports') }}" class="bg-gray-100 text-gray-600 px-3 py-2 rounded-lg text-xs font-bold hover:bg-gray-200 transition">✕</a>
            @endif
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">User</th>
                    <th class="px-6 py-3 text-left">Judul</th>
                    <th class="px-6 py-3 text-left">Deskripsi</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Tanggal</th>
                    <th class="px-6 py-3 text-center">Ubah Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($reports as $report)
                <tr class="hover:bg-gray-50/50">
                    <td class="px-6 py-3 text-gray-400">{{ $report->id }}</td>
                    <td class="px-6 py-3 font-medium text-gray-700">{{ $report->user->name ?? '-' }}</td>
                    <td class="px-6 py-3 text-gray-700 font-medium">{{ $report->judul }}</td>
                    <td class="px-6 py-3 text-gray-500 truncate max-w-[200px]" title="{{ $report->deskripsi }}">{{ Str::limit($report->deskripsi, 50) }}</td>
                    <td class="px-6 py-3">
                        @php
                            $colors = ['Menunggu' => 'yellow', 'Diproses' => 'blue', 'Selesai' => 'green', 'Dibatalkan' => 'red'];
                            $c = $colors[$report->status] ?? 'gray';
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs font-bold bg-{{ $c }}-100 text-{{ $c }}-700">{{ $report->status }}</span>
                    </td>
                    <td class="px-6 py-3 text-gray-400 text-xs">{{ $report->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.reports.feedback.form', $report->id) }}" class="bg-blue-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-blue-700 transition" title="Tindak Lanjut">
                                📋
                            </a>
                            
                            <form method="POST" action="{{ route('admin.reports.status', $report) }}" class="flex items-center gap-2 contents">
                                @csrf @method('PUT')
                                <select name="status" class="border border-gray-200 rounded-lg px-2 py-1.5 text-xs focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none">
                                    @foreach(['Menunggu', 'Diproses', 'Selesai', 'Dibatalkan'] as $s)
                                        <option value="{{ $s }}" {{ $report->status === $s ? 'selected' : '' }}>{{ $s }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="bg-sipilah-700 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-sipilah-800 transition">Update</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-8 text-center text-gray-400">Belum ada laporan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $reports->links() }}
    </div>
</div>

@endsection
