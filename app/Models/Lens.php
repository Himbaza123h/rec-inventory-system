<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\LensPower;

class Lens extends Model
{
    use HasFactory;
    protected $fillable = ['mark_lens', 'lens_attribute', 'lens_power', 'price'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'mark_lens');
    }


    public function power()
    {
        return $this->belongsTo(LensPower::class, 'lens_power');
    }
    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'lens_attribute');
    }
}
