<?php

namespace App\Services\Auth;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AuthService
{
    public function validateUserCredentials(Request $request)
    {
        return $this->validateRequest($request);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return boolean
     *
     */
    protected function validateRequest(Request $request)
    {
        return $request->validate([
                $this->username() => ['required','string',  
                                Rule::exists('users')->where(function ($q) {
                                    $q->where('dni', Auth::user()->dni)
                                        ->where('role', 'participants');
                                }),],
                'password' => 'required|string|current_password',
            ]);
    }

     /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function validateAttempt(Request $request)
    {
        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {

            return true;
        }

        return false;
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => ['required','string',
                                Rule::exists('users')->where(function($q){
                                    $q->where('role', 'participants');
                                })],
            'password' => 'required|string',
        ]);
    }

      /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request) 
    {
        if (Auth::attempt($this->credentials($request))) {
            return true;
        }

        return false;
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    protected function username()
    {
        return 'dni';
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}