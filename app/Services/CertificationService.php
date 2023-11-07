<?php

namespace App\Services;

use App\Models\{Certification, Event, User};
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Yajra\DataTables\Facades\DataTables;

class CertificationService
{
    public function getParticipantsTable(Request $request, Event $event)
    {
        $query = $event->certifications()
            ->where('evaluation_type', 'certification')
            ->with(['user.company', 'event'])
            ->withCount('evaluations');

        if ($request->filled('from_status')) {
            if ($request['from_status'] == 'approved') {
                $query->where('score', '>=', $event->min_score);
            } 
            elseif ($request['from_status'] == 'suspended') {
                $query->where('score', '<', $event->min_score);
            }
        }

        $allCertifications = DataTables::of($query)
            ->editColumn('user.name', function ($certification) {
                $user = $certification->user;
                return $user->full_name_complete;
            })
            ->editColumn('user.company.description', function ($certification) {
                $user = $certification->user;
                return $user->company == null ? '-' : $user->company->description;
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
                                <input type="checkbox" name="flg_asist" ' . $certification->event_assist_status . '
                                    class="custom-switch-input flg_assist_user_checkbox ' . $certification->event_assist_status . '"
                                    ' . $certification->valid_assist_checked . '
                                    data-url="' . route('admin.events.certification.updateAssist', $certification) . '">
                                <span class="custom-switch-indicator"></span>
                            </label>';

                return $assit_btn;
            })
            ->addColumn('action', function ($certification) {
                $btn = '<button data-toggle="modal" data-id="' .
                    $certification->id . '" data-send="' . route('admin.events.certifications.show', $certification) . '"
                                        data-original-title="edit" class="me-3 edit btn btn-info btn-sm
                                        showCertification-btn"><i class="fa-solid fa-eye"></i></button>';

                $btn .= '<button data-toggle="modal" data-id="' .
                    $certification->id . '" data-url="' . route('admin.events.certifications.update', $certification) . '" 
                        data-send="' . route('admin.events.certifications.edit', $certification) . '"
                        data-original-title="edit" class="edit btn btn-warning btn-sm
                        editCertification-btn"><i class="fa-solid fa-pen-to-square"></i></button>';

                if ($certification->evaluations_count > 0) {
                    $btn .= '<button data-toggle="modal" title="reiniciar" data-id="' .
                    $certification->id . '" data-url="'. route('admin.events.certifications.reset', $certification) .'" 
                        data-original-title="edit" class="reset ms-3 btn btn-primary btn-sm
                        resetCertification-btn"><i class="fa-solid fa-rotate-right"></i></button>';
                }
                
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

    public function selfStore($user, Event $event)
    {
        $event->loadParticipantsRelationships()->loadParticipantsCount();

        // $miningUnitsIds = $user->miningUnits->pluck('id');

        if ($event->room->capacity > $event->participants_count) {
            $this->storeAll($event, $user);
            return true;
        }

        return false;
    }

    public function store($dnis, Event $event)
    {
        /** @var self $status */
        /** @var self $note */
        $note = null;
        $status = null;

        $event->loadParticipantsRelationships();

        $users = $this->getFilteredUsers($dnis, $event);

        foreach ($users as $i => $user) {

            $event->loadParticipantsCount();
            // $miningUnitsIds = $user->miningUnits->pluck('id');

            if ($event->room->capacity > $event->participants_count) {

                $this->storeAll($event, $user);
                $status = 'finished';
                
            } else {
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

    public function update($request, Certification $certification)
    {
        $data = new Request(normalizeInputStatus($request->all()));

        $isUpdated = $certification->update($data->except('status'));

        // if ($isUpdated) {
        //     $certification->miningUnits()->sync($request['mining_unit_id']);
        // }

        return $isUpdated;
    }

    public function destroy(Certification $certification)
    {
        // $certification->miningUnits()->detach();

        if ($certification->testCertification != null) {
            $this->destroy($certification->testCertification);
        }

        return $certification->delete();

        throw new Exception(config('parameters.exception_message'));
    }

    private function getFilteredUsers($dnis, Event $event)
    {
        $filteredDnis = array_diff($dnis, $event->participants->pluck('dni')->toArray());

        return User::whereIn('dni', $filteredDnis)->with(['company:id'])->get();
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
            "company_id" => $user->company == null ? null : $user->company->id,
        ];
    }

    private function storeAll(Event $event, User $user)
    {
        $certification = $event->certifications()
            ->create($this->getCertificationArrayData($user, 'N', 'certification'));
        // $certification->miningUnits()->sync($miningUnitsIds);

        $testCertification = $event->certifications()
            ->create($this->getCertificationArrayData($user, 'S', 'test'));
        // $testCertification->miningUnits()->sync($miningUnitsIds);

        $certification->testCertification()->associate($testCertification);
        $certification->save();
    }
    
    public function reset(Certification $certification)
    {
        if ($certification->evaluations()->delete()) {

            return $certification->update([
                "recovered_at" => Carbon::now('America/Lima'),
                "status" => 'pending',
                "evaluation_time" => null,
                "start_time" => null,
                "end_time" => null,
                "total_time" => null,
                "score" => null
            ]);
        }
    }

    public function storeMassiveFromContext($rows, Event $event, $context)
    {
        $users = $this->getUsersFromRows($rows);

        $isStored = $this->updateCertificationMassive($event, $users, $rows, $context);

        return array("success" => true, "isStored" => $isStored);
    }

    private function getUsersFromRows($rows)
    {
        $dnis_array = Arr::pluck($rows, 'dni');
        return User::whereIn('dni', $dnis_array)->get(['id', 'dni']);
    }

    private function updateCertificationMassive(Event $event, $users, $rows, $context)
    {
        $isStored = false;

        foreach ($users as $key => $user) {
            $certification = $event->certifications->where('user_id', $user->id)->first();

            if ($certification) {
                if ($this->updateMassiveFromContext($certification, $rows, $key, $context)) {
                    $isStored = true;
                }
            }
        }

        return $isStored;
    }

    private function updateMassiveFromContext(Certification $certification, $rows, $key, $context)
    {
        if ($context == 'score') {
            return $certification->update([
                'score' => $rows[$key]['nota']
            ]);
        }
        else if ($context == 'area') {
            return $certification->update([
                'area' => $rows[$key]['area'],
                'observation' => $rows[$key]['observacion']
            ]);
        }

        return null;
    }






    // ----------------- CERTIFICATION MODULE ------------------------


    public function getCertificationDataTable(Request $request)
    {
        $query = Certification::with(['user', 'company', 'event.exam.course'])
                                ->where('status', 'finished')
                                ->where('evaluation_type', 'certification')
                                ->select('certifications.*');

        if ($request->filled('status')) {
            if ($request['status'] == 'approved') {
                $query->whereHas('event', function ($q) {
                    $q->whereRaw('certifications.score >= events.min_score');
                });
            } else if ($request['status'] == 'suspended') {
                $query->whereHas('event', function ($q) {
                    $q->whereRaw('certifications.score < events.min_score');
                });
            }
        }

        if ($request->filled('from_date') && $request->filled('end_date')) {
            $query->whereHas('event', function ($q2) use ($request) {
                $q2->whereBetween('date', [$request->from_date, $request->end_date]);
            });
        }

        if ($request->filled('company')) {
            $query->where('company_id', $request['company']);
        }

        if ($request->filled('course')) {
            $query->whereHas('event.exam', function ($q3) use ($request) {
                $q3->where('course_id', $request['course']);
            });
        }

        $allCertifications = DataTables::of($query)
            ->editColumn('certifications.id', function ($certification) {
                return $certification->id;
            })
            ->editColumn('user.name', function ($certification) {
                return $certification->user->full_name_complete;
            })
            ->editColumn('company.description', function ($certification) {
                return $certification->company == null ? '-' : $certification->company->description;
            })
            ->editColumn('event.description', function ($certification) {
                return '<a href="'. route('admin.events.show', ['event' => $certification->event]) .'">'. 
                            $certification->event->description 
                        .'</a>';
            })
            ->editColumn('score', function ($certification) {
                return $certification->score ?? '-';
            })
            ->addColumn('exam', function ($certification) {
                $exam_icon = '<a href="'. route('pdf.certification.exam', $certification) .'" target="_BLANK">
                                    <img src="'. asset('assets/common/img/exam-icon.svg') .'" 
                                    alt="examen-'. $certification->id .'"
                                    style="width:30px;">
                                </a>';

                return $exam_icon;
            })
            ->addColumn('certification', function ($certification) {

                if ($certification->score >= $certification->event->min_score ) {

                    $certification_icon = '<a href="">
                                                <img src="'. asset('assets/common/img/certification-icon.svg') .'"
                                                alt="certificado-'. $certification->id .'" 
                                                style="width:30px;">
                                          </a>';
                } else {
                   $certification_icon = '-';
                }

                return $certification_icon;
            })
            ->rawColumns(['exam', 'event.description','certification'])
            ->make(true);

        return $allCertifications;
    }

}
