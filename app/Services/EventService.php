<?php

namespace App\Services;

use App\Models\{Event, User};
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

        if ($request->filled('from_date') && $request->filled('end_date')) {
            $query = $query->whereBetween('date', [$request->from_date, $request->end_date]);
        }

        if ($request->filled('search_course')) {
            $query = $query->whereHas('exam.course', function ($query) use ($request) {
                $query->where('id', $request['search_course']);
            });
        }

        if ($request->filled('search_instructor')) {
            $query = $query->where('user_id', $request['search_instructor']);
        }

        if ($request->filled('search_responsable')) {
            $query = $query->where('responsable_id', $request['search_responsable']);
        }

        $allEvents = DataTables::of($query)
            ->editColumn('description', function ($event) {
                return '<a href="' . route('admin.events.show', $event) . '">' . $event->description . '</a>';
            })
            ->editColumn('type', function ($event) {
                return config('parameters.event_types')[verifyEventType($event->type)];
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
                    $event->id . '" data-url="' . route('admin.events.update', $event) . '" 
                                        data-send="' . route('admin.events.edit', $event) . '"
                                        data-original-title="edit" class="me-3 edit btn btn-warning btn-sm
                                        editEvent-btn"><i class="fa-solid fa-pen-to-square"></i></button>';
                if (
                    $event->certifications_count == 0 &&
                    $event->user_surveys_count == 0
                ) {
                    $btn .= '<a href="javascript:void(0)" data-id="' .
                        $event->id . '" data-original-title="delete"
                                            data-url="' . route('admin.events.destroy', $event) . '" class="ms-3 edit btn btn-danger btn-sm
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

        if ($event) {
            return $event;
        }

        throw new Exception(config('parameters.exception_message'));
    }

    public function update($request, Event $event)
    {
        $data = normalizeInputStatus($request->validated());

        if ($event->finished_certifications_count != 0) {
            $data['exam_id'] = $event->exam_id;
            $data['min_score'] = $event->min_score;
            $data['questions_qty'] = $event->questions_qty;
        }

        $isUpdated = $event->update($data);

        if ($isUpdated) {
            return true;
        }

        throw new Exception('No es posible completar la solicitud');
    }

    public function destroy(Event $event)
    {
        $isDeleted = $event->delete();

        if ($isDeleted) {
            return true;
        }

        throw new Exception('No es posible completar la solicitud');
    }

    public function getUsersTable(Request $request, Event $event)
    {
        $participants = $event->participants()->wherePivot('evaluation_type', 'certification')->get()
            ->pluck('id')->toArray();

        $users = User::where('role', 'participants')
            ->whereNotIn('users.id', $participants)
            ->with('company');

        if ($request->filled('search_company')) {
            $users = $users->where('company_id', $request['search_company']);
        }       

        $allUsers = DataTables::of($users)
            ->addColumn('choose', function ($user) {
                $checkbox = '<div class="custom-checkbox custom-control">
                    <input type="checkbox" name="users-selected[]" 
                     class="custom-control-input checkbox-user-input" id="checkbox-' . $user->id . '" value="' . $user->dni . '">
                    <label for="checkbox-' . $user->id . '" class="custom-control-label checkbox-user-label">&nbsp;</label>
                </div>';
                return $checkbox;
            })
            ->editColumn('company.description', function ($user) {
                return $user->company != null ? $user->company->description : '-';
            })
            ->editColumn('user.name', function ($user) {
                return $user->full_name;
            })
            ->rawColumns(['choose'])
            ->make(true);

        return $allUsers;
    }
}
