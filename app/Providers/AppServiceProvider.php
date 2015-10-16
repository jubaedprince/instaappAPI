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
            // -1 like_left for media
            $media = Media::findOrFail($attribute->media_id);

            $media->likes_left = $media->likes_left - 1;

            $media->save();

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
