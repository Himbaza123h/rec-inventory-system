<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = ['item_id', 'purchase_code', 'qty', 'price','amount', 'status','supplier','payment_method','created_at'];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
