<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Lens;

class CartLens extends Model
{
    use HasFactory;
    protected $fillable = ['item_id', 'salelens_code', 'qty', 'price', 'amaunt', 'status'];

    public function lens()
    {
        return $this->belongsTo(Lens::class, 'item_id');
    }
}
