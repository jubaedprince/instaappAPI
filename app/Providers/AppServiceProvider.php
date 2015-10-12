<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Like;
use App\User;
use App\Media;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Like::creating(function ($attribute) {
            // -1 credit for owner of media
            $user = User::findOrFail(Media::findOrFail($attribute->media_id)->user_id);

            $user->credit = $user->credit - 1;

            $user->save();

            // +1 credit for liker of media
            $user = User::findOrFail($attribute->user_id);

            $user->credit = $user->credit + 1;

            $user->save();

        });


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
