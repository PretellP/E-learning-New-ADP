<?php

namespace App\Http\Controllers\Aula\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\UserService;
use Auth;
use Exception;

class AulaProfileController extends Controller
{
    private $userService;

    public function __construct(UserService $service)
    {
        $this->userService = $service;
    }

    public function index()
    {
        $user = Auth::user();

        return view('aula.common.profile.index', [
            'user' => $user
        ]);
    }

    public function editUserAvatar (User $user) 
    {
        $user->loadAvatar();
        $url_img = verifyUserAvatar($user->file);

        return response()->json([
            "url_img" => $url_img
        ]);
    }

    public function updateUserAvatar(Request $request, User $user)
    {
        $user->loadAvatar();

        $storage = env('FILESYSTEM_DRIVER');
        $htmlAvatar = NULL;
        $htmlAside = NULL;

        try {
            $success = $this->userService->updateUserAvatar($request, $user, $storage);
            $message = config('parameters.updated_message');
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        if ($success) {
            $htmlSidebarAvatar = view('aula.common.partials.boxes._sidebar_profile_image')->render();
            $htmlAvatar = view('aula.common.profile.partials.boxes._profile_image', compact('user'))->render();
        }

        return response()->json([
            "success" => $success,
            "message" => $message,
            "htmlAvatar" => $htmlAvatar,
            "htmlSidebarAvatar" => $htmlSidebarAvatar
        ]);
    }

    public function updatePassword(Request $request, User $user)
    {
        $htmlForm = NULL;

        try {
            $success = $this->userService->updatePassword($request, $user);
            $message = config('parameters.updated_message');
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        if ($success) {
            $htmlForm = view('aula.common.profile.partials.boxes._form_update_password')->render();
        }

        return response()->json([
            "success" => $success,
            "message" => $message,
            "htmlForm" => $htmlForm
        ]);
    }
}
