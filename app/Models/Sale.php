<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;
use App\Models\Customer;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = ['item_id', 'buyer_id', 'cart_id', 'seller_id', 'product_id', 'item_quantity', 'payment_method'];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }


    public function lens()
    {
        return $this->belongsTo(Lens::class, 'item_id');
    }


    public function user(){
        return $this->belongsTo(User::class, 'seller_id');  
    }
    public function buyer()
    {
        return $this->belongsTo(Customer::class, 'buyer_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function cart()
    {
        return $this->belongsTo(CartItem::class, 'cart_id');
    }

    public function getTotalAttribute()
    {
        return $this->price * $this->qty;
    }
}
