<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\InventoryRequest;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $userId = auth()->id();

        $stats = [
            'total' => InventoryRequest::where('user_id', $userId)->count(),
            'pending' => InventoryRequest::where('user_id', $userId)->where('status', 'pending')->count(),
            'approved' => InventoryRequest::where('user_id', $userId)->where('status', 'approved')->count(),
            'rejected' => InventoryRequest::where('user_id', $userId)->where('status', 'rejected')->count(),
        ];

        $recentRequests = InventoryRequest::with('item')
            ->where('user_id', $userId)
            ->latest()
            ->take(8)
            ->get();

        return view('employee.dashboard', compact('stats', 'recentRequests'));
    }
}
