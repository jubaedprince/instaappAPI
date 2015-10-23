<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $table = 'user_follows';

    protected $fillable = ['user_id', 'follow_id'];
}
