<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use App\Models\{User, Room};

class AdminRoomsController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $allRooms = DataTables::of(Room::query()
                                    ->withCount('events'))
                    ->addColumn('created_at', function($room){
                        return $room->created_at;
                    })
                    ->addColumn('status-btn', function($room){
                        $status = $room->active == 'S' ? 'active' : 'inactive';
                        $txtBtn = $status == 'active' ? 'Activo' : 'Inactivo';
                        $statusBtn = '<span class="status '.$status.'">'.$txtBtn.'</span>';

                        return $statusBtn;
                    })
                    ->addColumn('action', function($room){
                        $btn = '<button data-toggle="modal" data-id="'.
                                $room->id.'" data-url="'.route('admin.room.update', $room).'" 
                                data-send="'.route('admin.room.edit', $room).'"
                                data-original-title="edit" class="me-3 edit btn btn-warning btn-sm
                                editRoom"><i class="fa-solid fa-pen-to-square"></i></button>';
                        if($room->events_count == 0)
                        {
                            $btn.= '<a href="javascript:void(0)" data-id="'.
                                    $room->id.'" data-original-title="delete"
                                    data-url="'.route('admin.rooms.delete', $room).'" class="ms-3 edit btn btn-danger btn-sm
                                    deleteRoom"><i class="fa-solid fa-trash-can"></i></a>';
                        }
                    
                        return $btn;
                    })
                    ->rawColumns(['status-btn', 'action'])
                    ->make(true);

            return $allRooms;
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
