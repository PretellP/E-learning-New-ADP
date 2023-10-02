<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Company, MiningUnit};
use App\Services\UserService;

class AdminUsersController extends Controller
{
    private $userService;

    public function __construct(UserService $service)
    {
        $this->userService = $service;
    }

    public function index(Request $request)
    {
        if($request->ajax())
        {   
            return $this->userService->getDataTable();
        }else{
            $miningUnits =  MiningUnit::get(['id','description']);
            $roles = config('parameters')['roles'];
            
            return view('admin.users.index', compact(
                'miningUnits',
                'roles'
            ));
        } 
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

        $user = User::create([
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

        $user->miningUnits()->sync($request['id_mining_units']);

        return response()->json([
            "success" => "stored successfully"
        ]);
    }  
    
    public function editValidateDni(Request $request)
    {
        $id = $request['id'];
        $user = User::where('dni', $request['dni'])->first();

        return $user == null ||
                $user->id == $id ?
                'true' : 'false';
    }

    public function edit(User $user)
    {
        $role = config('parameters')['roles'][$user->role];

        return response([
            "user" => $user,
            "role" => $role,
            "companies" => Company::get(['id','description']),
            "miningUnits" => MiningUnit::get(['id', 'description']),
            "miningUnitsSelect" => $user->miningUnits->pluck('id')->toArray(),
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

        $user->miningUnits()->sync($request['id_mining_units']);

        return response()->json([
            "success" => "updated successfully"
        ]);
    }

    public function destroy(User $user)
    {
        $user->miningUnits()->detach();
        $user->delete();

        return response()->json([
            "success" => true
        ]);
    }
}
