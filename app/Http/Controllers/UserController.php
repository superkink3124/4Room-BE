<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id=null)
    {
        // return $id? User::find($id) : User::all();

        if ($id === null) {
            return User::all();
        }
        // if (User::where("id", $id)) {
        if (User::find($id)) {
            return User::where('id', $id)->get();
        } else {
            return response()->json([]);
        }  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // return $request->all();
        // error_log($request->input("facebook_link"));
        $user = $request->user;
        // $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json(["success" => true]);
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
     * Search user by name_in_forum.
     *
     * @param  int  $email
     * @return \Illuminate\Http\Response
     */
    public function search($name) {
        return User::where("name_in_forum", "like", '%'.$name.'%')->get();

        // $user = DB::select(SELECT * FROM `users` 
        //     WHERE MATCH(description) AGAINST($name IN NATURAL LANGUAGE MODE));
        
    }
}