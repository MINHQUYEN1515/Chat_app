<?php

namespace App\Http\Controllers\api;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoomRequest;
use App\Models\Room;
use App\Models\User;


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
    public function chatMessage()
    {
    }
}
