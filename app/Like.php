<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likes';

    protected $fillable = ['media_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function media()
    {
        return $this->belongsTo('App\Media');
    }
}
