<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LensPower extends Model
{
    use HasFactory;
    protected $fillable = ['sph', 'syl', 'axis', 'add_'];
}
