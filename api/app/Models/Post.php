<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    // this is the method used to get the catagore of the post which are belongs to
    public function catagore(){
        return $this->belongsTo(Catagore::class);
    }
    // this method used to get the user who are post the blogs
    public function user(){
        return $this->belongsTo(User::class);
    }
    // this is the method that used to get single post images
    public function image(){
        return $this->hasOne(Image::class);
    }
    // this is the method used to get all comments related to single posts
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    
}
