<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Represents a stock request. Maps to the "requests" table.
 */
#[Fillable([
    'user_id', 'item_id', 'quantity', 'purpose', 'status',
    'approved_by', 'approved_at', 'return_requested_at', 'returned_at', 'returned_by',
])]
class InventoryRequest extends Model
{
    protected $table = 'requests';

    protected function casts(): array
    {
        return [
            'approved_at' => 'datetime',
            'return_requested_at' => 'datetime',
            'returned_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function returnConfirmer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'returned_by');
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isReturnRequested(): bool
    {
        return $this->status === 'return_requested';
    }

    public function isReturned(): bool
    {
        return $this->status === 'returned';
    }

    /**
     * An approved request whose stock is still "out" can be returned.
     */
    public function canBeReturned(): bool
    {
        return $this->status === 'approved';
    }
}
