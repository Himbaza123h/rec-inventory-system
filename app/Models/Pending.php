<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;
use App\Models\Lens;
use App\Models\Customer;
use App\Models\Insurance;

class Pending extends Model
{
    use HasFactory;
    protected $fillable = ['item_id', 'covered', 'buyer_id', 'cart_id', 'seller_id', 'product_id', 'item_quantity', 'amount', 'insurance_id'];

    public function buyer()
    {
        return $this->belongsTo(Customer::class, 'buyer_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function lens()
    {
        return $this->belongsTo(Lens::class, 'item_id');
    }

    public function insurance()
    {
        return $this->belongsTo(Insurance::class, 'insurance_id');
    }
}
