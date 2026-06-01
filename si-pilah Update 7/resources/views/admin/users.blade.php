@extends('admin.layouts.app')

@section('title', 'Kelola Users')
@section('page-title', 'Kelola Users')
@section('page-description', 'Daftar semua pengguna terdaftar')

@section('content')

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <h3 class="font-bold text-gray-800">Daftar Users ({{ $users->total() }})</h3>
        <form method="GET" action="{{ route('admin.users') }}" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="border border-gray-200 rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none w-52">
            <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-gray-700 transition">🔍 Cari</button>
            @if(request('search'))
                <a href="{{ route('admin.users') }}" class="bg-gray-100 text-gray-600 px-3 py-2 rounded-lg text-xs font-bold hover:bg-gray-200 transition">✕</a>
            @endif
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">Nama</th>
                    <th class="px-6 py-3 text-left">Email</th>
                    <th class="px-6 py-3 text-left">Role</th>
                    <th class="px-6 py-3 text-left">Terdaftar</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50/50" x-data="{ editing: false }">
                    {{-- View Mode --}}
                    <template x-if="!editing">
                        <td class="px-6 py-3 text-gray-400">{{ $user->id }}</td>
                    </template>
                    <template x-if="!editing">
                        <td class="px-6 py-3 font-medium text-gray-700">{{ $user->name }}</td>
                    </template>
                    <template x-if="!editing">
                        <td class="px-6 py-3 text-gray-600">{{ $user->email }}</td>
                    </template>
                    <template x-if="!editing">
                        <td class="px-6 py-3">
                            @if($user->is_admin)
                                <span class="px-2 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-700">Admin</span>
                            @else
                                <span class="px-2 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600">User</span>
                            @endif
                        </td>
                    </template>
                    <template x-if="!editing">
                        <td class="px-6 py-3 text-gray-400 text-xs">{{ $user->created_at->format('d/m/Y') }}</td>
                    </template>
                    <template x-if="!editing">
                        <td class="px-6 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button @click="editing = true" class="text-xs bg-blue-50 text-blue-600 px-3 py-1.5 rounded-lg font-semibold hover:bg-blue-100 transition">Edit</button>
                                @if($user->id !== Auth::id())
                                <form method="POST" action="{{ route('admin.users.delete', $user) }}" onsubmit="return confirm('Yakin hapus user ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs bg-red-50 text-red-600 px-3 py-1.5 rounded-lg font-semibold hover:bg-red-100 transition">Hapus</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </template>

                    {{-- Edit Mode --}}
                    <template x-if="editing">
                        <td colspan="6" class="px-6 py-3">
                            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="flex flex-wrap items-center gap-3">
                                @csrf @method('PUT')
                                <input type="text" name="name" value="{{ $user->name }}" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none" placeholder="Nama">
                                <input type="email" name="email" value="{{ $user->email }}" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none" placeholder="Email">
                                <label class="flex items-center gap-2 text-sm">
                                    <input type="checkbox" name="is_admin" {{ $user->is_admin ? 'checked' : '' }} class="rounded text-sipilah-600 focus:ring-sipilah-500">
                                    Admin
                                </label>
                                <button type="submit" class="bg-sipilah-700 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-sipilah-800 transition">Simpan</button>
                                <button type="button" @click="editing = false" class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg text-xs font-bold hover:bg-gray-200 transition">Batal</button>
                            </form>
                        </td>
                    </template>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">Belum ada user</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $users->links() }}
    </div>
</div>

@endsection
