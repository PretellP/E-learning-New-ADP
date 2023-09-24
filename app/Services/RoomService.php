<?php

namespace App\Services;

use App\Models\{Room};
use Yajra\DataTables\Facades\DataTables;

class RoomService
{
    public function getDataTable()
    {
        $allRooms = DataTables::of(Room::query()
            ->withCount('events'))
            ->addColumn('created_at', function ($room) {
                return $room->created_at;
            })
            ->addColumn('status-btn', function ($room) {
                $status = $room->active == 'S' ? 'active' : 'inactive';
                $txtBtn = $status == 'active' ? 'Activo' : 'Inactivo';
                $statusBtn = '<span class="status ' . $status . '">' . $txtBtn . '</span>';

                return $statusBtn;
            })
            ->addColumn('action', function ($room) {
                $btn = '<button data-toggle="modal" data-id="' .
                    $room->id . '" data-url="' . route('admin.room.update', $room) . '" 
                    data-send="' . route('admin.room.edit', $room) . '"
                    data-original-title="edit" class="me-3 edit btn btn-warning btn-sm
                    editRoom"><i class="fa-solid fa-pen-to-square"></i></button>';
                if ($room->events_count == 0) {
                    $btn .= '<a href="javascript:void(0)" data-id="' .
                        $room->id . '" data-original-title="delete"
                    data-url="' . route('admin.rooms.delete', $room) . '" class="ms-3 edit btn btn-danger btn-sm
                    deleteRoom"><i class="fa-solid fa-trash-can"></i></a>';
                }

                return $btn;
            })
            ->rawColumns(['status-btn', 'action'])
            ->make(true);

        return $allRooms;
    }
}
