<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitOfMeasure extends Model
{
    public $table = "unit_of_measure";
    public $primaryKey = 'id';
    public $incrementing = true;
    public $timestamp = false;
}
