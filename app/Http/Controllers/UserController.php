<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        try {
            return new UserCollection(User::simplePaginate(15));
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Could not get all users profile"], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     */
    public function show(int $id)
    {
        try {
            return response()->json([
                "success" => true,
                "data" => new UserResource(User::findOrFail($id))], 200);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "User does not exist in database."], 400);
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
        try {
            $user = $request->user;
            $user->update($request->all());
            return response()->json([
                "success" => true,
                "message" => "Updated profile.",
                "user_info" => $user], 200);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Could not update profile.",
                "user_info" => $user], 400);
        }
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
     * @param $name
     * @return JsonResponse
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
