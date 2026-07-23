<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RequestController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->string('status')->trim()->value();

        $requests = InventoryRequest::with(['user', 'item', 'approver'])
            ->when(in_array($status, ['pending', 'approved', 'rejected', 'return_requested', 'returned']), fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.requests.index', compact('requests', 'status'));
    }

    /**
     * Approve a pending request and decrement item stock.
     */
    public function approve(InventoryRequest $request): RedirectResponse
    {
        if (! $request->isPending()) {
            return back()->with('error', 'Request ini sudah diproses.');
        }

        $item = $request->item;

        if ($item->stock < $request->quantity) {
            return back()->with('error', "Stok {$item->name} tidak mencukupi (tersisa {$item->stock}).");
        }

        DB::transaction(function () use ($request, $item) {
            $item->decrement('stock', $request->quantity);

            $request->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);
        });

        return back()->with('success', 'Request disetujui dan stok diperbarui.');
    }

    public function reject(InventoryRequest $request): RedirectResponse
    {
        if (! $request->isPending()) {
            return back()->with('error', 'Request ini sudah diproses.');
        }

        $request->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Request ditolak.');
    }

    /**
     * Konfirmasi pengembalian barang: stok dikembalikan (ditambah kembali).
     */
    public function confirmReturn(InventoryRequest $request): RedirectResponse
    {
        if (! $request->isReturnRequested()) {
            return back()->with('error', 'Tidak ada pengajuan pengembalian untuk request ini.');
        }

        DB::transaction(function () use ($request) {
            $request->item->increment('stock', $request->quantity);

            $request->update([
                'status' => 'returned',
                'returned_by' => auth()->id(),
                'returned_at' => now(),
            ]);
        });

        return back()->with('success', 'Pengembalian dikonfirmasi dan stok diperbarui.');
    }

    /**
     * Tolak pengajuan pengembalian: kembalikan status ke approved (stok tetap keluar).
     */
    public function rejectReturn(InventoryRequest $request): RedirectResponse
    {
        if (! $request->isReturnRequested()) {
            return back()->with('error', 'Tidak ada pengajuan pengembalian untuk request ini.');
        }

        $request->update([
            'status' => 'approved',
            'return_requested_at' => null,
        ]);

        return back()->with('success', 'Pengajuan pengembalian ditolak.');
    }
}
