@extends('layouts.app')
@section('title', 'Barang')
@section('heading', 'Kelola Barang')

@section('content')
    <div class="rounded-xl border border-slate-200 bg-white">
        <div class="flex flex-col gap-3 border-b border-slate-100 p-5 sm:flex-row sm:items-center sm:justify-between">
            <form method="GET" class="flex flex-1 flex-wrap items-center gap-2">
                <div class="relative flex-1 min-w-[180px]">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        @include('partials.icon', ['name' => 'search', 'class' => 'h-4 w-4'])
                    </span>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari barang..."
                           class="w-full rounded-lg border border-slate-300 py-2 pl-9 pr-3 text-sm outline-none focus:border-brand-blue focus:ring-2 focus:ring-blue-100">
                </div>
                <select name="category" onchange="this.form.submit()"
                        class="rounded-lg border border-slate-300 py-2 pl-3 pr-8 text-sm outline-none focus:border-brand-blue">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat }}" @selected($category === $cat)>{{ $cat }}</option>
                    @endforeach
                </select>
                <button class="rounded-lg bg-slate-100 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-200">Cari</button>
            </form>
            <a href="{{ route('admin.items.create') }}"
               class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-blue px-4 py-2 text-sm font-semibold text-white hover:bg-blue-600">
                @include('partials.icon', ['name' => 'plus', 'class' => 'h-4 w-4'])
                Tambah Barang
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="text-xs uppercase text-slate-400">
                    <tr class="border-b border-slate-100">
                        <th class="px-5 py-3 font-medium">Nama</th>
                        <th class="px-5 py-3 font-medium">Kategori</th>
                        <th class="px-5 py-3 font-medium">Stok</th>
                        <th class="px-5 py-3 font-medium">Min. Stok</th>
                        <th class="px-5 py-3 font-medium">Lokasi</th>
                        <th class="px-5 py-3 text-right font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($items as $item)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-3 font-medium text-slate-800">{{ $item->name }}</td>
                            <td class="px-5 py-3 text-slate-600">{{ $item->category ?? '-' }}</td>
                            <td class="px-5 py-3">
                                <span class="font-semibold {{ $item->isLowStock() ? 'text-brand-red' : 'text-slate-700' }}">{{ $item->stock }}</span>
                                @if ($item->isLowStock())
                                    <span class="ml-1 rounded bg-red-50 px-1.5 py-0.5 text-[10px] font-medium text-brand-red">Low</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-slate-600">{{ $item->minimum_stock }}</td>
                            <td class="px-5 py-3 text-slate-600">{{ $item->location ?? '-' }}</td>
                            <td class="px-5 py-3">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.items.edit', $item) }}"
                                       class="rounded-lg p-2 text-slate-400 hover:bg-slate-100 hover:text-brand-blue" title="Edit">
                                        @include('partials.icon', ['name' => 'edit', 'class' => 'h-4 w-4'])
                                    </a>
                                    <form method="POST" action="{{ route('admin.items.destroy', $item) }}"
                                          @submit.prevent="$dispatch('confirm', { title: 'Hapus Barang', message: 'Yakin hapus barang {{ $item->name }}? Tindakan ini tidak dapat dibatalkan.', danger: true, form: $el })">
                                        @csrf @method('DELETE')
                                        <button class="rounded-lg p-2 text-slate-400 hover:bg-slate-100 hover:text-brand-red" title="Hapus">
                                            @include('partials.icon', ['name' => 'trash', 'class' => 'h-4 w-4'])
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-8 text-center text-slate-400">Tidak ada barang.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-slate-100 px-5 py-4">
            {{ $items->links() }}
        </div>
    </div>
@endsection
