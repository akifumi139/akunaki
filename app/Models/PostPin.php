<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostPin extends Model
{
    use HasFactory;

    const CREATED_AT = null;

    protected $fillable = [
        'user_id',
        'status'
    ];
}
