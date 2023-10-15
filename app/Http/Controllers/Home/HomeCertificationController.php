<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\{Event};
use App\Services\Home\HomeCertificationService;
use App\Services\Home\HomeCourseService;
use Auth;
use Exception;
use Illuminate\Http\Request;

class HomeCertificationController extends Controller
{
    private $certificationService;

    public function __construct(HomeCertificationService $service)
    {
        $this->certificationService = $service;
    }

    public function UserCertificationSelfRegister(HomeCourseService $courseService, Request $request, Event $event)
    {
        $event->loadRelationships();

        $success = false;
        $html = NULL;
        $htmlEvents = NULL;
        $message = NULL;

        try {
            $this->certificationService->userSelfRegisterCertification($request, $event);
            $success = true;
        } catch (Exception $e) {
            $message = $e->getMessage();
        }

        if ($success) {
            $events = $courseService->getAvailableEvents($event->course);
            $htmlEvents = view('home.courses.partials._events_list', compact('events'))->render();
            $html = view('home.common.partials.boxes._event_success_message', compact('event'))->render();
        }

        return response()->json([
            "success" => $success,
            "message" => $message,
            "html" => $html,
            "htmlEvents" => $htmlEvents
        ]);
    }
}
