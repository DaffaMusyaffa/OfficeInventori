<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryRequest;
use Illuminate\View\View;

class HistoryController extends Controller
{
    public function index(): View
    {
        $requests = InventoryRequest::with(['user', 'item', 'approver'])
            ->whereIn('status', ['approved', 'rejected', 'returned'])
            ->latest('approved_at')
            ->paginate(15);

        return view('admin.history', compact('requests'));
    }
}
