<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryRequest;
use App\Models\Item;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_items' => Item::count(),
            'total_requests' => InventoryRequest::count(),
            'pending_requests' => InventoryRequest::where('status', 'pending')->count(),
            'approved_today' => InventoryRequest::where('status', 'approved')
                ->whereDate('approved_at', today())
                ->count(),
        ];

        $recentRequests = InventoryRequest::with(['user', 'item'])
            ->latest()
            ->take(8)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentRequests'));
    }
}
