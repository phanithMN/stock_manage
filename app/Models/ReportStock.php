<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportStock extends Model
{
    public $table = "report_stocks";
    protected $fillable = [
        'name', 
        'category_id', 
        'status_id', 
        'date'
    ];
}
