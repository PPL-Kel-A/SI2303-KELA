@extends('admin.layouts.app')

@section('title', 'Kelola Feedback')
@section('page-title', 'Kelola Feedback Pengguna')
@section('page-description', 'Pilih feedback mana yang ingin ditampilkan di Halaman Utama')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <h3 class="font-bold text-gray-800 text-lg">Daftar Feedback</h3>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-semibold">
                    <th class="px-6 py-4">User & Transaksi</th>
                    <th class="px-6 py-4">Rating</th>
                    <th class="px-6 py-4">Komentar</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4 text-center">Tampilkan di Home</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($reviews as $review)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-green-400 to-emerald-600 flex items-center justify-center font-bold text-white shadow-sm shrink-0">
                                    {{ strtoupper(substr($review->user->name ?? '?', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800">{{ $review->user->name ?? 'Unknown User' }}</p>
                                    @if($review->waste)
                                        <p class="text-[10px] text-gray-500">ID: {{ $review->waste->id }} - {{ ucfirst($review->waste->type) }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex text-yellow-400">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    @else
                                        <svg class="w-5 h-5 text-gray-200" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    @endif
                                @endfor
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-gray-600 line-clamp-2 max-w-xs" title="{{ $review->comment }}">{{ $review->comment ?? '-' }}</p>
                        </td>
                        <td class="px-6 py-4 text-gray-500 text-xs">
                            {{ $review->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('admin.reviews.toggle', $review->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="relative inline-flex items-center h-6 rounded-full w-11 transition-colors duration-200 focus:outline-none {{ $review->is_visible ? 'bg-green-500' : 'bg-gray-300' }}">
                                    <span class="inline-block w-4 h-4 transform bg-white rounded-full transition-transform duration-200 {{ $review->is_visible ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                            Belum ada feedback dari pengguna.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $reviews->links() }}
    </div>
</div>
@endsection
