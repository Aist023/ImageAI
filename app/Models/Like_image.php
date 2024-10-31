<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like_image extends Model
{
    protected $table = 'like_image';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'image_id'];
}