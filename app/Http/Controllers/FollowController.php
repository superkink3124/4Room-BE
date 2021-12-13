<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\Follow;
use App\Models\Notification;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Reference;

class FollowController extends Controller
{
    /**
     * List followings of specified user.
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
                "message" => "Target user does not exist in database."], 404);
        }
        return new UserCollection($user->following);
    }

    /**
     * Top 10 suggestion users = Random 3 in 50 users that has most followers + Random 7 in 200 friends of followings
     */
    public function suggestion(Request $request): UserCollection
    {
        $result_ids = [];
        $request_user = $request->user;
        // Random 7 friends of followings
        $candidate_users = [];
        $following =$request_user->following;
        foreach ($following as $following_user) {
            $following_following =$following_user->following;
            foreach ($following_following as $following_following_user) {
                array_push($candidate_users, new UserResource($following_following_user));
            }
            if (count($candidate_users) > 200) {
                break;
            }
        }
        shuffle($candidate_users);
        foreach ($candidate_users as $candidate_user) {
            if (count($result_ids) == 7) {
                break;
            }
            if ($request_user->id == $candidate_user->id || in_array($candidate_user->id, $result_ids)) {
                continue;
            }
            $follow = Follow::where("source_id", $request_user->id)
                ->where("target_id", $candidate_user->id)
                ->first();
            if ($follow != null) {
                continue;
            }
            array_push($result_ids, $candidate_user->id);
        }
        // Top 3 users that has most followers
        $users = User::all();
        $candidate_users = [];
        foreach ($users as $user) {
            array_push($candidate_users, new UserResource($user));
        }
        usort($candidate_users, function($a, $b) {return $a->followers->count() < $b->followers->count();});
        $candidate_users = array_slice($candidate_users, 0, 50);
        shuffle($candidate_users);
        foreach ($candidate_users as $candidate_user) {
            if (count($result_ids) == 10) {
                break;
            }
            if ($request_user->id == $candidate_user->id || in_array($candidate_user->id, $result_ids)) {
                continue;
            }
            $follow = Follow::where("source_id", $request_user->id)
                            ->where("target_id", $candidate_user->id)
                            ->first();
            if ($follow != null) {
                continue;
            }
            array_push($result_ids, $candidate_user->id);
        }
        return new UserCollection(User::whereIn('id', $result_ids)->get());
    }

    /**
     * List followers of specified user.
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
                "message" => "Target user does not exist in database."], 404);
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
                "message" => "Target user does not exist in database."], 404);
        }
        $follow = Follow::where("source_id", $source_user->id)
                        ->where("target_id", $target_user->id)
                        ->get();
        if (count($follow) > 0 || $source_user->id == $target_user->id) {
            return response()->json([
                "success" => false,
                "message" => "Source user already follow Target user."], 409);
        }
        $follow = Follow::create([
            "source_id" => $source_user->id,
            "target_id" => $target_user->id
        ]);

        try {
            $follow = Notification::where("follow_id", $follow->id)->firstOrFail();
            NotificationController::update($follow);
        } catch(Exception $ex) {

        }
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
                "message" => "Target user does not exist in database."], 404);
        }
        try {
            $follow = Follow::where("source_id", $source_user->id)
                            ->where("target_id", $target_user->id)
                            ->firstOrFail();
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Source user did not follow Target user before."], 409);
        }
        $follow->delete();
        return response()->json([
            "success" => true,
            "message" => "Unfollow successful."], 200);
    }
}
