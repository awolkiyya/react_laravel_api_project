<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
      // this method used to get the user who are post the blogs
      public function post(){
        return $this->belongsTo(Post::class);
    }
}
