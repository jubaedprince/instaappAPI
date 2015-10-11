<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Request;
class User extends Model{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'credit', 'profile_url', 'promoting'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [''];

    public static function getCurrentUserId(){
        return User::where('username', '=', Request::get('username'))->first()->id;
    }

    public function medias()
    {
        return $this->hasMany('App\Media');
    }

}
