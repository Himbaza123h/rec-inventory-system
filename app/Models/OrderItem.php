<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lens;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = ['item_id', 'seller_id', 'order_code', 'quantity', 'amount', 'insurance_id', 'insurance_number', 'amount_covered', 'amount_payed', 'amount_remaining', 'status', 'customer_id'];

    public function item()
    {
        return $this->belongsTo(Lens::class, 'item_id');
    }
}
