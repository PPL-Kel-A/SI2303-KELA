@extends('admin.layouts.app')

@section('title', 'Pesan Kontak')
@section('page-title', 'Pesan Kontak Masuk')
@section('page-description', 'Kelola pesan dan pertanyaan dari pengguna')

@section('content')

{{-- Filter & Search --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.contact.messages') }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request('status') === null ? 'bg-sipilah-700 text-white shadow-sm' : 'bg-gray-50 text-gray-600 hover:bg-gray-100' }}">
            Semua
        </a>
        <a href="{{ route('admin.contact.messages', ['status' => 'Baru', 'search' => request('search')]) }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request('status') === 'Baru' ? 'bg-sipilah-700 text-white shadow-sm' : 'bg-gray-50 text-gray-600 hover:bg-gray-100' }}">
            Baru @if($unreadCount > 0)<span class="ml-1 bg-red-500 text-white text-[10px] px-1.5 py-0.5 rounded-full">{{ $unreadCount }}</span>@endif
        </a>
        <a href="{{ route('admin.contact.messages', ['status' => 'Dibaca', 'search' => request('search')]) }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request('status') === 'Dibaca' ? 'bg-sipilah-700 text-white shadow-sm' : 'bg-gray-50 text-gray-600 hover:bg-gray-100' }}">
            Dibaca
        </a>
        <a href="{{ route('admin.contact.messages', ['status' => 'Dibalas', 'search' => request('search')]) }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition {{ request('status') === 'Dibalas' ? 'bg-sipilah-700 text-white shadow-sm' : 'bg-gray-50 text-gray-600 hover:bg-gray-100' }}">
            Dibalas
        </a>
    </div>

    <form method="GET" action="{{ route('admin.contact.messages') }}" class="flex">
        @if(request('status'))
            <input type="hidden" name="status" value="{{ request('status') }}">
        @endif
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau subjek..." class="w-full md:w-64 border border-gray-200 rounded-l-xl px-4 py-2 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none">
        <button type="submit" class="bg-gray-100 border border-gray-200 border-l-0 text-gray-600 px-4 py-2 rounded-r-xl hover:bg-gray-200 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </button>
    </form>
</div>

{{-- Messages List --}}
<div class="space-y-4">
    @forelse($messages as $message)
    <div x-data="{ open: false, showReplyForm: false }" class="bg-white rounded-2xl shadow-sm border {{ $message->status === 'Baru' ? 'border-l-4 border-l-green-500 border-gray-100' : 'border-gray-100' }} overflow-hidden">
        {{-- Header / Summary --}}
        <div @click="open = !open; if(open && '{{ $message->status }}' === 'Baru') { document.getElementById('read-form-{{ $message->id }}').submit(); }" 
             class="p-5 cursor-pointer hover:bg-gray-50 transition flex flex-col md:flex-row gap-4 items-start md:items-center justify-between">
            
            <div class="flex items-start gap-4 flex-1">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 border border-gray-200 flex items-center justify-center text-gray-500 font-bold shrink-0">
                    {{ strtoupper(substr($message->name, 0, 1)) }}
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <h4 class="font-bold text-gray-800 {{ $message->status === 'Baru' ? '' : 'text-gray-600' }}">{{ $message->name }}</h4>
                        @if($message->user_id)
                            <span class="bg-blue-50 text-blue-600 text-[10px] font-bold px-2 py-0.5 rounded-md border border-blue-100">User Terdaftar</span>
                        @endif
                    </div>
                    <p class="text-sm font-semibold text-gray-800 mb-0.5 {{ $message->status === 'Baru' ? '' : 'text-gray-600' }}">{{ $message->subject }}</p>
                    <p class="text-xs text-gray-500 truncate max-w-xl">{{ Str::limit($message->message, 80) }}</p>
                </div>
            </div>

            <div class="flex flex-col items-end gap-2 shrink-0 w-full md:w-auto">
                <div class="flex items-center gap-2">
                    @if($message->status === 'Baru')
                        <span class="bg-green-100 text-green-700 text-xs font-bold px-2.5 py-1 rounded-lg">Baru</span>
                    @elseif($message->status === 'Dibaca')
                        <span class="bg-gray-100 text-gray-600 text-xs font-bold px-2.5 py-1 rounded-lg">Dibaca</span>
                    @else
                        <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2.5 py-1 rounded-lg flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Dibalas
                        </span>
                    @endif
                </div>
                <span class="text-xs text-gray-400 font-medium">{{ $message->created_at->diffForHumans() }}</span>
            </div>
            
            <svg class="w-5 h-5 text-gray-400 transition-transform hidden md:block" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </div>

        {{-- Hidden Form to mark as read --}}
        @if($message->status === 'Baru')
            <form id="read-form-{{ $message->id }}" action="{{ route('admin.contact.messages.read', $message) }}" method="POST" class="hidden">
                @csrf
                @method('PATCH')
            </form>
        @endif

        {{-- Expanded Content --}}
        <div x-show="open" x-collapse>
            <div class="p-6 bg-gray-50/50 border-t border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    {{-- Detail Info --}}
                    <div class="md:col-span-1 space-y-4">
                        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
                            <h5 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-3">Info Pengirim</h5>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs text-gray-500 mb-0.5">Nama</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $message->name }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-0.5">Email</p>
                                    <a href="mailto:{{ $message->email }}" class="text-sm font-semibold text-sipilah-600 hover:underline">{{ $message->email }}</a>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-0.5">Tanggal</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $message->created_at->translatedFormat('d F Y, H:i') }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex gap-2">
                            <button @click="showReplyForm = !showReplyForm" class="flex-1 bg-sipilah-700 text-white px-4 py-2 rounded-lg text-xs font-bold hover:bg-sipilah-800 transition flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                Balas
                            </button>
                            <form action="{{ route('admin.contact.messages.delete', $message) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesan ini?');" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-50 text-red-600 px-4 py-2 rounded-lg text-xs font-bold hover:bg-red-100 transition flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Message Content & Reply --}}
                    <div class="md:col-span-2 space-y-4">
                        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm relative">
                            <h5 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-2">Pesan Masuk</h5>
                            <h4 class="font-bold text-gray-800 mb-3">{{ $message->subject }}</h4>
                            <div class="prose prose-sm max-w-none text-gray-700 whitespace-pre-line bg-gray-50 p-4 rounded-xl border border-gray-100">
                                {{ $message->message }}
                            </div>
                        </div>

                        {{-- Previous Reply (if any) --}}
                        @if($message->status === 'Dibalas')
                            <div class="bg-blue-50/50 p-5 rounded-xl border border-blue-100 shadow-sm">
                                <div class="flex items-center justify-between mb-3">
                                    <h5 class="text-[10px] font-bold text-blue-500 uppercase tracking-wider flex items-center gap-1.5">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Balasan Anda
                                    </h5>
                                    <span class="text-xs text-gray-400">{{ $message->replied_at->translatedFormat('d F Y, H:i') }}</span>
                                </div>
                                <div class="prose prose-sm max-w-none text-gray-700 whitespace-pre-line bg-white p-4 rounded-xl border border-blue-50">
                                    {{ $message->admin_reply }}
                                </div>
                            </div>
                        @endif

                        {{-- Reply Form --}}
                        <div x-show="showReplyForm" x-collapse>
                            <form action="{{ route('admin.contact.messages.reply', $message) }}" method="POST" class="bg-white p-5 rounded-xl border border-sipilah-100 shadow-md">
                                @csrf
                                <h5 class="text-[10px] font-bold text-sipilah-600 uppercase tracking-wider mb-3">Tulis Balasan</h5>
                                @if($message->user_id)
                                    <div class="mb-3 flex items-center gap-2 text-xs text-blue-600 bg-blue-50 px-3 py-2 rounded-lg border border-blue-100">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Balasan akan dikirim sebagai notifikasi ke dashboard user.
                                    </div>
                                @else
                                    <div class="mb-3 flex items-center gap-2 text-xs text-orange-600 bg-orange-50 px-3 py-2 rounded-lg border border-orange-100">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        Pengirim bukan user terdaftar. Sistem akan mencatat balasan ini, namun Anda perlu membalas secara manual via email ({{ $message->email }}).
                                    </div>
                                @endif
                                
                                <textarea name="admin_reply" rows="4" required placeholder="Tulis balasan di sini..." class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-sipilah-500 focus:border-transparent outline-none resize-none mb-3">{{ $message->admin_reply }}</textarea>
                                
                                <div class="flex justify-end gap-2">
                                    <button type="button" @click="showReplyForm = false" class="px-4 py-2 text-sm font-semibold text-gray-500 hover:bg-gray-100 rounded-lg transition">Batal</button>
                                    <button type="submit" class="bg-sipilah-700 text-white px-5 py-2 rounded-lg text-sm font-bold hover:bg-sipilah-800 transition shadow-sm">Kirim Balasan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm py-16 text-center">
        <div class="w-20 h-20 mx-auto rounded-full bg-gray-50 flex items-center justify-center mb-4">
            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </div>
        <h3 class="text-lg font-bold text-gray-700 mb-1">Tidak Ada Pesan</h3>
        <p class="text-sm text-gray-400">Belum ada pesan yang masuk dengan kriteria tersebut.</p>
    </div>
    @endforelse

    <div class="mt-6">
        {{ $messages->links() }}
    </div>
</div>

@endsection
