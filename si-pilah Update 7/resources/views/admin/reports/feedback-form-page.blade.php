@extends('admin.layouts.app')

@section('title', 'Tindak Lanjut Laporan')
@section('page-title', 'Tindak Lanjut Laporan')
@section('page-description', 'Berikan hasil penanganan laporan sampah kepada pengguna')

@section('content')

<!-- Back Button -->
<div class="mb-6">
    <a href="{{ route('admin.reports') }}" class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-gray-800 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        <span>Kembali ke Daftar Laporan</span>
    </a>
</div>

<!-- Header Section -->
<div class="bg-gradient-to-r from-green-600 to-green-700 text-white rounded-2xl p-8 mb-8 shadow-lg">
    <div class="flex items-start justify-between mb-4">
        <div>
            <h1 class="text-3xl font-bold mb-2">{{ $report->judul }}</h1>
            <p class="text-green-100 text-sm">Laporan dari <strong>{{ $report->user->name ?? '-' }}</strong></p>
        </div>
        <div class="text-right">
            @php
                $colors = [
                    'Menunggu' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
                    'Diproses' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800'],
                    'Selesai' => ['bg' => 'bg-green-100', 'text' => 'text-green-800'],
                    'Dibatalkan' => ['bg' => 'bg-red-100', 'text' => 'text-red-800']
                ];
                $statusColor = $colors[$report->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800'];
            @endphp
            <span class="px-4 py-2 rounded-full text-sm font-bold {{ $statusColor['bg'] }} {{ $statusColor['text'] }}">
                {{ $report->status }}
            </span>
        </div>
    </div>
    <p class="text-green-100 text-sm">Dibuat: {{ $report->created_at->translatedFormat('d F Y, H:i') }}</p>
</div>

<!-- Main Content Grid -->
<div class="grid lg:grid-cols-3 gap-6 mb-6">
    <!-- Report Details (2 columns on lg) -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Deskripsi & Lokasi -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <span class="text-xl">📝</span>
                <span>Detail Laporan</span>
            </h3>
            
            <div class="space-y-5">
                <div>
                    <p class="text-xs font-semibold text-gray-500 mb-2 uppercase tracking-wide">Deskripsi Laporan</p>
                    <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap bg-gray-50 p-4 rounded-lg">
                        {{ $report->deskripsi }}
                    </p>
                </div>

                <div class="pt-4 border-t border-gray-100">
                    <p class="text-xs font-semibold text-gray-500 mb-2 uppercase tracking-wide">📍 Lokasi Detail</p>
                    <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap bg-gray-50 p-4 rounded-lg">
                        {{ $report->detail_alamat }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Foto Laporan -->
        @if($report->foto_laporan)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 pb-4">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <span class="text-xl">📸</span>
                    <span>Foto Laporan User</span>
                </h3>
            </div>
            <img src="{{ asset('storage/' . $report->foto_laporan) }}" 
                 alt="Foto Laporan" 
                 class="w-full h-80 object-cover">
        </div>
        @endif
    </div>

    <!-- Sidebar Info (1 column on lg) -->
    <div class="space-y-6">
        <!-- Feedback Status -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <span class="text-xl">💬</span>
                <span>Status Feedback</span>
            </h3>
            
            @if($report->feedback)
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <p class="text-sm text-green-700 font-semibold mb-2">✅ Feedback Sudah Ada</p>
                    <p class="text-xs text-gray-600">
                        Diperbarui: <strong>{{ $report->feedback->updated_at->translatedFormat('d F Y, H:i') }}</strong>
                    </p>
                    @if($report->feedback->admin)
                        <p class="text-xs text-gray-600 mt-2">
                            Oleh: <strong>{{ $report->feedback->admin->name }}</strong>
                        </p>
                    @endif
                </div>
            @else
                <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                    <p class="text-sm text-orange-700 font-semibold mb-1">⏳ Feedback Belum Ada</p>
                    <p class="text-xs text-gray-600">
                        Silakan berikan feedback hasil penanganan di bawah
                    </p>
                </div>
            @endif
        </div>

        <!-- Reward Status -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <span class="text-xl">⭐</span>
                <span>Status Reward</span>
            </h3>
            
            @if($report->is_rewarded)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-sm text-blue-700 font-semibold mb-1">✅ Poin Sudah Diberikan</p>
                    <p class="text-xs text-gray-600">
                        User telah menerima <strong>10 poin</strong>
                    </p>
                </div>
            @else
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <p class="text-sm text-gray-700 font-semibold mb-1">⏸️ Belum Mendapat Poin</p>
                    <p class="text-xs text-gray-600">
                        Poin akan diberikan saat status berubah menjadi "Selesai"
                    </p>
                </div>
            @endif
        </div>

        <!-- Tips -->
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl border border-green-200 p-6">
            <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                <span class="text-xl">💡</span>
                <span>Tips</span>
            </h3>
            <ul class="text-xs text-gray-700 space-y-2">
                <li class="flex items-start gap-2">
                    <span class="text-green-600 mt-0.5">✓</span>
                    <span>Jelaskan hasil penanganan dengan <strong>detail</strong></span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-green-600 mt-0.5">✓</span>
                    <span>Sertakan <strong>foto bukti</strong> penanganan</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-green-600 mt-0.5">✓</span>
                    <span>Foto maks <strong>2 MB</strong> (JPG/JPEG/PNG)</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-green-600 mt-0.5">✓</span>
                    <span>User akan melihat feedback Anda</span>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- Feedback Form Section -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
    <div class="flex items-center gap-3 mb-8 pb-6 border-b border-gray-100">
        <span class="text-3xl">✏️</span>
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Form Tindak Lanjut</h2>
            <p class="text-sm text-gray-500 mt-1">{{ $report->feedback ? 'Perbarui' : 'Buat' }} feedback hasil penanganan laporan</p>
        </div>
    </div>
    
    @include('admin.reports.components.feedback-form', ['report' => $report, 'feedback' => $report->feedback])
</div>

@endsection
