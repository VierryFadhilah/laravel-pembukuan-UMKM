<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Roles extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];


    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
