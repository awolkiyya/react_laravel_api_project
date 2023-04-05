<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_id',
        'message',
        'name',
        'email',
        'profile',
    ];
    // this is the method used to gate the post related to specific comments
    public function post(){
        return $this->belongsTo(Post::class);
    }
    public function commenter(){
        return $this->hasOne(Commenter::class);
    }
}
