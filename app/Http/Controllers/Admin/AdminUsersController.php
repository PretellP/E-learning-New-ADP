<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Company};

class AdminUsersController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax())
        {   
            $allUsers = DataTables::of(User::query()
                                        ->with(['company:id,description', 
                                                'events:id,user_id',
                                                'certifications:id,user_id',
                                                'publishings:id,user_id',
                                                'userSurveys:id,user_id']
                                        ))
                    ->addColumn('name', function($user){
                        return $user->name.' '.$user->paternal;
                    })
                    ->editColumn('role', function($user){
                        switch($user->role){
                            case 'admin':
                                $role = 'Administrador';
                                break;
                            case 'super_admin':
                                $role = 'Super Admin';
                                break;
                            case 'security_manager':
                                $role = 'Ingeniero de seguridad';
                                break;
                            case 'security_manager_admin':
                                $role = 'Gerente de seguridad';
                                break;
                            case 'supervisor':
                                $role = 'Supervisor';
                                break;
                            case 'technical_support':
                                $role = 'Soporte técnico';
                                break;
                            case 'participants':
                                $role = 'Participante';
                                break;
                            case 'instructor':
                                $role = 'Instructor';
                                break;
                            default:
                                $role = '';
                        }
                        return $role;
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
                        if($user->events->isEmpty() &&
                            $user->certifications->isEmpty() &&
                            $user->publishings->isEmpty() &&
                            $user->userSurveys->isEmpty())
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

        return view('admin.users.index');
    }

    public function registerGetCompanies()
    {
        $companies = Company::get(['id','description']);

        return response()->json([
            "companies" => $companies
        ]);
    }

    public function registerValidateDni(Request $request)
    {
        $valid = User::where('dni', $request['dni'])->first() == null ? "true" : "false";

        return $valid;
    }

    public function store(Request $request)
    {
        $status = $request['userStatusCheckbox'] == 'on' ? 'S' : 'N';

        User::create([
            "url_img" => "storage/img/user_avatar/default.png",
            "dni" => $request['dni'],
            "name" => $request['name'],
            "paternal" => $request['paternal'],
            "maternal" => $request['maternal'],
            "email" => $request['email'],
            "password" => Hash::make($request['password']),
            "telephone" => $request['phone'],
            "role" => $request['role'],
            "cip" => $request['cip'],
            "signature" => "N",
            "active" => $status,
            "company_id" => $request['company'],
            "position"  => $request['position'],
            "profile_survey" => 'N'
        ]);

        return response()->json([
            "success" => "stored successfully"
        ]);
    }  
    
    public function editValidateDni(Request $request)
    {
        $valid = 'false';
        $id = $request['id'];
        $user = User::where('dni', $request['dni'])->first();

        if($user == null){
            $valid = 'true';
        }
        elseif($user->id == $id){
            $valid = 'true';
        }

        return $valid;
    }

    public function edit(User $user)
    {
        switch($user->role){
            case 'admin':
                $role = 'Administrador';
                break;
            case 'super_admin':
                $role = 'Super Admin';
                break;
            case 'security_manager':
                $role = 'Ingeniero de seguridad';
                break;
            case 'security_manager_admin':
                $role = 'Gerente de seguridad';
                break;
            case 'supervisor':
                $role = 'Supervisor';
                break;
            case 'technical_support':
                $role = 'Soporte técnico';
                break;
            case 'participants':
                $role = 'Participante';
                break;
            case 'instructor':
                $role = 'Instructor';
                break;
            default:
                $role = '';
        }

        return response([
            "user" => $user,
            "role" => $role,
            "companies" => Company::get(['id','description'])
        ]);
    }

    public function update(Request $request, User $user)
    {
        $password = $request['password'] == '' ? $user->password : Hash::make($request['password']);
        $status = $request['userStatusCheckbox'] == 'on' ? 'S' : 'N';

        $user->update([
            "dni" => $request['dni'],
            "name" => $request['name'],
            "paternal" => $request['paternal'],
            "maternal" => $request['maternal'],
            "email" => $request['email'],
            "password" => $password,
            "telephone" => $request['phone'],
            "role" => $request['role'],
            "cip" => $request['cip'],
            "active" => $status,
            "company_id" => $request['company'],
            "position" => $request['position'],
        ]);

        return response()->json([
            "success" => "updated successfully"
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            "success" => true
        ]);
    }
}
