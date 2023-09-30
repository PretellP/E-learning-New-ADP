<?php

namespace App\Services;

use App\Models\{Event};
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EventService
{
    public function getDataTable(Request $request)
    {
        $query = Event::with([
            'exam.course',
            'user',
            'responsable',
        ])
            ->withCount(['certifications', 'userSurveys']);

        $allEvents = DataTables::of($query)
            ->editColumn('description', function ($event) {
                return '<a href="">' . $event->description . '</a>';
            })
            ->editColumn('type', function ($event) {
                return getTranslatedEventType($event->type);
            })
            ->editColumn('user.name', function ($event) {
                $user = $event->user;
                return $user->full_name;
            })
            ->editColumn('responsable.name', function ($event) {
                $responsable = $event->responsable;
                return $responsable->full_name;
            })
            ->editColumn('flg_asist', function ($event) {
                return $event->flg_asist == 'S' ? 'Habilitado' : 'Deshabilitado';
            })
            ->editColumn('active', function ($event) {
                $status = $event->active;
                $statusBtn = '<span class="status ' . getStatusClass($status) . '">' . getStatusText($status) . '</span>';

                return $statusBtn;
            })
            ->addColumn('action', function ($event) {
                $btn = '<button data-toggle="modal" data-id="' .
                    $event->id . '" data-url="'. route('admin.events.update', $event) .'" 
                                        data-send="'. route('admin.events.edit', $event) .'"
                                        data-original-title="edit" class="me-3 edit btn btn-warning btn-sm
                                        editEvent-btn"><i class="fa-solid fa-pen-to-square"></i></button>';
                if (
                    $event->certifications_count == 0 &&
                    $event->user_surveys_count == 0
                ) {
                    $btn .= '<a href="javascript:void(0)" data-id="' .
                        $event->id . '" data-original-title="delete"
                                            data-url="'. route('admin.events.destroy', $event) .'" class="ms-3 edit btn btn-danger btn-sm
                                            deleteEvent-btn"><i class="fa-solid fa-trash-can"></i></a>';
                }

                return $btn;
            })
            ->rawColumns(['description', 'active', 'action'])
            ->make(true);

        return $allEvents;
    }

    public function getTypes()
    {
        return collect(config('parameters.event_types'));
    }

    public function store($request)
    {
        $data = normalizeInputStatus($request->validated());
        $event = Event::create($data);

        if($event){
            return $event;
        }

        throw new Exception('No es posible completar la solicitud');
    }

    public function update($request, Event $event)
    {
        $data = normalizeInputStatus($request->validated());

        $isUpdated = $event->update($data);

        if($isUpdated){
            return true;
        }

        throw new Exception('No es posible completar la solicitud');
    }

    public function destroy(Event $event)
    {
        $isDeleted = $event->delete();

        if($isDeleted){
            return true;
        }

        throw new Exception('No es posible completar la solicitud');
    }
}
