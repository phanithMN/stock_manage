<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    public $table = "users_info";
    public $primaryKey = 'id';
    public $incrementing = true;
    public $timestamp = false;
}
