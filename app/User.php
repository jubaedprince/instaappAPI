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
    protected $fillable = ['username', 'credit', 'followers_left', 'pro_user', 'country', 'show_to'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [''];

    protected $appends = ['followable'];

    public function getFollowableAttribute(){

        if($this->followers_left>0){ //checks if the user has any follower left

            if($this->id != User::getCurrentUserId()) { //checks if owner and follower are same

                $user_id = User::getCurrentUserId();

                //check if media was already liked by current user and return as required.

                return $this->followable();
            }

            else{
                return false; //owner doesn't have credit, so not publishable
            }
        }
        return false;


    }

    public function followable(){
        $user_id =  User::getCurrentUserId();

        //Check if the user was already followed by the current user
        $follow = Follow::where('follow_id', $this->id)->where('user_id', $user_id)->first();

        //check if the user has any show_to

        if ($this->show_to == null){ //if show_to is null, that is can be shown to everybody.
            return !(boolean)$follow;
        }else if (User::find(User::getCurrentUserId())->country == $this->show_to){ //if user show to and current user are from same country
            return !(boolean)$follow;
        }else{
            return false;
        }

    }

    public static function filterFollowable($collection)
    {
        //only keeps the user that are followable
        $filtered = $collection->filter(function ($item) {
            return $item->followable == true;
        });
        return $filtered;
    }

    public static function getCurrentUserId(){
        return User::where('username', '=', Request::get('username'))->first()->id;
    }

    public function medias()
    {
        return $this->hasMany('App\Media');
    }

    public function likes()
    {
        return $this->hasMany('App\Like');
    }

    public function skips()
    {
        return $this->hasMany('App\Skip');
    }

    /**
     * User following relationship
     */
    public function follow()
    {
        return $this->belongsToMany('App\User', 'user_follows', 'user_id', 'follow_id');
    }

    /**
     * User followers relationship
     */
    public function followers()
    {
        return $this->belongsToMany('App\User', 'user_follows', 'follow_id', 'user_id');
    }

    public function decreaseCredit($creditToBeDecreased){
        if ($this->credit < $creditToBeDecreased){ //doesn't have sufficient credit
            return false;
        }
        $this->credit = $this->credit - $creditToBeDecreased;
        $this->save();
        return true;
    }

    public function setProUser($value){
        $this->pro_user = (boolean)$value;
        $this->save();
    }

}
