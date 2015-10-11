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


    public function getOwnersCreditAttribute()
    {
        return $this->user()->first()->credit;
    }

    public function getPublishableAttribute(){
        if($this->getOwnersCreditAttribute()){
            return true; //owner has credit, so publishable
        }
        else{
            return false; //owner doesn't have credit, so not publishable
        }
    }

    public function scopePromoting($query)
    {
        return $query->where('promoting', 1);
    }

    public function scopePublishable($query)
    {
        return DB::table('users')
            ->join('medias', 'medias.user_id', '=', 'users.id')
            ->where('medias.promoting', '=', true)
            ->where('users.credit', '>', '0');
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