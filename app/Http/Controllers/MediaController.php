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

//Method1=not completed

//        $media = Media::with('user')->promoting()->get(); //eager loads the User
//
//        return $media;

//Method2

//        return Media::publishable()->get(); //returns joined array

//Method3

        $medias = Media::promoting()->get();
        return Media::filterPublishable($medias)->take(1); //returns Media collection
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'url' => 'unique:medias|required|url'
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
            'user'     => $this->createMedia($request->all())
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

    protected function createMedia(array $data){
        return Media::create([
            'url' => $data['url'],
            'user_id' => User::getCurrentUserId(),
            'promoting' => true
        ]);
    }
}
