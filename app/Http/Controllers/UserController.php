<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Validator;

class UserController extends Controller
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
            'user'      => User::findOrFail(User::getCurrentUserId())
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
        $rules = [
            'username' => 'unique:users|required|max:30'
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
            'user'     => $this->createUser($request->all())
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

    protected function createUser(array $data)
    {
        return User::create([
            'username'          => $data['username'],
            'country'           => $data['country'],
            'show_to'           => null,
            'credit'            => 0,
            'followers_left'    => 0,
            'pro_user'          => false
        ]);
    }

    public function addCredit(Request $request){
        $credit = $request->get('credit');
        $user = User::find(User::getCurrentUserId());
        $user->credit = $user->credit + $credit;
        $user->save();

        return response()->json([
            'success'   =>  true,
            'message'   => "Successfully added credit",
            'user'     => $user
        ]);
    }

    public function makeProUser(){
        $user = User::find(User::getCurrentUserId());
        $user->setProUser(true);

        return response()->json([
            'success'   =>  true,
            'message'   => "Successful",
            'user'     => $user
        ]);
    }
}
