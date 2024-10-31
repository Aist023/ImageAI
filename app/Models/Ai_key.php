<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ai_key extends Model
{
    protected $table = 'ai_key';
    protected $primaryKey = 'id';
    protected $fillable = ['email', 'password', 'key', 'active'];
}