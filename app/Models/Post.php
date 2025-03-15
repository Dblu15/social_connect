<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'uuid',
        'user_id',
        'content',
        'image',
        'privacy',
        'status'
    ];

    protected static function boot(){
        parent::boot();
        static::creating(function($model){
            $model->uuid = Str::uuid()->toString();
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
