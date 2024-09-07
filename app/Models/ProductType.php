<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    public $table = "product_type";
    public $primaryKey = 'id';
    public $incrementing = true;
    public $timestamp = false;
}
