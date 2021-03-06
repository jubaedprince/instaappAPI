<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Media extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'medias';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['url', 'user_id', 'likes_left', 'show_to'];

    protected $appends = ['publishable'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at', 'publishable'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }


    public function likes()
    {
        return $this->hasMany('App\Like');
    }

    public function skips()
    {
        return $this->hasMany('App\Skip');
    }

    public function getPublishableAttribute(){
        if ($this->skipped()){
            return false;
        }

        if ($this->show_to != null){
            //if show_to is null, that is cannot be shown to everybody.
            if (User::find(User::getCurrentUserId())->country != $this->show_to){
                return false;
            }
        }

        if($this->likes_left>0){ //checks if the media has any like left

            if($this->user_id != User::getCurrentUserId()) { //checks if owner and liker are same

                $user_id = User::getCurrentUserId();

                //check if media was already liked by current user and return as required.

                return $this->likable();
            }

            else{
                return false; //owner doesn't have credit, so not publishable
            }
        }
        return false;


    }

    public function skipped(){
        $user_id =  User::getCurrentUserId();

        //Check if the media was already skipped by the user
        $skip = Skip::where('media_id', $this->id)->where('user_id', $user_id)->first();

        return (boolean)$skip;
    }

    public function likable(){
        $user_id =  User::getCurrentUserId();

        //Check if the media was already liked by the user
        $like = Like::where('media_id', $this->id)->where('user_id', $user_id)->first();

        return !(boolean)$like;
    }

    public static function filterPublishable($collection)
    {
        //only keeps the media that are publishable that is, User has credit
        $filtered = $collection->filter(function ($item) {
            return $item->publishable == true;
        });
        return $filtered;
    }

}
