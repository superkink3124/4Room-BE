<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
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
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $user = $request->user;
        $user->update($request->all());
        return response()->json(["success" => true, 'user_info' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id) : JsonResponse
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
