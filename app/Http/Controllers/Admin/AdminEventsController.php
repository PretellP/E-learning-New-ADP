<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Models\{Elearning, Event, Exam, OwnerCompany, Room, User};
use App\Services\{EventService};
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
        $event->loadRelationships();

        $allExams = Exam::get(['id', 'title', 'exam_type']);

        $types = $this->eventService->getTypes();
        $instructors = User::getInstructorsQuery()->get(['id', 'name', 'paternal']);
        $responsables = User::getResponsablesQuery()->get(['id', 'name', 'paternal']);
        $rooms = Room::get(['id', 'description']);
        $ownerCompanies = OwnerCompany::get(['id', 'name']);
        $exams = $allExams->where('exam_type', 'dynamic');
        $examsTest = $allExams->where('exam_type', 'test');
        $eLearnings = Elearning::get(['id', 'title']);

        $selectedType = $event->type;
        $selectedInstructor = $event->user != null ? $event->user->id : null;
        $selectedResponsable = $event->responsable != null ? $event->responsable->id : null;
        $selectedRoom = $event->room != null ? $event->room->id : null;
        $selectedOwnerCompany = $event->ownerCompany != null ? $event->ownerCompany->id : null;
        $selectedExam = $event->exam != null ? $event->exam->id : null;
        $selectedTestExam = $event->testExam != null ? $event->testExam->id : null;
        $selectedElearning = $event->eLearning != null ? $event->eLearning->id :null;

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
            "info" => [
                "description" => $event->description,
                "date" => $event->date,
                "active" => $event->active,
                "flg_test" => $event->flg_test_exam,
                "flg_assit" => $event->flg_asist
            ],
            "selected" => [
                "type" => $selectedType,
                "instructor" => $selectedInstructor,
                "responsable" => $selectedResponsable,
                "room" => $selectedRoom,
                "ownerCompany" => $selectedOwnerCompany,
                "exam" => $selectedExam,
                "testExam" => $selectedTestExam,
                "eLearning" => $selectedElearning,
            ]
        ]);
    }

    public function update(EventRequest $request, Event $event)
    {
        $success = true;
        $message = null;

        try{
            $this->eventService->update($request, $event);
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return response()->json([
            "success" => $success,
            "message" => $message
        ]);
    }

    public function destroy(Event $event)
    {
        $success = true;
        $message = null;

        try{
            $this->eventService->destroy($event);
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return response()->json([
            "success" => $success,
            "message" => $message
        ]);
    }
}
