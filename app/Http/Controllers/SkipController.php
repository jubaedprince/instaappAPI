<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Media;
use App\User;
use App\Like;
use App\Skip;

class SkipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Get the Media from given URL
        $media = Media::where('url', $request->url)->first();

        if(!$media){
            return response()->json([
                'success'   =>  false,
                'message'   => "No such media in our DB"
            ]);
        }

        if (!$media->publishable){
            return response()->json([
                'success'   =>  false,
                'message'   => "You cannot skip this media"
            ]);
        }

        return response()->json([
            'success'   =>  true,
            'message'   => "Successfully skipped",
            'skipped'   => Skip::create(['user_id' => User::getCurrentUserId(), 'media_id' => $media->id])
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
