<?php

namespace App\Services;

use App\Models\{User};
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class UserService
{
    public function getDataTable()
    {
        $allUsers = DataTables::of(User::with('company:id,description')
            ->withCount(
                [
                    'events',
                    'certifications',
                    'publishings',
                    'userSurveys'
                ]
            ))
            ->addColumn('name', function ($user) {
                return $user->full_name;
            })
            ->editColumn('role', function ($user) {
                return config('parameters.roles')[$user->role] ?? '-';
            })
            ->editColumn('company.description', function ($user) {
                $company = $user->company == null ? '-' : $user->company->description;

                return $company;
            })
            ->addColumn('status-btn', function ($user) {
                $status = $user->active == 'S' ? 'active' : 'inactive';
                $txtBtn = $status == 'active' ? 'Activo' : 'Inactivo';
                $statusBtn = '<span class="status ' . $status . '">' . $txtBtn . '</span>';

                return $statusBtn;
            })
            ->addColumn('action', function ($user) {
                $btn = '<button data-toggle="modal" data-id="' .
                    $user->id . '" data-url="' . route('admin.user.update', $user) . '" 
                                data-send="' . route('admin.user.edit', $user) . '"
                                data-original-title="edit" class="me-3 edit btn btn-warning btn-sm
                                editUser"><i class="fa-solid fa-pen-to-square"></i></button>';
                if (
                    $user->events_count == 0 &&
                    $user->certifications_count == 0 &&
                    $user->publishings_count == 0 &&
                    $user->user_surveys_count == 0
                ) {
                    $btn .= '<a href="javascript:void(0)" data-id="' .
                        $user->id . '" data-original-title="delete"
                                    data-url="' . route('admin.user.delete', $user) . '" class="ms-3 edit btn btn-danger btn-sm
                                    deleteUser"><i class="fa-solid fa-trash-can"></i></a>';
                }

                return $btn;
            })
            ->rawColumns(['status-btn', 'action'])
            ->make(true);

        return $allUsers;
    }

    public function store(Request $request, $storage)
    {
        $data = normalizeInputStatus($request->all());

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data + [
            "signature" => "N",
            "profile_survey" => "N"
        ]);

        if ($user) {

            // $user->miningUnits()->sync($request['id_mining_units']);

            if ($request->hasFile('image')) {

                $file_type = 'imagenes';
                $category = 'avatars';
                $belongsTo = 'avatars';
                $relation = 'one_one';

                $file = $request->file('image');

                return app(FileService::class)->store(
                    $user,
                    $file_type,
                    $category,
                    $file,
                    $storage,
                    $belongsTo,
                    $relation
                );
            }

            return $user;
        }

        throw new Exception(config('parameters.exception_message'));
    }

    public function update (Request $request, User $user, $storage) 
    {
        $data = normalizeInputStatus($request->all());

        $data['password'] = $data['password'] == NULL ? $user->password : Hash::make($data['password']);

        if ($user->update($data)) {
            
            // $user->miningUnits()->sync($request['id_mining_units']);

            return $this->updateUserAvatar($request, $user, $storage);
        }

        throw new Exception(config('parameters.exception_message'));
    }

    public function selfRegister(Request $request)
    {
        $data = $request->validated();

        $password = $this->generatePassword();

        $user = User::create($data + [
            "signature" => "N",
            "active" => "S",
            "profile_survey" => 'N',
            "role" => 'participants',
            "password" => Hash::make($password)
        ]);

        if ($user) {
            // if ($user->miningUnits()->sync($request['mining_units_ids'])) {

                app(EmailService::class)->sendUserCredentialsMail($user, $password);

                return $user;
            // };
        }

        throw new Exception(config('parameters.exception_message'));
    }

    public function generatePassword()
    {
        return Str::random(8);
    }

    public function updateUserAvatar(Request $request, User $user, $storage)
    {
        if ($request->hasFile('image')) {

            app(FileService::class)->destroy($user->file, $storage);

            $file_type = 'imagenes';
            $category = 'avatars';
            $file = $request->file('image');
            $belongsTo = 'avatars';
            $relation = 'one_one';

            return app(FileService::class)->store(
                $user,
                $file_type,
                $category,
                $file,
                $storage,
                $belongsTo,
                $relation
            );
        }

        return true;
    }

    public function updatePassword(Request $request, User $user)
    {
        if ($this->validateUpdatePasswordRequest($request)) {

            return $user->update([
                "password" => Hash::make($request['new_password'])
            ]);
        }

        return false;
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return boolean
     *
     */
    protected function validateUpdatePasswordRequest(Request $request)
    {
        return $request->validate([
            'old_password' => 'required|string|current_password',
            'new_password' => ['required', 'string'],
        ]);
    }
}
