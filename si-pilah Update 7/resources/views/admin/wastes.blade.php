@extends('admin.layouts.app')

@section('title', 'Data Sampah')
@section('page-title', 'Data Sampah')
@section('page-description', 'Semua data setoran sampah pengguna')

@section('content')

{{-- Statistics --}}
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">

    {{-- Total Waste --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-start justify-between">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        d="M20 7L12 3L4 7L12 11L20 7ZM4 12L12 16L20 12M4 17L12 21L20 17"/>
                </svg>
            </div>

            <span class="px-3 py-1 text-xs rounded-full bg-green-50 text-green-600 font-medium">
                +12%
            </span>
        </div>

        <p class="text-sm text-gray-500 mt-5">
            Total Waste Entries
        </p>

        <h2 class="text-4xl font-bold text-gray-900 mt-1">
            {{ $wastes->total() }}
        </h2>
    </div>

    {{-- Organic --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-start justify-between">
            <div class="w-12 h-12 rounded-2xl bg-green-50 flex items-center justify-center">
                🌿
            </div>

            <span class="px-3 py-1 text-xs rounded-full bg-green-50 text-green-600 font-medium">
                +8%
            </span>
        </div>

        <p class="text-sm text-gray-500 mt-5">
            Organic Waste
        </p>

        <h2 class="text-4xl font-bold text-gray-900 mt-1">
            {{ $organicCount }}
        </h2>

        <p class="text-xs text-gray-400 mt-2">
            {{ number_format($organicWeight,2) }} kg total
        </p>
    </div>

    {{-- Inorganic --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-start justify-between">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center">
                ♻️
            </div>

            <span class="px-3 py-1 text-xs rounded-full bg-indigo-50 text-indigo-600 font-medium">
                +5%
            </span>
        </div>

        <p class="text-sm text-gray-500 mt-5">
            Inorganic Waste
        </p>

        <h2 class="text-4xl font-bold text-gray-900 mt-1">
            {{ $inorganicCount }}
        </h2>

        <p class="text-xs text-gray-400 mt-2">
            {{ number_format($inorganicWeight,2) }} kg total
        </p>
    </div>

    {{-- Completed --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-start justify-between">
            <div class="w-12 h-12 rounded-2xl bg-green-50 flex items-center justify-center">
                ✅
            </div>

            <span class="px-3 py-1 text-xs rounded-full bg-green-50 text-green-600 font-medium">
                +15%
            </span>
        </div>

        <p class="text-sm text-gray-500 mt-5">
            Completed Processing
        </p>

        <h2 class="text-4xl font-bold text-gray-900 mt-1">
            {{ $completedCount }}
        </h2>

        <p class="text-xs text-gray-400 mt-2">
            {{ $completionRate }}% completion rate
        </p>
    </div>

</div>

{{-- Filter --}}
<div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 mb-6">

    <div class="flex items-center gap-2 mb-5">
        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                d="M3 4h18L14 12v7l-4-2v-5L3 4z"/>
        </svg>

        <h3 class="font-semibold text-gray-800">
            Filters
        </h3>
    </div>

    <form method="GET" action="{{ route('admin.wastes') }}">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">

            <div class="lg:col-span-4">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search by name, category, TPS..."
                    class="w-full h-12 rounded-xl border border-gray-200 px-4 focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>

            <div class="lg:col-span-2">
                <select
                    name="type"
                    class="w-full h-12 rounded-xl border border-gray-200 px-4">
                    <option value="">All Types</option>
                    <option value="organic" {{ request('type') == 'organic' ? 'selected' : '' }}>Organic</option>
                    <option value="inorganic" {{ request('type') == 'inorganic' ? 'selected' : '' }}>Inorganic</option>
                </select>
            </div>

            <div class="lg:col-span-2">
                <select
                    name="status"
                    class="w-full h-12 rounded-xl border border-gray-200 px-4">
                    <option value="">All Status</option>
                    <option value="Pending">Pending</option>
                    <option value="Diproses">Diproses</option>
                    <option value="Selesai">Selesai</option>
                    <option value="Dibatalkan">Dibatalkan</option>
                </select>
            </div>

            <div class="lg:col-span-2">
                <button
                    type="submit"
                    class="w-full h-12 rounded-xl bg-indigo-600 text-white font-medium hover:bg-indigo-700 transition">
                    Search
                </button>
            </div>

            <div class="lg:col-span-2">
                <a
                    href="{{ route('admin.wastes') }}"
                    class="w-full h-12 rounded-xl border border-gray-200 flex items-center justify-center hover:bg-gray-50 transition">
                    Reset
                </a>
            </div>

        </div>

    </form>

</div>

{{-- Data Table --}}
<div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">

    @if($wastes->count())

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-gray-50 border-b border-gray-100">

                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">User</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Category</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Weight</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">TPS</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase">Action</th>
                </tr>

            </thead>

            <tbody>

                @foreach($wastes as $waste)

                <tr class="border-b border-gray-50 hover:bg-gray-50 transition">

                    <td class="px-6 py-4">
                        {{ $waste->user->name ?? '-' }}
                    </td>

                    <td class="px-6 py-4 font-medium">
                        {{ $waste->name }}
                    </td>

                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-medium
                            {{ $waste->type == 'organic'
                            ? 'bg-green-100 text-green-700'
                            : 'bg-blue-100 text-blue-700' }}">
                            {{ ucfirst($waste->type) }}
                        </span>
                    </td>

                    <td class="px-6 py-4">
                        {{ $waste->category }}
                    </td>

                    <td class="px-6 py-4 font-semibold">
                        {{ number_format($waste->weight,2) }} kg
                    </td>

                    <td class="px-6 py-4">
                        {{ $waste->tps }}
                    </td>

                @php
                    $statusColors = [
                        'Pending' => 'bg-yellow-100 text-yellow-700',
                        'Diproses' => 'bg-blue-100 text-blue-700',
                        'Selesai' => 'bg-green-100 text-green-700',
                        'Dibatalkan' => 'bg-red-100 text-red-700',
                    ];
                @endphp

                <td class="px-6 py-4">
                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusColors[$waste->status] ?? 'bg-gray-100 text-gray-700' }}">
                        {{ $waste->status }}
                    </span>
                </td>

                <td class="px-6 py-4">
                    <div class="flex items-center justify-center gap-2">

                        <form method="POST" action="{{ route('admin.wastes.status', $waste) }}">
                            @csrf
                            @method('PUT')

                            <select
                                name="status"
                                onchange="this.form.submit()"
                                class="text-xs border border-gray-200 rounded-xl px-3 py-2 bg-white focus:ring-2 focus:ring-indigo-500">

                                <option value="Pending" {{ $waste->status == 'Pending' ? 'selected' : '' }}>
                                    Pending
                                </option>

                                <option value="Diproses" {{ $waste->status == 'Diproses' ? 'selected' : '' }}>
                                    Diproses
                                </option>

                                <option value="Selesai" {{ $waste->status == 'Selesai' ? 'selected' : '' }}>
                                    Selesai
                                </option>

                                <option value="Dibatalkan" {{ $waste->status == 'Dibatalkan' ? 'selected' : '' }}>
                                    Dibatalkan
                                </option>

                            </select>
                        </form>

                        <form
                            method="POST"
                            action="{{ route('admin.wastes.delete', $waste) }}"
                            onsubmit="return confirm('Yakin hapus data sampah ini?')">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="px-3 py-2 rounded-xl bg-red-50 text-red-600 text-xs font-medium hover:bg-red-100">
                                Hapus
                            </button>

                        </form>

                    </div>
                </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    <div class="p-6 border-t border-gray-100">
        {{ $wastes->links() }}
    </div>

    @else

    <div class="py-24 flex flex-col items-center">

        <div class="w-20 h-20 rounded-3xl bg-gray-100 flex items-center justify-center text-4xl">
            📦
        </div>

        <h3 class="text-2xl font-semibold text-gray-900 mt-6">
            No waste records found
        </h3>

        <p class="text-gray-500 mt-2">
            Try adjusting your filters or add new data.
        </p>

        <button class="mt-6 px-6 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700">
            Add New Record
        </button>

    </div>

    @endif

</div>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Brief visual feedback
        const msg = document.createElement('div');
        msg.className = 'fixed top-4 right-4 z-50 bg-green-600 text-white px-5 py-3 rounded-xl shadow-lg text-sm font-semibold';
        msg.textContent = '{{ session("success") }}';
        document.body.appendChild(msg);
        setTimeout(() => { msg.style.transition = 'opacity 0.5s'; msg.style.opacity = '0'; setTimeout(() => msg.remove(), 500); }, 2500);
    });
</script>
@endif

@endsection
