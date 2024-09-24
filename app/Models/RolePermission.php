<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;

    public $table = "role_permissions";
    public $primaryKey = 'id';
    public $incrementing = true;
    public $timestamp = false;
}
