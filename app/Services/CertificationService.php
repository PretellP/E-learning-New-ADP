<?php

namespace App\Services;

use App\Models\{Certification, Event, User};
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CertificationService
{
    public function getParticipantsTable(Event $event)
    {
        $query = $event->certifications()
            ->where('evaluation_type', 'certification')
            ->with(['user.company', 'event'])
            ->withCount('evaluations');

        $allCertifications = DataTables::of($query)
            ->editColumn('user.name', function ($certification) {
                $user = $certification->user;
                return $user->full_name_complete;
            })
            ->editColumn('score', function ($certification) {
                return $certification->score ?? '-';
            })
            ->editColumn('status', function ($certification) {
                $status = $certification->status;
                $statusBtn = '<span class="status ' . $status . '">' .
                    config('parameters.certification_status')[$status]
                    . '</span>';

                return $statusBtn;
            })
            ->addColumn('enabled', function ($certification) {
                $enabled = '<ul>';
                foreach ($certification->is_enable_evaluation as $message) {
                    $enabled .= '<li>' . $message . '</li>';
                }
                return $enabled . '</ul>';
            })
            ->addColumn('assit', function ($certification) {
                $assit_btn = '<label class="custom-switch">
                                <input type="checkbox" name="flg_asist" '. $certification->event_assist_status .'
                                    class="custom-switch-input flg_assist_user_checkbox '. $certification->event_assist_status .'"
                                    '. $certification->valid_assist_checked .'
                                    data-url="'. route('admin.events.certification.updateAssist', $certification) .'">
                                <span class="custom-switch-indicator"></span>
                            </label>';

                return $assit_btn;
            })
            ->addColumn('action', function ($certification) {
                $btn = '<button data-toggle="modal" data-id="' .
                    $certification->id . '" data-url="" 
                                        data-send=""
                                        data-original-title="edit" class="me-3 edit btn btn-info btn-sm
                                        showCertification-btn"><i class="fa-solid fa-eye"></i></button>';
                if (
                    $certification->evaluations_count == 0
                ) {
                    $btn .= '<a href="javascript:void(0)" data-id="' .
                        $certification->id . '" data-original-title="delete"
                                            data-url="' . route('admin.events.certifications.destroy', $certification) . '" class="ms-3 edit btn btn-danger btn-sm
                                            deleteCertification-btn"><i class="fa-solid fa-trash-can"></i></a>';
                }

                return $btn;
            })
            ->rawColumns(['status', 'assit', 'enabled', 'action'])
            ->make(true);

        return $allCertifications;
    }

  
    public function store($request, Event $event)
    {
        /** @var self $status */
        /** @var self $note */
        $note = null;
        $status = null;

        $event->loadParticipantsRelationships();

        $users = $this->getFilteredUsers($request['users-selected'], $event);

        foreach($users as $i => $user){
        
            $event->loadParticipantsCount();
            $miningUnitsIds = $user->miningUnits->pluck('id');

            if($event->room->capacity > $event->participants_count){

                $certification = $event->certifications()
                                        ->create($this->getCertificationArrayData($user, 'N', 'certification'));
                $certification->miningUnits()->sync($miningUnitsIds);

                $testCertification = $event->certifications()
                                        ->create($this->getCertificationArrayData($user, 'S', 'test'));
                $testCertification->miningUnits()->sync($miningUnitsIds);

                $certification->testCertification()->associate($testCertification);
                $certification->save();
                
                $status = 'finished';
            }
            else{
                $note = 'Se ha excedido la capacidad de la sala';
                $status = $i == 0 ? 'exceeded' : 'limitreached';
                break;
            }
        }

        return array("success" => true, "status" => $status, "note" => $note);
    }

    public function updateAssist($request, Certification $certification)
    {
        $request['assist_user'] = $request['assist_user'] == 'true' ? 'S' : 'N';

        return $certification->update($request->all());
    }

    private function getFilteredUsers($ids, Event $event)
    {
        $filteredIds = array_diff($ids, $event->participants->pluck('id')->toArray());

        return User::whereIn('id', $filteredIds)->with(['company:id', 'miningUnits:id'])
                                                ->has('company')->get();
    }

    private function getCertificationArrayData(User $user, string $assist, string $type)
    {
        return [
            "user_id" => $user->id,
            "assist_user" => $assist,
            "recovered_at" => null,
            "status" => 'pending',
            "position" => $user->position,
            "evaluation_type" => $type,
            "company_id" => $user->company->id
        ];
    }

    public function destroy(Certification $certification)
    {
        $certification->miningUnits()->detach();

        if($certification->testCertification != null){
            $this->destroy($certification->testCertification);
        }

        return $certification->delete();

        throw new Exception(config('parameters.exception_message'));
    }
}
