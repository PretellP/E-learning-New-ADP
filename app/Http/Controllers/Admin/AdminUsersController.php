<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UserImportTemplate;
use App\Http\Controllers\Controller;
use App\Http\Requests\FileImportRequest;
use App\Http\Requests\UserRequest;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use App\Models\{User, Company, MiningUnit};
use App\Services\UserService;
use Exception;

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

    public function store(UserRequest $request)
    {
        $storage = env('FILESYSTEM_DRIVER');

        try {
            $this->userService->store($request, $storage);
            $success = true;
            $message = config('parameters.stored_message');
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return response()->json([
            "success" => $success,
            "message" => $message
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
        $user->loadAvatar();

        $role = config('parameters.roles')[$user->role] ?? '-';

        return response([
            "user" => $user,
            "role" => $role,
            "companies" => Company::get(['id','description']),
            "miningUnits" => MiningUnit::get(['id', 'description']),
            "miningUnitsSelect" => $user->miningUnits->pluck('id')->toArray(),
            "url_img" => verifyUserAvatar($user->file),
        ]);
    }

    public function update(Request $request, User $user)
    {
        $storage = env('FILESYSTEM_DRIVER');

        try {
            $success = $this->userService->update($request, $user, $storage);
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

    public function destroy(User $user)
    {
        $user->miningUnits()->detach();
        $user->progressChapters()->detach();
        $user->delete();

        return response()->json([
            "success" => true
        ]);
    }

    public function downloadImportTemplate()
    {
        $usersImportTemplate = new UserImportTemplate();

        return $usersImportTemplate->download('usuarios_plantilla_registro_masivo.xlsx');
    }

    public function massiveStore(FileImportRequest $request)
    {
        $note = NULL;
        
        $foundDuplicates = false;

        try {
            $usersImport = new UsersImport;
            $usersImport->import($request->file('file'));

            $success = true;
            $message = config('parameters.stored_message');

            if ($usersImport->failures()->isNotEmpty()) {
                $success = false;
                $message = 'Se encontró errores de validación';
            }
    
            if ($usersImport->getDuplicatedDnis()->isNotEmpty()) {
                $foundDuplicates = true;
                $note = 'Se encontraron DNIs duplicados';
                $notebody = $usersImport->getDuplicatedDnis();
            }

        } catch (Exception $e) {
            $success = false;
            $message = config('parameters.exception_message');
        }

        return response()->json([
            "success" => $success,
            "message" => $message,
            'foundDuplicates' => $foundDuplicates,
            'note' => $note,
            'notebody' => $notebody
        ]);
    }
}
