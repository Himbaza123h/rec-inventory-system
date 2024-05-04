<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;
use App\Models\Customer;
use App\Models\CartItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use App\Models\Insurance;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = ['item_id','insurance_id', 'buyer_id', 'cart_id', 'seller_id','paypos','paymomo','paycash', 'product_id', 'item_quantity', 'payment_method'];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function insurance()
    {
        return $this->belongsTo(Insurance::class, 'insurance_id');
    } 

    public function lens()
    {
        return $this->belongsTo(Lens::class, 'item_id');
    }

    public function payment(){
        return $this->belongsTo(Payment::class, 'payment_method');  
    }

    public function user(){
        return $this->belongsTo(Seller::class, 'seller_id');  
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
