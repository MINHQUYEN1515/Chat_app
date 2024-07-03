<?php

namespace App\Http\Controllers\api;

use App\Events\SendMessage;
use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoomRequest;
use App\Jobs\SendMessageListen;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function createRooms(RoomRequest $request)
    {
        if (
            empty(User::select('id')->where('id', $request->firstUserId)->get()->toArray()) ||
            empty(User::select('id')->where('id', $request->sencondUserId)->get()->toArray())
        ) {
            return Helper::Error([], null, "User not found");
        } else {
            $room = Room::create($request->toArray());
            return Helper::SuccessWithData($room);
        }
    }
    public function chatMessage(Request $request)
    {
        try {

            broadcast(new SendMessage(
                $request->room_id,
                $request->message
            ))->toOthers();
        } catch (\Throwable $error) {
            return Helper::Error([], 400, $error->getMessage());
        }
    }
}
