@extends('admin.layouts.app')

@section('title', 'Reward')
@section('page-title', 'Kelola Reward')
@section('page-description', 'Tambah dan kelola poin reward pengguna')

@section('content')

{{-- Form Tambah Reward --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
    <h3 class="font-bold text-gray-800 mb-4">➕ Tambah Reward Baru</h3>
    <form method="POST" action="{{ route('admin.rewards.store') }}" class="flex flex-wrap items-end gap-4">
        @csrf
        <div class="flex-1 min-w-[200px]">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Pilih User</label>
            <select name="user_id" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none">
                <option value="">-- Pilih User --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
        </div>
        <div class="w-40">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Poin</label>
            <input type="number" name="points" min="1" required placeholder="100" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none">
        </div>
        <button type="submit" class="bg-sipilah-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-sipilah-800 transition shadow-sm">Tambah Reward</button>
    </form>
</div>

{{-- Tabel Reward --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="font-bold text-gray-800">Daftar Reward ({{ $rewards->total() }})</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">User</th>
                    <th class="px-6 py-3 text-left">Poin</th>
                    <th class="px-6 py-3 text-left">Tanggal</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($rewards as $reward)
                <tr class="hover:bg-gray-50/50">
                    <td class="px-6 py-3 text-gray-400">{{ $reward->id }}</td>
                    <td class="px-6 py-3 font-medium text-gray-700">{{ $reward->user->name ?? '-' }}</td>
                    <td class="px-6 py-3 text-gray-800 font-bold">{{ number_format($reward->points) }} <span class="text-xs font-normal text-gray-400">Pts</span></td>
                    <td class="px-6 py-3 text-gray-400 text-xs">{{ $reward->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-3 text-center">
                        <form method="POST" action="{{ route('admin.rewards.delete', $reward) }}" onsubmit="return confirm('Yakin hapus reward ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs bg-red-50 text-red-600 px-3 py-1.5 rounded-lg font-semibold hover:bg-red-100 transition">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada reward</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $rewards->links() }}
    </div>
</div>

@endsection
