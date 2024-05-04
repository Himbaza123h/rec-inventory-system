<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Insurance;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = ['customer_name', 'customer_tin_number', 'customer_phone', 'customer_address', 'insurance_id'];



    public function insurance()
    {
        return $this->belongsTo(Insurance::class, 'insurance_id');
    }
}