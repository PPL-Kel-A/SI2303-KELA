<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Hubungi Si-Pilah - Kontak, email, telepon, dan alamat untuk pertanyaan seputar pengelolaan sampah.">
    <title>Kontak - Si-Pilah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .bg-sipilah-green { background-color: #1b5e20; }
        .text-sipilah-green { color: #1b5e20; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    @include('partials.navbar', ['variant' => 'welcome'])

    {{-- Hero --}}
    @php
        $heroTitle = $hero['title'] ?? 'Hubungi Kami';
        $titleParts = explode('|', $heroTitle, 2);
    @endphp
    <div class="bg-gradient-to-br from-green-900 via-green-800 to-green-700 py-20 text-center text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 right-10 w-72 h-72 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 left-10 w-96 h-96 bg-green-300 rounded-full blur-3xl"></div>
        </div>
        <div class="relative z-10 container mx-auto px-6">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4">
                {{ $titleParts[0] }}@if(isset($titleParts[1]))<span class="text-green-300 italic">{{ $titleParts[1] }}</span>@endif
            </h1>
            <p class="text-lg text-green-100 max-w-2xl mx-auto">{{ $hero['description'] ?? 'Ada pertanyaan, masukan, atau ingin berkolaborasi? Jangan ragu untuk menghubungi tim Si-Pilah.' }}</p>
        </div>
    </div>

    <div class="container mx-auto px-6 py-16">
        <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10">

            {{-- Info Kontak --}}
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Informasi Kontak</h2>
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-xl shrink-0">📧</div>
                        <div>
                            <h4 class="font-bold text-sm text-gray-700">Email</h4>
                            <p class="text-gray-500 text-sm">{{ $info['email_1'] ?? 'info@sipilah.id' }}</p>
                            <p class="text-gray-500 text-sm">{{ $info['email_2'] ?? 'support@sipilah.id' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-xl shrink-0">📞</div>
                        <div>
                            <h4 class="font-bold text-sm text-gray-700">Telepon</h4>
                            <p class="text-gray-500 text-sm">{{ $info['phone'] ?? '(021) 1234-5678' }}</p>
                            <p class="text-gray-500 text-sm">{{ $info['phone_hours'] ?? 'Senin - Jumat, 08:00 - 17:00 WIB' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center text-xl shrink-0">📍</div>
                        <div>
                            <h4 class="font-bold text-sm text-gray-700">Alamat</h4>
                            <p class="text-gray-500 text-sm">{{ $info['address_1'] ?? 'Jl. Lingkungan Hijau No. 42' }}</p>
                            <p class="text-gray-500 text-sm">{{ $info['address_2'] ?? 'Jakarta Barat, DKI Jakarta 11530' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Sosial Media --}}
                <div class="mt-8">
                    <h4 class="font-bold text-sm text-gray-700 mb-3">Ikuti Kami</h4>
                    <div class="flex gap-3">
                        @php
                            $fb = 'https://www.facebook.com/share/1CjLXhWz7Y/';
                            $tw = 'https://x.com/Arsenal';
                            $ig = 'https://www.instagram.com/arsenal?igsh=NDA5d3NxemxzcDdx';
                            $wa = $sosmed['whatsapp'] ?? '';
                        @endphp
                        <a href="{{ $fb }}" target="_blank" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-500 hover:bg-green-100 hover:text-sipilah-green transition" title="Facebook">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                        </a>
                        <a href="{{ $tw }}" target="_blank" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-500 hover:bg-green-100 hover:text-sipilah-green transition" title="X">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 22.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                        <a href="{{ $ig }}" target="_blank" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-500 hover:bg-green-100 hover:text-sipilah-green transition" title="Instagram">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg>
                        </a>
                        @if($wa)
                        <a href="https://wa.me/{{ $wa }}" target="_blank" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-500 hover:bg-green-100 hover:text-sipilah-green transition" title="WhatsApp">💬</a>
                        @endif
                    </div>
                </div>

                {{-- Google Maps --}}
                @if(!empty($info['maps_url']))
                <div class="mt-8">
                    <h4 class="font-bold text-sm text-gray-700 mb-3">Lokasi Kami</h4>
                    <div class="rounded-xl overflow-hidden border border-gray-200 shadow-sm">
                        <iframe src="{{ $info['maps_url'] }}" width="100%" height="220" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                @endif
            </div>

            {{-- Form --}}
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Kirim Pesan</h2>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    @if(session('success'))
                        <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-green-800 text-sm mb-1">Berhasil Terkirim!</h4>
                                <p class="text-sm text-green-700">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('contact.send') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" required placeholder="Masukkan nama Anda" value="{{ old('name', auth()->user()->name ?? '') }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition @error('name') border-red-500 @enderror">
                            @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Email</label>
                            <input type="email" name="email" required placeholder="email@contoh.com" value="{{ old('email', auth()->user()->email ?? '') }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition @error('email') border-red-500 @enderror">
                            @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Subjek</label>
                            <input type="text" name="subject" required placeholder="Tentang apa pesan Anda?" value="{{ old('subject') }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition @error('subject') border-red-500 @enderror">
                            @error('subject') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Pesan</label>
                            <textarea name="message" rows="4" required placeholder="Tulis pesan Anda di sini..." class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none resize-none transition @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                            @error('message') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <button type="submit" class="w-full bg-sipilah-green text-white py-3 rounded-xl font-bold text-sm hover:bg-green-700 transition shadow-sm flex justify-center items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('partials.footer')

</body>
</html>
