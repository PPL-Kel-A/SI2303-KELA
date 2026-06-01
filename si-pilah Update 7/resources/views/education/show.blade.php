<x-app-layout>
    <div class="max-w-3xl mx-auto px-6 py-10">

        <!-- BACK -->
        <a href="{{ route('education.index') }}"
           class="inline-flex items-center gap-2 text-sm text-green-700 hover:underline mb-6">
            ← Kembali ke Edukasi
        </a>

        <!-- COVER -->
        @if($education->cover)
            <img src="{{ asset('cover/' . $education->cover) }}"
                 class="w-full h-64 object-cover rounded-2xl mb-6">
        @endif

        <!-- TITLE -->
        <h1 class="text-2xl font-bold text-green-800 mb-2">
            {{ $education->title }}
        </h1>
        <p class="text-xs text-gray-400 mb-8">
            {{ $education->created_at->format('d M Y') }}
        </p>

        <hr class="border-green-100 mb-8">

        <!-- CONTENT -->
        <div class="text-gray-700 leading-relaxed text-sm whitespace-pre-line">
            {{ $education->content }}
        </div>

        <!-- PDF (jika ada) -->
        @if($education->file_pdf)
            <div class="mt-10">
                <a href="{{ asset('pdf/' . $education->file_pdf) }}" target="_blank"
                   class="inline-flex items-center gap-2 bg-green-600 text-white 
                          px-5 py-2 rounded-lg hover:bg-green-700 transition">
                    📥 Download PDF
                </a>
            </div>
        @endif

        @include('partials.footer')
    </div>
</x-app-layout>