<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Room};
use App\Services\RoomService;

class AdminRoomsController extends Controller
{
    private $roomService;

    public function __construct(RoomService $service)
    {
        $this->roomService = $service;
    }
    public function index(Request $request)
    {
        if($request->ajax())
        {
           return $this->roomService->getDataTable();
        }

        return view('admin.rooms.index');
    }

    public function registerValidateName(Request $request)
    {
        $valid = Room::where('description', $request['name'])->first() == null ? "true" : "false";

        return $valid;
    }

    public function store(Request $request)
    {
        $status = $request['roomStatusCheckbox'] == 'on' ? 'S' : 'N';

        Room::create([
            "description" => $request['name'],
            "capacity" => $request['capacity'],
            "url_zoom" => $request['url'],
            "active" => $status
        ]);

        return response()->json([
            "success" => "stored successfully"
        ]);
    }

    public function editValidateName(Request $request)
    {
        $valid = 'false';
        $id = $request['id'];
        $room = Room::where('description', $request['name'])->first();

        if($room == null){
            $valid = 'true';
        }
        elseif($room->id == $id){
            $valid = 'true';
        }

        return $valid;
    }

    public function edit(Room $room)
    {
        return response()->json($room);
    }

    public function update(Request $request, Room $room)
    {
        $status = $request['roomStatusCheckbox'] == 'on' ? 'S' : 'N';

        $room->update([
            "description" => $request['name'],
            "capacity" => $request['capacity'],
            "url_zoom" => $request['url'],
            "active" => $status
        ]);

        return response()->json([
            "success" => "updated successfully"
        ]);
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return response()->json([
            "success" => true
        ]);
    }
}
