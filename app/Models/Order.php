<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;
use App\Models\Product;
use App\Models\Lens;
use App\Models\Supplier;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['item_id', 'supplier_id', 'qty','order_id', 'price','amount', 'status', 'product_id'];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
    public function lens()
    {
        return $this->belongsTo(Lens::class, 'item_id');
    }
    public function user()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
