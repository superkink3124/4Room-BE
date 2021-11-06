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
        return response()->json(['success' => true]);
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
        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id=null)
    {
        // Check if $id is NULL, (route: ../users/)
        if ($id === null) {
            return response()->json([
                'success' => true,
                'message' => 'Get all users in database',
                'user_info' => User::all()
            ]);
        }
        
        // If $id is not NULL (route: ../users/{id})
        if (User::find($id)) {
            return response()->json([
                'success' => true,
                'user_info' => User::find($id)
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Database does not have this user',
                'user_info' => []
            ]);
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
        return response()->json(['success' => true]);
    }

    /**
     * Search user by name_in_forum.
     *
     * @param  int  $email
     * @return \Illuminate\Http\Response
     */
    public function search($name) {
        // Get all users with name_in_forum LIKE $name
        $data = User::where("name_in_forum", "like", '%'.$name.'%')->get();
        // error_log($data);

        // Check if $data JSON is empty
        if (json_decode($data, true)) {
            return response()->json([
                'success' => true,
                'users_info' => User::where("name_in_forum", "like", '%'.$name.'%')->get(),
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'There are no users with name like this',
                'users_info' => []
            ]);
        }
    }
}
