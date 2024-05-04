<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lens;
use App\Models\PurchaseLens;

class StockLens extends Model
{
    use HasFactory;
    protected $fillable = ['item_id', 'purchase_id', 'item_quantity', 'gone', 'product_id', 'remaining', 'status'];

    public function item()
    {
        return $this->belongsTo(Lens::class, 'item_id');
    }

    public function purchase()
    {
        return $this->belongsTo(PurchaseLens::class, 'purchase_id');
    }
}
