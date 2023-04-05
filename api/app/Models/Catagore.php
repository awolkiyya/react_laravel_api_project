<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Catagore extends Model
{
    use HasFactory;
    // this is the method that used to get all list of post related to this post catagore
    public function posts(){
        return $this->hasMany(Post::class);
    }
}
