<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Code;
use App\Models\Color;
use App\Models\Type;

class Item extends Model
{
    use HasFactory;
    protected $fillable = ['target_client', 'mark_glasses', 'item_type', 'code_id', 'lens_width', 'bridge_width', 'temple_length', 'color_id', 'price'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'mark_glasses');
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'item_type');
    }

    public function code()
    {
        return $this->belongsTo(Code::class, 'code_id');
    }
    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
}
