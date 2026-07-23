@extends('layouts.app')
@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@section('content')
    @php
        $cards = [
            ['label' => 'TOTAL REQUEST SAYA', 'value' => $stats['total'], 'sub' => 'Semua request', 'icon' => 'inbox', 'color' => 'bg-blue-100 text-brand-blue'],
            ['label' => 'PENDING', 'value' => $stats['pending'], 'sub' => 'Menunggu persetujuan', 'icon' => 'clock', 'color' => 'bg-purple-100 text-brand-purple'],
            ['label' => 'APPROVED', 'value' => $stats['approved'], 'sub' => 'Disetujui', 'icon' => 'check', 'color' => 'bg-green-100 text-brand-green'],
            ['label' => 'REJECTED', 'value' => $stats['rejected'], 'sub' => 'Ditolak', 'icon' => 'x', 'color' => 'bg-red-100 text-brand-red'],
        ];
    @endphp

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ($cards as $c)
            <div class="rounded-xl border border-slate-200 bg-white p-5">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold tracking-wide text-slate-400">{{ $c['label'] }}</p>
                        <p class="mt-2 text-3xl font-bold text-slate-800">{{ $c['value'] }}</p>
                        <p class="mt-1 text-xs text-slate-400">{{ $c['sub'] }}</p>
                    </div>
                    <div class="flex h-11 w-11 items-center justify-center rounded-lg {{ $c['color'] }}">
                        @include('partials.icon', ['name' => $c['icon'], 'class' => 'h-6 w-6'])
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6 rounded-xl border border-slate-200 bg-white">
        <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
            <h2 class="text-base font-semibold text-slate-800">Riwayat Request Saya</h2>
            <a href="{{ route('employee.requests.create') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-brand-blue px-3 py-1.5 text-sm font-semibold text-white hover:bg-blue-600">
                @include('partials.icon', ['name' => 'plus', 'class' => 'h-4 w-4'])
                Buat Request
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="text-xs uppercase text-slate-400">
                    <tr class="border-b border-slate-100">
                        <th class="px-5 py-3 font-medium">ID</th>
                        <th class="px-5 py-3 font-medium">Barang</th>
                        <th class="px-5 py-3 font-medium">Jumlah</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($recentRequests as $r)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3 font-medium text-slate-500">#{{ $r->id }}</td>
                            <td class="px-5 py-3 text-slate-700">{{ $r->item->name }}</td>
                            <td class="px-5 py-3 text-slate-700">{{ $r->quantity }}</td>
                            <td class="px-5 py-3">@include('partials.status', ['status' => $r->status])</td>
                            <td class="px-5 py-3 text-slate-500">{{ $r->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-8 text-center text-slate-400">Belum ada request. <a href="{{ route('employee.requests.create') }}" class="text-brand-blue hover:underline">Buat sekarang</a></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
