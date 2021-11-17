<?php

namespace App\Http\Controllers;

use App\Events\NotificationUpdate;
use App\Http\Resources\NotificationCollection;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use Exception;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function notification(Request $request) {
        $user = $request->user;
        return new NotificationCollection(Notification::where("user_id", $user->id)->orderBy("created_at", "desc")->simplePaginate(10));
    }

    public function show(int $notification_id) {
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

    public static function update($notification) {
        event(new NotificationUpdate($notification));
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
