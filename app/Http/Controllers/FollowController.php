<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Follow;
use App\Package;
use Validator;
class FollowController extends Controller
{
    /**
     * Display a list of 100 followable users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'success'   =>  true,
            'message'   => "Success. Followable users are:",
            'user'      => User::filterFollowable(User::all())->take(100)
        ]);

    }

    /**
     * Follows a user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::where('username', $request->username)->first();

        if(!$user){
            return response()->json([
                'success'   =>  false,
                'message'   => "No such user in our DB"
            ]);
        }

        if (!$user->followable){
            return response()->json([
                'success'   =>  false,
                'message'   => "You cannot follow this user"
            ]);
        }

        return response()->json([
            'success'   =>  true,
            'message'   => "Successfully followed",
            'like'      => Follow::create(['user_id' => User::getCurrentUserId(), 'follow_id' => $user->id])
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

    /**
     * Seeks for followers, activated by a package.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function seekFollower(Request $request)
    {
        $user = User::find(User::getCurrentUserId());
        //Check if the user is already under a campaign
        if ($user->followers_left > 0) {

            return response()->json([
                'success' => false,
                'message' => "Already under one campaign. Finish current campaign, then add credit."
            ]);

        }

        $rules = [
            'package_id'        => 'exists:packages,id'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return response()->json([
                'success'   =>  false,
                'message'   => "Failed",
                'error'     => $validator->errors()->all()
            ]);
        }

        //Check if the package is a Follow package.
        if(!Package::find($request->get('package_id'))->isFollowPackage()){
            return response()->json([ //Checks if the package is for Follow
                'success'   =>  false,
                'message'   => "Not a valid package. Use a Follow Package"
            ]);
        }

        $package = Package::find($request->package_id);
        //decrease credit
        if (User::find(User::getCurrentUserId())->decreaseCredit($package->cost)){
            //Add number of followers left
            $user->followers_left = $package->return;
            $user->save();

            return response()->json([
                'success'   => true,
                'message'   => "Successfully added number of requested followers",
                'user'      => User::find(User::getCurrentUserId())
            ]);
        }

        else{
            return response()->json([
                'success'   =>  false,
                'message'   => "Failed. Not enough credit"
            ]);
        }

    }
}
