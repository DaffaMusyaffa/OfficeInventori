<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ItemController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->value();
        $category = $request->string('category')->trim()->value();

        $items = Item::query()
            ->when($search, fn ($q) => $q->where('name', 'like', "%{$search}%"))
            ->when($category, fn ($q) => $q->where('category', $category))
            ->orderBy('name')
            ->paginate(9)
            ->withQueryString();

        $categories = Item::query()->whereNotNull('category')->distinct()->orderBy('category')->pluck('category');

        return view('employee.items.index', compact('items', 'categories', 'search', 'category'));
    }
}
