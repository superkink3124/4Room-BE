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
                'message' => "Successful operation.",
                "data" => new UserResource($target_user),
                "followed" => $is_follow], 200);
        } catch (Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "User does not exist in database."], 404);
        }
    }

    public function getProfile(Request $request): JsonResponse
    {
        $user = $request->user;
        return response()->json([
            'success' => true,
            'message' => "Successful operation.",
            'data' => new UserResource($user)
        ]);
    }

    /**
     * Update user's profile.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $input = $request->except(['password', 'id', 'role', 'email', 'created_at', 'updated_at']);
        try {
            $user = $request->user;
            $user->update($input);
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

    public function search(Request $request): UserCollection
    {
        $key_search = $request->query("name");
        $data = User::where("name_in_forum", "like", '%'.$key_search.'%')
                    ->limit(10)->get();
        if (str_contains($key_search, '@') || sizeof($data) == 0) {
            $data = User::where("email", "like", '%'.$key_search.'%')
                ->limit(10)->get();
        }
        return new UserCollection($data);
    }

    public function change_avatar(Request $request): JsonResponse
    {
        if($request->file("avatar") !== null && $request->file("avatar")->isValid()) {
            try {
                $avatar = $request->file("avatar");
                $path = $avatar->store("public/avatar");
                $arr = explode("/", $path);
                $file_name = $arr[count($arr) - 1];
                User::where("id", $request->user->id)->update(['avatar_id' => $file_name]);
                return response()->json([
                    'success' => true,
                    'message' => "Changed avatar.",
                    'data' => new UserResource(User::where("id", $request->user->id)->firstOrFail())
                ]);
            }
            catch(Exception $ex) {
                return response()->json([
                    'success' => false,
                    'message' => "Invalid input."
                ], 400);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => "Invalid input."
            ], 400);
        }
    }
}
