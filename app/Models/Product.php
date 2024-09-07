<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $table = "products";
    public $primaryKey = 'id';
    public $incrementing = true;
    public $timestamp = false;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }   

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function uom()
    {
        return $this->belongsTo(UnitOfMeasure::class);
    }
}
