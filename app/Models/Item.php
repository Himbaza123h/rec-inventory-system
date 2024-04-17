<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Item extends Model
{
    use HasFactory;
protected $fillable = ['target_client', 'mark_glasses', 'code', 'lens_width', 'bridge_width', 'temple_length', 'color', 'price'];


    public function category()
    {
        return $this->belongsTo(Category::class, 'mark_glasses');
    }
}
