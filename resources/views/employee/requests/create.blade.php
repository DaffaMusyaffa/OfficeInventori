@extends('layouts.app')
@section('title', 'Buat Request')
@section('heading', 'Buat Request Barang')

@section('content')
    <div class="mx-auto max-w-2xl rounded-xl border border-slate-200 bg-white p-6"
         x-data="{ items: {{ Illuminate\Support\Js::from($items->mapWithKeys(fn($i) => [$i->id => ['stock' => $i->stock, 'name' => $i->name]])) }}, selected: '{{ old('item_id', $selectedItem) }}' }">
        <form method="POST" action="{{ route('employee.requests.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="mb-1.5 block text-sm font-medium text-slate-700">Pilih Barang <span class="text-brand-red">*</span></label>
                <select name="item_id" x-model="selected" required
                        class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm outline-none focus:border-brand-blue focus:ring-2 focus:ring-blue-100">
                    <option value="">-- Pilih barang --</option>
                    @foreach ($items as $item)
                        <option value="{{ $item->id }}" @disabled($item->stock <= 0)>
                            {{ $item->name }} (Stok: {{ $item->stock }}){{ $item->stock <= 0 ? ' - Habis' : '' }}
                        </option>
                    @endforeach
                </select>
                @error('item_id') <p class="mt-1 text-xs text-brand-red">{{ $message }}</p> @enderror
                <p x-show="selected && items[selected]" x-cloak class="mt-1.5 text-xs text-slate-500">
                    Stok tersedia: <span class="font-semibold" x-text="selected ? items[selected]?.stock : ''"></span>
                </p>
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-medium text-slate-700">Jumlah <span class="text-brand-red">*</span></label>
                <input type="number" name="quantity" min="1" value="{{ old('quantity', 1) }}" required
                       :max="selected && items[selected] ? items[selected].stock : null"
                       class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm outline-none focus:border-brand-blue focus:ring-2 focus:ring-blue-100">
                @error('quantity') <p class="mt-1 text-xs text-brand-red">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-medium text-slate-700">Keperluan</label>
                <textarea name="purpose" rows="3" placeholder="Jelaskan keperluan penggunaan barang..."
                          class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm outline-none focus:border-brand-blue focus:ring-2 focus:ring-blue-100">{{ old('purpose') }}</textarea>
                @error('purpose') <p class="mt-1 text-xs text-brand-red">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('employee.requests.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Batal</a>
                <button class="rounded-lg bg-brand-blue px-5 py-2 text-sm font-semibold text-white hover:bg-blue-600">Submit Request</button>
            </div>
        </form>
    </div>
@endsection
