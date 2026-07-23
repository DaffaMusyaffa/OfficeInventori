<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'category', 'stock', 'minimum_stock', 'location'])]
class Item extends Model
{
    public function requests(): HasMany
    {
        return $this->hasMany(InventoryRequest::class);
    }

    /**
     * Whether current stock is at or below the minimum threshold.
     */
    public function isLowStock(): bool
    {
        return $this->stock <= $this->minimum_stock;
    }
}
