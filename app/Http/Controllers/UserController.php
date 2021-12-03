<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\Follow;
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
            return new UserCollection(User::simplePaginate(10));
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
     * Display the specified user's profile.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $request_user = $request->user;
        try {
            $target_user = User::findOrFail($id);
            $follow = Follow::where("source_id", $request_user->id)
                            ->where("target_id", $target_user->id)
                            ->first();
            $is_follow = ($follow != null);
            return response()->json([
                "success" => true,
                "data" => new UserResource($target_user),
                "followed" => $is_follow], 200);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "User does not exist in database."], 400);
        }
    }

    public function getProfile(Request $request): JsonResponse
    {
        $user = $request->user;
        return response()->json([
            'success' => true,
            'data' => new UserResource($user)
        ]);
    }

    /**
     * Update user's profile.
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
                "data" => new UserResource($user)], 200);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Could not update profile."], 400);
        }
    }

    /**
     * Remove the specified user from database.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id) : JsonResponse
    {
        try {
            $user = User::findOrFail($id);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "User does not exist in database."], 400);
        }
        $user->delete();
        return response()->json([
            "success" => true,
            "message" => "Deleted user."], 200);
    }

    public function search(Request $request): JsonResponse
    {
        $name_in_forum = $request->name_in_forum;
        $data = User::where("name_in_forum", "like", '%'.$name_in_forum.'%')->limit(10)->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function change_avatar(Request $request): JsonResponse
    {
        $avatar_id = $request->input("avatar_id");
        try {
            User::where("id", $request->user->id)->update(['avatar_id' => $avatar_id]);
            return response()->json([
                'success' => true
            ]);
        } catch(Exception $ex) {
            return response()->json([
                'success' => false
            ], 400);
        }
    }
}
