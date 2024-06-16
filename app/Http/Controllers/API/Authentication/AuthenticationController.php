<?php

namespace App\Http\Controllers\API\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Authentication\LoginValidation;
use App\Http\Services\Authentication\AuthenticationService;

class AuthenticationController extends Controller
{
    protected $service;

    public function __construct(AuthenticationService $service)
    {
        $this->service = $service;
    }

    public function login(LoginValidation $request)
    {
        $inputData = $request->validated();

        $login = $this->service->login($inputData);

        return $this->serviceResponseHandler($login);
    }

    public function currentUser()
    {
        $currentUser = $this->service->currentUser();

        return $this->serviceResponseHandler($currentUser);
    }

    public function logout()
    {
        $logout = $this->service->logout();

        return $this->serviceResponseHandler($logout);
    }
}
