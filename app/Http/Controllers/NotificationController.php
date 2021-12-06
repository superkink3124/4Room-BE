<?php

namespace App\Http\Controllers;

use App\Events\NotificationUpdate;
use App\Http\Resources\NotificationCollection;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function notification(Request $request): NotificationCollection
    {
        $user = $request->user;
        return new NotificationCollection(Notification::where("user_id", $user->id)
                                                        ->orderBy("created_at", "desc")
                                                        ->simplePaginate(10));
    }

    public function show(int $notification_id): JsonResponse
    {
        try {
            return response()->json([
                "success" => true,
                "data" => new NotificationResource(Notification::findOrFail($notification_id))
            ]);
        } catch(Exception $ex) {
            return response()->json([
                "success" => false,
                "message" => "Notification does not exist in database"
            ], 400);
        }
    }

    public static function update(Notification $notification) {
        event(new NotificationUpdate($notification));
    }

    public function count_unseen_notification(Request $request): JsonResponse
    {
        $user = $request->user;
        $user_id = $user->id;
        $last_update = $user->last_update_notification;
        $count = Notification::where("user_id", $user_id)->where("created_at", ">=", $last_update)->count();
        return response()->json([
            "success" => true,
            "unread_notifications" => $count
        ]);
    }

    public function update_last_update_notification(Request $request): JsonResponse
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $user = $request->user;
        $current_time = date("Y-m-d H:i:s");
        $user = User::where("id", $user->id)->update(["last_update_notification" => $current_time]);
        return response()->json([
            "success" => true,
            "time" => $current_time
        ]);
    }

    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function index()
    // {
    //     //
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    //     //
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     //
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Models\Notification  $notification
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show(Notification $notification)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Models\Notification  $notification
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit(Notification $notification)
    // {
    //     //
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Models\Notification  $notification
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, Notification $notification)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Models\Notification  $notification
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(Notification $notification)
    // {
    //     //
    // }
}
