<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\LensPower;
use App\Models\Type;
use App\Models\Attribute;

class Lens extends Model
{
    use HasFactory;
    protected $fillable = ['mark_lens', 'item_type', 'lens_attribute', 'power_sph', 'power_cyl', 'power_axis', 'power_add', 'price'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'mark_lens');
    }



    public function type()
    {
        return $this->belongsTo(Type::class, 'item_type');
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
