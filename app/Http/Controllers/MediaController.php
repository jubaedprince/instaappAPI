<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use App\Media;
use App\User;
use DB;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'success'   =>  true,
            'message'   => "Success",
            'media'      => Media::filterPublishable(Media::all())->take(100)  //returns Media collection
        ]);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $media = Media::where('url', $request->url)->first();
        if ($media==null){ //no media with same URL was stored before
            $rules = [
                'url'               => 'unique:medias|required|url',
                'likes_required'    => 'integer'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                return response()->json([
                    'success'   =>  false,
                    'message'   => "Failed",
                    'error'     => $validator->errors()->all()
                ]);
            }

            return response()->json([
                'success'   =>  true,
                'message'   => "Success",
                'media'     => $this->createMedia($request->all())
            ]);
        }
        if ($media->likes_left == 0){ //add number of required likes if current like left is 0
            $media->likes_left = $media->likes_left + $request->likes_required;
            $media->save();

            return response()->json([
                'success'   =>  true,
                'message'   => "Successfully added number of required likes",
                'media'     => $media
            ]);
        }
        else{
            return response()->json([ //Dont do anything if current like left is not 0
                'success'   =>  false,
                'message'   => "Already under one campaign. Finish current campaign, then add credit."
            ]);
        }


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

    protected function createMedia(array $data){
        return Media::create([
            'url'        => $data['url'],
            'user_id'    => User::getCurrentUserId(),
            'likes_left' => $data['likes_required']
        ]);
    }
}
