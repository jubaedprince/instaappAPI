<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Package;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = $request->get('query');
        switch ($query){
            case 'like':
                return response()->json([
                    'success'   =>  true,
                    'message'   => "Success. Packages for Likes are displayed",
                    'packages'  => Package::likePackages()->get()
                ]);
            case 'follow':
                return response()->json([
                    'success'   =>  true,
                    'message'   => "Success. Packages for Follows are displayed",
                    'packages'  => Package::followPackages()->get()
                ]);
        }
        return response()->json([
            'success'   =>  true,
            'message'   => "Success. All packages are displayed",
            'packages'  => Package::all()
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
        //
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
