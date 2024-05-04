<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;
use App\Models\Purchase;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = ['item_id', 'purchase_id', 'product_id', 'item_quantity','gone','remaining', 'status'];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }
}
