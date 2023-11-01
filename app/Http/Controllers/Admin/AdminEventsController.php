<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Models\{Company, Course, Elearning, Event, Exam, OwnerCompany, Room, User};
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

        return view('admin.events.index', [
            "courses" => Course::where('course_type', 'REGULAR')
                ->get(['id', 'description', 'course_type']),
            "instructors" => User::getInstructorsQuery()->get(['id', 'name', 'paternal']),
            "responsables" => User::getResponsablesQuery()->get(['id', 'name', 'paternal'])
        ]);
    }

    public function create()
    {
        $allExams = Exam::withCount('questions')->having('questions_count', '>=', 2)
            ->get(['id', 'title', 'exam_type']);

        $exams = $allExams->where('exam_type', 'dynamic');
        $examsTest = $allExams->where('exam_type', 'test');

        return response()->json([
            "types" => $this->eventService->getTypes(),
            "instructors" => User::getInstructorsQuery()->get(['id', 'name', 'paternal']),
            "responsables" => User::getResponsablesQuery()->get(['id', 'name', 'paternal']),
            "rooms" => Room::get(['id', 'description']),
            "ownerCompanies" => OwnerCompany::get(['id', 'name']),
            "exams" => $exams,
            "examsTest" => $examsTest,
            "eLearnings" => Elearning::get(['id', 'title']),
        ]);
    }

    public function validateQuestionsScore(Request $request)
    {
        $maxScore = null;

        $exam = Exam::where('id', $request['value'])
            ->withCount(['questions' => fn ($q) => $q->where('active', 'S')])
            ->withAvg(['questions' => fn ($q2) => $q2->where('active', 'S')], 'points')->first();

        $avg = $exam != null ? $exam->questions_avg_points : 0;

        if ($request->has('qty') && $request['qty'] != '') {
            $maxScore = round($avg * $request['qty']);
        }

        return response()->json([
            'qty' => $exam != null ? $exam->questions_count : 0,
            'avg' => $avg,
            'maxScore' => $maxScore
        ]);
    }

    public function store(EventRequest $request)
    {
        $success = true;
        $message = null;

        try {
            $this->eventService->store($request);
        } catch (Exception $e) {
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

        $allExams = Exam::withCount(['questions' => fn ($q) => $q->where('active', 'S')])->having('questions_count', '>=', 2)
            ->get(['id', 'title', 'exam_type']);

        $exams = $allExams->where('exam_type', 'dynamic');
        $examsTest = $allExams->where('exam_type', 'test');

        $event['type'] = verifyEventType($event->type);

        return response()->json([
            "all" => [
                "types" => $this->eventService->getTypes(),
                "instructors" => User::getInstructorsQuery()->get(['id', 'name', 'paternal']),
                "responsables" => User::getResponsablesQuery()->get(['id', 'name', 'paternal']),
                "rooms" => Room::where('capacity', '>=', $event->participants_count)->get(['id', 'description', 'capacity']),
                "ownerCompanies" => OwnerCompany::get(['id', 'name']),
                "exams" => $exams,
                "examsTest" => $examsTest,
                "eLearnings" => Elearning::get(['id', 'title'])
            ],
            "event" => $event
        ]);
    }

    public function update(EventRequest $request, Event $event)
    {
        $event->loadParticipantsCount();
        $success = true;
        $html = null;

        try {
            $this->eventService->update($request, $event);
            $message = config('parameters.updated_message');
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        if ($request->has('place') && $request['place'] == 'show') {
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

        try {
            $this->eventService->destroy($event);
            $message = config('parameters.deleted_message');
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        if ($request->has('place') && $request['place'] == 'show') {
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
            return app(CertificationService::class)->getParticipantsTable($request, $event);
        }

        $event->loadRelationships();
        $companies = Company::get(['id', 'description']);

        return view('admin.events.show', compact(
            'event',
            'companies'
        ));
    }

    public function getUsersTable(Request $request, Event $event)
    {
        return $this->eventService->getUsersTable($request, $event);
    }
}
