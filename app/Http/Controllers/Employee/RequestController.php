<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\InventoryRequest;
use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RequestController extends Controller
{
    public function index(): View
    {
        $requests = InventoryRequest::with(['item', 'approver'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('employee.requests.index', compact('requests'));
    }

    public function create(Request $request): View
    {
        $items = Item::orderBy('name')->get();
        $selectedItem = $request->integer('item_id') ?: null;

        return view('employee.requests.create', compact('items', 'selectedItem'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'item_id' => ['required', 'exists:items,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'purpose' => ['nullable', 'string', 'max:1000'],
        ]);

        $item = Item::findOrFail($data['item_id']);

        if ($data['quantity'] > $item->stock) {
            return back()->withInput()
                ->withErrors(['quantity' => "Jumlah melebihi stok tersedia ({$item->stock})."]);
        }

        InventoryRequest::create([
            'user_id' => auth()->id(),
            'item_id' => $item->id,
            'quantity' => $data['quantity'],
            'purpose' => $data['purpose'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()->route('employee.requests.index')
            ->with('success', 'Request berhasil dibuat dan menunggu persetujuan admin.');
    }

    /**
     * Employee mengajukan pengembalian barang atas request yang sudah disetujui.
     */
    public function requestReturn(InventoryRequest $request): RedirectResponse
    {
        abort_unless($request->user_id === auth()->id(), 403);

        if (! $request->canBeReturned()) {
            return back()->with('error', 'Hanya request yang sudah disetujui yang bisa dikembalikan.');
        }

        $request->update([
            'status' => 'return_requested',
            'return_requested_at' => now(),
        ]);

        return back()->with('success', 'Pengajuan pengembalian dikirim, menunggu konfirmasi admin.');
    }
}
