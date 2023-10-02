<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Models\{Elearning, Event, Exam, OwnerCompany, Room, User};
use App\Services\{CertificationService, EventService};
use Exception;
use Illuminate\Http\Request;

class AdminEventsController extends Controller
{
    private $eventService;

    public function __construct(EventService $service)
    {
        $this->eventService = $service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->eventService->getDataTable($request);
        }

        return view('admin.events.index');
    }

    public function create() 
    {
        $allExams = Exam::get(['id', 'title', 'exam_type']);

        $types = $this->eventService->getTypes();
        $instructors = User::getInstructorsQuery()->get(['id', 'name', 'paternal']);
        $responsables = User::getResponsablesQuery()->get(['id', 'name', 'paternal']);
        $rooms = Room::get(['id', 'description']);
        $ownerCompanies = OwnerCompany::get(['id', 'name']);
        $exams = $allExams->where('exam_type', 'dynamic');
        $examsTest = $allExams->where('exam_type', 'test');
        $eLearnings = Elearning::get(['id', 'title']);

        return response()->json([
            "types" => $types, 
            "instructors" => $instructors, 
            "responsables" => $responsables, 
            "rooms" => $rooms, 
            "ownerCompanies" => $ownerCompanies, 
            "exams" => $exams, 
            "examsTest" => $examsTest, 
            "eLearnings" => $eLearnings,
        ]);
    }

    public function store(EventRequest $request)
    {
        $success = true;
        $message = null;

        try{
            $this->eventService->store($request);
        }catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return response()->json([
            "success" => $success,
            "message" => $message
        ]);
    }

    public function edit(Event $event)
    {
        $event->loadRelationships()->loadParticipantsCount();

        $allExams = Exam::get(['id', 'title', 'exam_type']);

        $types = $this->eventService->getTypes();
        $instructors = User::getInstructorsQuery()->get(['id', 'name', 'paternal']);
        $responsables = User::getResponsablesQuery()->get(['id', 'name', 'paternal']);
        $rooms = Room::where('capacity', '>=', $event->participants_count)->get(['id', 'description', 'capacity']);
        $ownerCompanies = OwnerCompany::get(['id', 'name']);
        $exams = $allExams->where('exam_type', 'dynamic');
        $examsTest = $allExams->where('exam_type', 'test');
        $eLearnings = Elearning::get(['id', 'title']);

        return response()->json([
            "all" => [
                "types" => $types,
                "instructors" => $instructors,
                "responsables" => $responsables,
                "rooms" => $rooms,
                "ownerCompanies" => $ownerCompanies,
                "exams" => $exams,
                "examsTest" => $examsTest,
                "eLearnings" => $eLearnings
            ],  
            "event" => $event
        ]);
    }

    public function update(EventRequest $request, Event $event)
    {
        $success = true;
        $html = null;

        try{
            $this->eventService->update($request, $event);
            $message = config('parameters.updated_message');
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        if($request->has('place') && $request['place'] == 'show'){
            $event->loadRelationships();
            $html = view('admin.events.partials._box_event', compact('event'))->render();
        }

        return response()->json([
            "success" => $success,
            "message" => $message,
            "html" => $html,
            "title" => mb_strtolower($event->description, 'UTF-8')
        ]);
    }

    public function destroy(Request $request, Event $event)
    {
        $success = true;
        $route = null;

        try{
            $this->eventService->destroy($event);
            $message = config('parameters.deleted_message');
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        if($request->has('place') && $request['place'] == 'show'){
            $route = route('admin.events.index');
        }

        return response()->json([
            "success" => $success,
            "message" => $message,
            "route" => $route
        ]);
    }

    // ----------- SHOW ------------

    public function show(Request $request, Event $event)
    {

        if ($request->ajax()) {
            return app(CertificationService::class)->getParticipantsTable($event);
        }

        $event->loadRelationships();

        return view('admin.events.show', compact(
            'event'
        ));
    }

    public function getUsersTable(Request $request, Event $event)
    {
        return $this->eventService->getUsersTable($request, $event);
    }
}
