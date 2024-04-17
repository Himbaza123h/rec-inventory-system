<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable = ['supplier_name', 'supplier_tin_number', 'supplier_phone', 'supplier_email', 'supplier_work_place'];
}
