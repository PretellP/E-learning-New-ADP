<?php

namespace App\Services;

use App\Models\{User};
use Yajra\DataTables\Facades\DataTables;

class UserService
{
    public function getDataTable()
    {
        $allUsers = DataTables::of(User::with('company:id,description')
                                            ->withCount([
                                                    'events',
                                                    'certifications',
                                                    'publishings',
                                                    'userSurveys']
                                            ))
                    ->addColumn('name', function($user){
                        return $user->full_name;
                    })
                    ->editColumn('role', function($user){
                        return config('parameters')['roles'][$user->role];
                    })
                    ->editColumn('company.description', function($user){
                        $company = $user->company == null ? '' : $user->company->description;

                        return $company;
                    })
                    ->addColumn('status-btn', function($user){
                        $status = $user->active == 'S' ? 'active' : 'inactive';
                        $txtBtn = $status == 'active' ? 'Activo' : 'Inactivo';
                        $statusBtn = '<span class="status '.$status.'">'.$txtBtn.'</span>';

                        return $statusBtn;
                    })
                    ->addColumn('action', function($user){
                        $btn = '<button data-toggle="modal" data-id="'.
                                $user->id.'" data-url="'.route('admin.user.update', $user).'" 
                                data-send="'.route('admin.user.edit', $user).'"
                                data-original-title="edit" class="me-3 edit btn btn-warning btn-sm
                                editUser"><i class="fa-solid fa-pen-to-square"></i></button>';
                        if($user->events_count == 0 &&
                            $user->certifications_count == 0 &&
                            $user->publishings_count == 0 &&
                            $user->user_surveys_count == 0)
                        {
                            $btn.= '<a href="javascript:void(0)" data-id="'.
                                    $user->id.'" data-original-title="delete"
                                    data-url="'.route('admin.user.delete', $user).'" class="ms-3 edit btn btn-danger btn-sm
                                    deleteUser"><i class="fa-solid fa-trash-can"></i></a>';
                        }
                    
                        return $btn;
                    })
                    ->rawColumns(['status-btn', 'action'])
                    ->make(true);

        return $allUsers;
    }
}
