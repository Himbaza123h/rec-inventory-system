<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;

class CartItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_id',
        'sale_code',
        'qty',
        'price',
        'user_id',
        'amount',
        'status',
    ];

    // Define the relationship with the Item model
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    
}
