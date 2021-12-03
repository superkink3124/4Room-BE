<?php

namespace App\Http\Controllers;

use App\Events\MessageUpdateEvent;
use App\Http\Resources\MessageCollection;
use App\Models\Message;
use App\Models\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display messages of a room.
     * @param $room_id
     * @return MessageCollection|JsonResponse
     */
    public function index($room_id)
    {
        $room = Room::find($room_id);
        if (!$room) {
            return response()->json([
                "success" => false,
                "message" => "Room does not exist in database."], 400);
        }
        return new MessageCollection($room->messages()
                                    ->orderBy('created_at', 'desc')
                                    ->simplePaginate(10), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param $room_id
     * @return JsonResponse
     */
    public function store(Request $request, $room_id): JsonResponse
    {
        $user = $request->user;
        $room = Room::find($room_id);

        if (!$room) {
            return response()->json([
                "success" => false,
                "message" => "Room does not exist in database."], 400);
        }

        $message = Message::create([
            "user_id" => $user->id,
            "room_id" => $room->id,
            "content" => $request->input("content"),
        ]);
        event(new MessageUpdateEvent($message, $user));
        return response()->json([
            "success" => true,
            "message" => "Created new message."], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
