<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'uuid',
        'post_id',
        'user_id',
        'content',
    ];
}
