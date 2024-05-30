<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlacedOrder extends Model
{
    use HasFactory;

    protected $table = 'placed_orders';

    protected $fillable = [
        'order_code',
        'operator_id',
        'buyer_id',
        'insurance_percentage',
        'ticket_moderateur',
        'top_up_amount',
        'totalAmount',
        'type',
        'payment_method_pos',
        'payment_method_momo',
        'payment_method_cash',
        'created_at',
        'updated_at',
    ];

    public function operator() {
        return $this->belongsTo(Seller::class, 'operator_id');
    }

    public function buyer() {
        return $this->belongsTo(Customer::class, 'buyer_id');
    }
}
