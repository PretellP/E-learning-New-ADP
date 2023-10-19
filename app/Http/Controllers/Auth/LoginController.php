<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Providers\RouteServiceProvider;
use App\Services\Auth\{AuthService};
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Exception;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;

    public function redirectTo(Request $request)
    {
        $redirect_route = $this->getRedirectRoute($request);

        switch(Auth::user()->role)
        {
            case 'admin':
            case 'security_manager':
            case 'super_admin':
            case 'supervisor':
            case 'technical_support':
                $this->redirectTo = route('admin.home.index');
                return $this->redirectTo;
                break;
            case 'participants':
            case 'instructor':
                $this->redirectTo = $redirect_route;
                return $this->redirectTo;
                break;
            default:
                $this->redirectTo = '/login';
                return $this->redirectTo;
        }
    }
        /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath(Request $request)
    {
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo($request);
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
    }

        /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect()->intended($this->redirectPath($request));
    }

    public function validateAttempt(AuthService $authService, Request $request)
    {
        parse_str($request['form'], $form);
        $formRequest = new Request($form);

        $message = NULL;

        try {
            $success = $authService->validateAttempt($formRequest);
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return response()->json([
            "success" => $success,
            "message" => $message,
        ]);
    }

    public function getRedirectRoute(Request $request)
    {
        if ($request->has('redirect_location')) {
            switch ($request['redirect_location'])
            {
                case 'classroom':
                    $redirect_route = route('aula.index');
                    break;
                case 'home' :
                    $redirect_route = route('home.principal');
                    break;
                default: 
                    $redirect_route = route('home.principal');
            }
        }
        else {
            $redirect_route = route('home.index');
        }

        return $redirect_route;
    }

    public function username()
    {
        return 'dni';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
