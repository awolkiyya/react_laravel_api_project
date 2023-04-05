<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commenter extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'profile',
    ];
    public function comment(){
        return $this->belongsTo(Comment::class);
    }
}
