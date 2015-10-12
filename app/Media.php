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
    protected $fillable = ['url', 'user_id', 'promoting'];

    protected $appends = ['owners_credit', 'publishable'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['owners_credit', 'created_at', 'updated_at', 'promoting', 'publishable'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }


    public function likes()
    {
        return $this->hasMany('App\Like');
    }


    public function getOwnersCreditAttribute()
    {
        return $this->user()->first()->credit;
    }

    public function getPublishableAttribute(){
        if($this->promoting){ //checks if the media is being promoted
            if($this->user_id != User::getCurrentUserId()){ //checks if owner and liker are same
                if($this->owners_credit>0){
                    //owner has credit

                    $user_id =  User::getCurrentUserId();

                    //check if media was already liked by current user and return as required.

                    return $this->likable();

                }
                else{
                    return false; //owner doesn't have credit, so not publishable
                }
            }
           return false;
        }
        return false;

    }

    public function likable(){
        $user_id =  User::getCurrentUserId();

        //Check if the media was already liked by the user
        $like = Like::where('media_id', $this->id)->where('user_id', $user_id)->first();

        return !(boolean)$like;
    }

    public function scopePromoting($query)
    {
        return $query->where('promoting', 1);
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
