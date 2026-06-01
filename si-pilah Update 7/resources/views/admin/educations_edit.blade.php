@extends('admin.layouts.app')

@section('title', 'Edit Artikel')
@section('page-title', 'Edit Artikel')
@section('page-description', 'Edit artikel edukasi')

@section('content')
<div class="max-w-xl mx-auto">

    <h2 class="text-xl font-bold mb-4 text-green-700">Edit Artikel</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-600 p-3 rounded mb-4">
            <ul class="text-sm">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.educations.update', $education->id) }}"
          method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-medium mb-1">Judul</label>
            <input type="text" name="title"
                   value="{{ old('title', $education->title) }}"
                   class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-green-400">
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Cover Baru (opsional)</label>
            @if($education->cover)
                <img src="{{ asset('cover/' . $education->cover) }}"
                     class="h-24 object-cover rounded mb-2">
            @endif
            <input type="file" name="cover" accept="image/*"
                   class="w-full border p-2 rounded">
            @error('cover')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Isi Artikel</label>
            <textarea name="content" rows="8"
                class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-green-400"
                placeholder="Tulis isi artikel di sini...">{{ old('content', $education->content) }}</textarea>
            @error('content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-3">
            <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">
                Update
            </button>
            <a href="{{ route('admin.educations') }}"
               class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg">
                Batal
            </a>
        </div>

    </form>
</div>
@endsection