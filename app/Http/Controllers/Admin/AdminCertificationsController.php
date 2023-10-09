<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Certification, Company, Event, MiningUnit};
use App\Services\{CertificationService};
use Exception;
use Illuminate\Http\Request;

class AdminCertificationsController extends Controller
{
    private $certificationService;

    public function __construct(CertificationService $service)
    {
        $this->certificationService = $service;
    }

    public function store(Request $request, Event $event)
    {
        $event->loadRelationships();

        try{
            $info = $this->certificationService->store($request, $event);
            $message = config('parameters.stored_message');
        } catch (Exception $e) {
            $info = array("success" => false, "status" => "error", "note" => config('parameters.exception_message'));
            $message = $e->getMessage();    
        }

        $event->loadCounts();
        $html = view('admin.events.partials._box_event', compact('event'))->render();

        return response()->json([
            "success" => $info['success'],
            "status" => $info['status'],
            "note" => $info['note'],
            "message" => $message,
            "html" => $html
        ]);
    }

    public function updateAssist(Request $request, Certification $certification)
    {
        try{
            $success = $this->certificationService->updateAssist($request, $certification);
            $message = config('parameters.updated_message');
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return response()->json([
            "success" => $success,
            "message" => $message
        ]);
    }

    public function edit(Certification $certification) 
    {
        $certification->loadRelationships();

        return response()->json([
            "all" => [
                "miningUnits" => MiningUnit::get(['id', 'description']),
                "companies" => Company::get(['id', 'description'])
            ],
            "selected" => [
                "miningUnits" => $certification->miningUnits->pluck('id'),
                'company' => $certification->company,
                'participant' => $certification->user->full_name_complete
            ],
            "flg_assist_status" => $certification->event_assist_status,
            "certification" => $certification
        ]);
    }

    public function update(Request $request, Certification $certification) 
    {   
        $message = null;

        try {
            $success = $this->certificationService->update($request, $certification);
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        if($success){
            $message = config('parameters.updated_message');
        }

        return response()->json([
            "success" => $success,
            "message" => $message
        ]);
    }

    public function destroy(Certification $certification)
    {
        $certification->load('testCertification');
        $html = null;

        try{
            $success = $this->certificationService->destroy($certification);
            $message = config('parameters.deleted_message');
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();    
        }

        if ($success) {
            $event = $certification->event->loadCounts();
            $html = view('admin.events.partials._box_event', compact('event'))->render();
        }

        return response()->json([
            "success" => $success,
            "message" => $message,
            "html" => $html
        ]);
    }

    public function show(Certification $certification)
    {
        $certification->loadRelationships();

        $user = $certification->user;
        $user['name'] = $user->full_name;
        $event = $certification->event;
        $certification['status_txt'] = config('parameters.certification_status')[$certification->status];

        return response()->json([
            "title" => $certification->id,
            "participant" => $user,
            "event" => $event,
            "certification" => $certification,
        ]);
    }
}
