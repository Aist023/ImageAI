<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'image';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'prompt', 'ratio', 'date_time', 'visibility', 'token'];
}