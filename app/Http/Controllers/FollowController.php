<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\Follow;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    /**
     * Display a list followings of specified user.
     *
     * @param int $user_id
     * @return UserCollection|JsonResponse
     */
    public function following(int $user_id)
    {
        try {
            $user = User::findOrFail($user_id);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Target user does not exist in database."], 400);
        }
        return new UserCollection($user->following);
    }

    /**
     * Display top 10 suggestion user
     */
    public function suggestion(Request $request)
    {
        $request_user = $request->user;
        $users = User::all();
        $candidate_users = [];
        foreach ($users as $user) {
            array_push($candidate_users, new UserResource($user));
        }
        usort($candidate_users, function($a, $b) {return $a->followers->count() < $b->followers->count();});
        $result = [];
        foreach ($candidate_users as $candidate_user) {
            if (count($result) == 10) {
                break;
            }
            if ($request_user->id == $candidate_user->id) {
                continue;
            }
            array_push($result, $candidate_user);
        }
        return response()->json([
            "success" => true,
            "data" => $result], 200);
    }

    /**
     * Display a list followers of specified user.
     *
     * @param int $user_id
     * @return UserCollection|JsonResponse
     */
    public function followers(int $user_id)
    {
        try {
            $user = User::findOrFail($user_id);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Target user does not exist in database."], 400);
        }
        return new UserCollection($user->followers);
    }

    /**
     * Store a new follow in database.
     *
     * @param Request $request
     * @param int $target_id
     * @return JsonResponse
     */
    public function store(Request $request, int $target_id): JsonResponse
    {
        $source_user = $request->user;
        try {
            $target_user = User::findOrFail($target_id);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Target user does not exist in database."], 400);
        }
        $follow = Follow::where("source_id", $source_user->id)
                        ->where("target_id", $target_user->id)
                        ->get();
        if (count($follow) > 0 || $source_user->id == $target_user->id) {
            return response()->json([
                "success" => false,
                "message" => "Source user already follow Target user."], 400);
        }
        $follow = Follow::create([
            "source_id" => $source_user->id,
            "target_id" => $target_user->id
        ]);
        NotificationController::update(Notification::where("follow_id", $follow->id)->first());
        return response()->json([
            "success" => true,
            "message" => "Followed."], 200);
    }

    /**
     * Remove follow from database.
     *
     * @param Request $request
     * @param int $target_id
     * @return JsonResponse
     */
    public function destroy(Request $request, int $target_id): JsonResponse
    {
        $source_user = $request->user;
        try {
            $target_user = User::findOrFail($target_id);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Target user does not exist in database."], 400);
        }
        try {
            $follow = Follow::where("source_id", $source_user->id)
                            ->where("target_id", $target_user->id)
                            ->firstOrFail();
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Source user did not follow Target user before."], 400);
        }
        $follow->delete();
        return response()->json([
            "success" => true,
            "message" => "Unfollow successful."], 200);
    }
}
