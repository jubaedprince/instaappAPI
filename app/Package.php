<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $table = 'packages';

    protected $fillable = ['name', 'cost', 'type', 'return'];
    //type=1 --> follow
    //type=2 --> like
    //return -->number of like or follow

    public function scopeLikePackages($query)
    {
        return $query->where('type', 2);
    }

    public function scopeFollowPackages($query)
    {
        return $query->where('type', 1);
    }

    public function isFollowPackage()
    {
        return $this->type==1;
    }

    public function isLikePackage()
    {
        return $this->type==2;
    }

}
