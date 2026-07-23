@extends('layouts.app')
@section('title', 'Riwayat Saya')
@section('heading', 'Riwayat Request Saya')

@section('content')
    <div class="mb-4 flex justify-end">
        <a href="{{ route('employee.requests.create') }}"
           class="inline-flex items-center gap-2 rounded-lg bg-brand-blue px-4 py-2 text-sm font-semibold text-white hover:bg-blue-600">
            @include('partials.icon', ['name' => 'plus', 'class' => 'h-4 w-4'])
            Buat Request
        </a>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="text-xs uppercase text-slate-400">
                    <tr class="border-b border-slate-100">
                        <th class="px-5 py-3 font-medium">ID</th>
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
                            <td class="px-5 py-3 text-slate-700">{{ $r->item->name }}</td>
                            <td class="px-5 py-3 text-slate-700">{{ $r->quantity }}</td>
                            <td class="px-5 py-3 max-w-[220px] truncate text-slate-500" title="{{ $r->purpose }}">{{ $r->purpose ?? '-' }}</td>
                            <td class="px-5 py-3">@include('partials.status', ['status' => $r->status])</td>
                            <td class="px-5 py-3 text-slate-500">{{ $r->created_at->format('d M Y H:i') }}</td>
                            <td class="px-5 py-3 text-right">
                                @if ($r->canBeReturned())
                                    <form method="POST" action="{{ route('employee.requests.return', $r) }}"
                                          @submit.prevent="$dispatch('confirm', { title: 'Ajukan Pengembalian', message: 'Kembalikan barang {{ $r->item->name }}? Pengajuan menunggu konfirmasi admin.', form: $el })">
                                        @csrf
                                        <button class="rounded-lg bg-sky-100 px-3 py-1.5 text-xs font-semibold text-sky-700 hover:bg-sky-200">Kembalikan</button>
                                    </form>
                                @elseif ($r->isReturnRequested())
                                    <span class="text-xs text-orange-500">Menunggu konfirmasi</span>
                                @else
                                    <span class="text-xs text-slate-300">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-5 py-8 text-center text-slate-400">Belum ada request.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-100 px-5 py-4">
            {{ $requests->links() }}
        </div>
    </div>
@endsection
