<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ItemController extends Controller
{
    public function index(Request $request): View
    {
        $query = Item::query();

        if ($search = $request->string('search')->trim()->value()) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('category', 'like', "%{$search}%");
        }

        if ($category = $request->string('category')->trim()->value()) {
            $query->where('category', $category);
        }

        $items = $query->latest()->paginate(10)->withQueryString();
        $categories = Item::query()->whereNotNull('category')->distinct()->orderBy('category')->pluck('category');

        return view('admin.items.index', compact('items', 'categories', 'search', 'category'));
    }

    public function create(): View
    {
        return view('admin.items.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateItem($request);

        Item::create($data);

        return redirect()->route('admin.items.index')
            ->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(Item $item): View
    {
        return view('admin.items.edit', compact('item'));
    }

    public function update(Request $request, Item $item): RedirectResponse
    {
        $data = $this->validateItem($request);

        $item->update($data);

        return redirect()->route('admin.items.index')
            ->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Item $item): RedirectResponse
    {
        $item->delete();

        return redirect()->route('admin.items.index')
            ->with('success', 'Barang berhasil dihapus.');
    }

    protected function validateItem(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'stock' => ['required', 'integer', 'min:0'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
            'location' => ['nullable', 'string', 'max:255'],
        ]);
    }
}
