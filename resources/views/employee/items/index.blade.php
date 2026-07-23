@extends('layouts.app')
@section('title', 'Daftar Barang')
@section('heading', 'Daftar Barang')

@section('content')
    <form method="GET" class="mb-5 flex flex-wrap items-center gap-2">
        <div class="relative flex-1 min-w-[200px]">
            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                @include('partials.icon', ['name' => 'search', 'class' => 'h-4 w-4'])
            </span>
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari barang..."
                   class="w-full rounded-lg border border-slate-300 bg-white py-2.5 pl-9 pr-3 text-sm outline-none focus:border-brand-blue focus:ring-2 focus:ring-blue-100">
        </div>
        <select name="category" onchange="this.form.submit()"
                class="rounded-lg border border-slate-300 bg-white py-2.5 pl-3 pr-8 text-sm outline-none focus:border-brand-blue">
            <option value="">Semua Kategori</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat }}" @selected($category === $cat)>{{ $cat }}</option>
            @endforeach
        </select>
        <button class="rounded-lg bg-brand-blue px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-600">Cari</button>
    </form>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
        @forelse ($items as $item)
            <div class="flex flex-col rounded-xl border border-slate-200 bg-white p-5">
                <div class="flex items-start gap-3">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-500">
                        @include('partials.icon', ['name' => 'box-solid', 'class' => 'h-6 w-6'])
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="truncate font-semibold text-slate-800">{{ $item->name }}</h3>
                        <p class="text-xs text-slate-400">{{ $item->category ?? 'Tanpa kategori' }} · {{ $item->location ?? '-' }}</p>
                    </div>
                </div>

                <div class="mt-4 flex items-center gap-4 text-sm">
                    <div>
                        <span class="text-slate-400">Stok:</span>
                        <span class="font-semibold {{ $item->isLowStock() ? 'text-brand-red' : 'text-slate-700' }}">{{ $item->stock }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400">Minimum:</span>
                        <span class="font-semibold text-slate-700">{{ $item->minimum_stock }}</span>
                    </div>
                </div>

                <div class="mt-4">
                    @if ($item->stock > 0)
                        <a href="{{ route('employee.requests.create', ['item_id' => $item->id]) }}"
                           class="block w-full rounded-lg bg-brand-blue py-2 text-center text-sm font-semibold text-white hover:bg-blue-600">
                            Request
                        </a>
                    @else
                        <span class="block w-full rounded-lg bg-slate-100 py-2 text-center text-sm font-semibold text-slate-400">Stok Habis</span>
                    @endif
                </div>
            </div>
        @empty
            <p class="col-span-full py-8 text-center text-slate-400">Tidak ada barang ditemukan.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $items->links() }}</div>
@endsection
