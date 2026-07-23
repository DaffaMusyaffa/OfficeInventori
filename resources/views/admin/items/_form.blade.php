<div class="grid grid-cols-1 gap-5 md:grid-cols-2">
    <div class="md:col-span-2">
        <label class="mb-1.5 block text-sm font-medium text-slate-700">Nama Barang <span class="text-brand-red">*</span></label>
        <input type="text" name="name" value="{{ old('name', $item->name ?? '') }}" required
               class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm outline-none focus:border-brand-blue focus:ring-2 focus:ring-blue-100">
        @error('name') <p class="mt-1 text-xs text-brand-red">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-slate-700">Kategori</label>
        <input type="text" name="category" value="{{ old('category', $item->category ?? '') }}" list="categories"
               placeholder="Elektronik, ATK, ..."
               class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm outline-none focus:border-brand-blue focus:ring-2 focus:ring-blue-100">
        @error('category') <p class="mt-1 text-xs text-brand-red">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-slate-700">Lokasi</label>
        <input type="text" name="location" value="{{ old('location', $item->location ?? '') }}"
               placeholder="Gudang A"
               class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm outline-none focus:border-brand-blue focus:ring-2 focus:ring-blue-100">
        @error('location') <p class="mt-1 text-xs text-brand-red">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-slate-700">Stok <span class="text-brand-red">*</span></label>
        <input type="number" name="stock" min="0" value="{{ old('stock', $item->stock ?? 0) }}" required
               class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm outline-none focus:border-brand-blue focus:ring-2 focus:ring-blue-100">
        @error('stock') <p class="mt-1 text-xs text-brand-red">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="mb-1.5 block text-sm font-medium text-slate-700">Minimum Stok <span class="text-brand-red">*</span></label>
        <input type="number" name="minimum_stock" min="0" value="{{ old('minimum_stock', $item->minimum_stock ?? 0) }}" required
               class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm outline-none focus:border-brand-blue focus:ring-2 focus:ring-blue-100">
        @error('minimum_stock') <p class="mt-1 text-xs text-brand-red">{{ $message }}</p> @enderror
    </div>
</div>
