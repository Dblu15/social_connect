<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    use HasFactory;

    protected $fillable = [
        'uuid',
        'post_id',
        'user_id',
        'content',
        'image'
    ];

    protected static function boot(){
        parent::boot();
        static::creating(function($model){
            $model->uuid = Str::uuid()->toString();
        });
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function post(){
        return $this->belongsTo(Post::class);
    }
}
