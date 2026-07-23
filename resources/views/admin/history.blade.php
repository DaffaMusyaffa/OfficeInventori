@extends('layouts.app')
@section('title', 'Riwayat')
@section('heading', 'Riwayat Request')

@section('content')
    <div class="rounded-xl border border-slate-200 bg-white">
        <div class="border-b border-slate-100 px-5 py-4">
            <h2 class="text-base font-semibold text-slate-800">Semua Request yang Sudah Diproses</h2>
            <p class="text-sm text-slate-400">Request dengan status approved atau rejected.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="text-xs uppercase text-slate-400">
                    <tr class="border-b border-slate-100">
                        <th class="px-5 py-3 font-medium">ID</th>
                        <th class="px-5 py-3 font-medium">Requester</th>
                        <th class="px-5 py-3 font-medium">Barang</th>
                        <th class="px-5 py-3 font-medium">Jumlah</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium">Diproses Oleh</th>
                        <th class="px-5 py-3 font-medium">Tanggal Proses</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($requests as $r)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3 font-medium text-slate-500">#{{ $r->id }}</td>
                            <td class="px-5 py-3 text-slate-700">{{ $r->user->name }}</td>
                            <td class="px-5 py-3 text-slate-700">{{ $r->item->name }}</td>
                            <td class="px-5 py-3 text-slate-700">{{ $r->quantity }}</td>
                            <td class="px-5 py-3">@include('partials.status', ['status' => $r->status])</td>
                            <td class="px-5 py-3 text-slate-600">{{ $r->approver?->name ?? '-' }}</td>
                            <td class="px-5 py-3 text-slate-500">{{ $r->approved_at?->format('d M Y H:i') ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-5 py-8 text-center text-slate-400">Belum ada riwayat.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-100 px-5 py-4">
            {{ $requests->links() }}
        </div>
    </div>
@endsection
