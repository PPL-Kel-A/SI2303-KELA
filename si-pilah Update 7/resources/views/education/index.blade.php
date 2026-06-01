<x-app-layout>
    <div class="max-w-6xl mx-auto px-6 py-10">

        <!-- HEADER -->
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-green-800 mb-2">
                📚 Edukasi Lingkungan
            </h1>
            <p class="text-gray-500">
                Pelajari cara menjaga lingkungan dengan artikel pilihan 🌱
            </p>
        </div>

        <!-- LIST -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">

            @forelse($educations as $edu)

                <a href="{{ route('education.show', $edu) }}"
                   class="bg-white rounded-2xl border border-green-100 
                          shadow-sm hover:shadow-xl hover:-translate-y-1 
                          transition duration-300 overflow-hidden block">

                    <!-- COVER -->
                    @if($edu->cover)
                        <div class="w-full h-40 bg-green-50 overflow-hidden">
                            <img src="{{ asset('cover/' . $edu->cover) }}"
                                 class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="w-full h-40 bg-green-50 flex items-center justify-center text-green-600 text-sm">
                            🌿 Tidak ada cover
                        </div>
                    @endif

                    <!-- CONTENT -->
                    <div class="p-5">

                        <!-- TITLE -->
                        <h2 class="text-base font-semibold text-gray-800 mb-2 line-clamp-2">
                            {{ $edu->title }}
                        </h2>

                        <!-- DATE -->
                        <p class="text-xs text-gray-400 mb-4">
                            {{ $edu->created_at->format('d M Y') }}
                        </p>

                        <!-- BUTTON -->
                        <span class="w-full inline-flex items-center justify-center gap-2 text-sm font-semibold 
                                     bg-green-600 text-white px-4 py-2 rounded-lg 
                                     shadow-md hover:bg-green-700 hover:shadow-lg 
                                     active:scale-95 transition duration-200">
                            📄 Baca Artikel
                        </span>

                    </div>

                </a>

            @empty

                <!-- EMPTY STATE -->
                <div class="col-span-full text-center py-20">
                    <div class="text-6xl mb-4">📭</div>
                    <h3 class="text-lg font-semibold text-gray-700">
                        Belum ada edukasi
                    </h3>
                    <p class="text-gray-500 mt-2">
                        Konten edukasi akan segera tersedia.
                    </p>
                </div>

            @endforelse

        </div>

        <!-- PAGINATION -->
        <div class="mt-12">
            {{ $educations->links() }}
        </div>

        @include('partials.footer')
    </div>
</x-app-layout>