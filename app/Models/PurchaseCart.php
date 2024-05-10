<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;
use App\Models\Lens;
use App\Models\Supplier;
use App\Models\Product;
class PurchaseCart extends Model
{
    use HasFactory;
    protected $fillable = ['item_id', 'supplier_id', 'order_number', 'product_id', 'quantity', 'price', 'amount', 'status', 'created_at', 'updated_at'];


    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function lens()
    {
        return $this->belongsTo(Lens::class, 'item_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
