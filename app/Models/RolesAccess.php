<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolesAccess extends Model
{
    use HasFactory;

    protected $table = 'roles_access';

    protected $fillable = [
        'roles_id',
        'access_id'
    ];
}
