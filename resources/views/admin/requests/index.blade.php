@extends('layouts.app')
@section('title', 'Request')
@section('heading', 'Kelola Request')

@section('content')
    @php
        $tabs = [
            '' => 'Semua',
            'pending' => 'Pending',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'return_requested' => 'Menunggu Retur',
            'returned' => 'Dikembalikan',
        ];
    @endphp

    <div class="mb-4 flex flex-wrap gap-2">
        @foreach ($tabs as $key => $label)
            <a href="{{ route('admin.requests.index', array_filter(['status' => $key])) }}"
               class="rounded-lg px-4 py-2 text-sm font-medium transition
                      {{ (string) $status === (string) $key ? 'bg-brand-blue text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <div class="rounded-xl border border-slate-200 bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="text-xs uppercase text-slate-400">
                    <tr class="border-b border-slate-100">
                        <th class="px-5 py-3 font-medium">ID</th>
                        <th class="px-5 py-3 font-medium">Requester</th>
                        <th class="px-5 py-3 font-medium">Barang</th>
                        <th class="px-5 py-3 font-medium">Jumlah</th>
                        <th class="px-5 py-3 font-medium">Keperluan</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium">Tanggal</th>
                        <th class="px-5 py-3 text-right font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($requests as $r)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3 font-medium text-slate-500">#{{ $r->id }}</td>
                            <td class="px-5 py-3 text-slate-700">{{ $r->user->name }}</td>
                            <td class="px-5 py-3 text-slate-700">{{ $r->item->name }}
                                <span class="block text-xs text-slate-400">Stok: {{ $r->item->stock }}</span>
                            </td>
                            <td class="px-5 py-3 text-slate-700">{{ $r->quantity }}</td>
                            <td class="px-5 py-3 max-w-[200px] truncate text-slate-500" title="{{ $r->purpose }}">{{ $r->purpose ?? '-' }}</td>
                            <td class="px-5 py-3">@include('partials.status', ['status' => $r->status])</td>
                            <td class="px-5 py-3 text-slate-500">{{ $r->created_at->format('d M Y H:i') }}</td>
                            <td class="px-5 py-3">
                                @if ($r->isPending())
                                    <div class="flex items-center justify-end gap-2">
                                        <form method="POST" action="{{ route('admin.requests.approve', $r) }}">
                                            @csrf
                                            <button class="rounded-lg bg-green-100 px-3 py-1.5 text-xs font-semibold text-green-700 hover:bg-green-200">Approve</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.requests.reject', $r) }}"
                                              @submit.prevent="$dispatch('confirm', { title: 'Tolak Request', message: 'Tolak request #{{ $r->id }} dari {{ $r->user->name }}?', danger: true, form: $el })">
                                            @csrf
                                            <button class="rounded-lg bg-red-100 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-200">Reject</button>
                                        </form>
                                    </div>
                                @elseif ($r->isReturnRequested())
                                    <div class="flex items-center justify-end gap-2">
                                        <form method="POST" action="{{ route('admin.requests.confirm-return', $r) }}"
                                              @submit.prevent="$dispatch('confirm', { title: 'Konfirmasi Pengembalian', message: 'Konfirmasi pengembalian {{ $r->item->name }}? Stok akan bertambah kembali sebanyak {{ $r->quantity }}.', form: $el })">
                                            @csrf
                                            <button class="rounded-lg bg-sky-100 px-3 py-1.5 text-xs font-semibold text-sky-700 hover:bg-sky-200">Konfirmasi Retur</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.requests.reject-return', $r) }}"
                                              @submit.prevent="$dispatch('confirm', { title: 'Tolak Pengembalian', message: 'Tolak pengajuan pengembalian ini? Status kembali ke Approved.', danger: true, form: $el })">
                                            @csrf
                                            <button class="rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600 hover:bg-slate-200">Tolak</button>
                                        </form>
                                    </div>
                                @elseif ($r->isReturned())
                                    <p class="text-right text-xs text-sky-500">Dikembalikan · {{ $r->returnConfirmer?->name ?? '-' }}</p>
                                @else
                                    <p class="text-right text-xs text-slate-400">
                                        oleh {{ $r->approver?->name ?? '-' }}
                                    </p>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="px-5 py-8 text-center text-slate-400">Tidak ada request.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-100 px-5 py-4">
            {{ $requests->links() }}
        </div>
    </div>
@endsection
