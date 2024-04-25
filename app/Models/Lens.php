<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Lens extends Model
{
    use HasFactory;
    protected $fillable = ['mark_lens', 'lens_attribute', 'lens_power', 'price'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'mark_lens');
    }
    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'lens_attribute');
    }
}
