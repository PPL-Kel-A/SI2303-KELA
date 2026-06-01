@extends('admin.layouts.app')

@section('title', 'Edukasi')
@section('page-title', 'Manajemen Edukasi')
@section('page-description', 'Kelola artikel edukasi untuk pengguna')

@section('content')
<div class="max-w-7xl mx-auto">

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-green-700">Manajemen Edukasi</h2>
        <p class="text-gray-500">Tambahkan artikel edukasi berupa teks</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 text-red-600 p-3 rounded mb-4">
            <ul class="text-sm">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- FORM -->
    <div class="bg-white p-6 rounded-xl shadow mb-10 border border-green-100">
        <h3 class="text-lg font-semibold mb-4 text-green-700">Tambah Artikel</h3>

        <form action="{{ route('admin.educations.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block font-medium mb-1">Judul Artikel</label>
                <input type="text" name="title"
                    value="{{ old('title') }}"
                    class="border p-3 w-full rounded-lg focus:ring-2 focus:ring-green-400"
                    placeholder="Contoh: Cara Mengelola Sampah">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Cover (Opsional)</label>
                <input type="file" name="cover" accept="image/*"
                    class="border p-3 w-full rounded-lg">
                @error('cover')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Isi Artikel</label>
                <textarea name="content" rows="8"
                    class="border p-3 w-full rounded-lg focus:ring-2 focus:ring-green-400"
                    placeholder="Tulis isi artikel di sini...">{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition">
                Simpan Artikel
            </button>
        </form>
    </div>

    <!-- LIST -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($educations as $edu)
            <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden border border-gray-100">

                @if($edu->cover)
                    <img src="{{ asset('cover/' . $edu->cover) }}"
                         class="w-full h-32 object-cover">
                @else
                    <div class="w-full h-32 bg-green-100 flex items-center justify-center text-green-700 text-sm">
                        Tidak ada cover
                    </div>
                @endif

                <div class="p-4">
                    <h3 class="text-base font-semibold text-gray-800 mb-2 line-clamp-2">
                        {{ $edu->title }}
                    </h3>

                    @if($edu->content)
                        <p class="text-sm text-gray-500 line-clamp-3">
                            {{ $edu->content }}
                        </p>
                    @endif

                    <p class="text-xs text-gray-400 mt-2">
                        {{ $edu->created_at->format('d M Y') }}
                    </p>

                    <div class="flex justify-between items-center mt-4">
                        <a href="{{ route('admin.educations.edit', $edu->id) }}"
                           class="text-blue-500 text-sm hover:underline">Edit</a>

                        <form action="{{ route('admin.educations.delete', $edu->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500 text-sm hover:underline">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16">
                <div class="text-4xl mb-3">📭</div>
                <p class="text-gray-500">Belum ada artikel edukasi</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">{{ $educations->links() }}</div>
</div>
@endsection