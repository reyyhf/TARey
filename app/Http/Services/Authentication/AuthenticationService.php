<?php

namespace App\Http\Services\Authentication;

use App\Exceptions\ErrorAPIException;
use App\Helpers\ApiResponseTrait;
use App\Http\Resources\User\UserResource;
use Illuminate\Support\Str;

class AuthenticationService
{
    use ApiResponseTrait;

    public function login($attributes)
    {
        $credentials = [
            'email' => $attributes['email'],
            'password' => $attributes['password'],
        ];

        $login = auth()->attempt($credentials);

        if (! $login) {
            throw new ErrorAPIException('Email atau Password salah', 400);
        }

        $tokenIdentifier = Str::uuid();

        $accessToken = auth()->user()->createToken($tokenIdentifier);

        $authenticatedResponse = [
            'access_token' => $accessToken->plainTextToken,
        ];

        return $this->resultResponse('success', 'Anda Berhasil Login', 200, $authenticatedResponse);
    }

    public function currentUser()
    {
        $authenticated = auth()->user();

        $user = new UserResource($authenticated);

        return $this->resultResponse('success', 'Data Berhasil Didapatkan', 200, $user);
    }

    public function logout()
    {
        $authenticated = auth()->user();

        $authenticated->tokens()->delete();

        return $this->resultResponse('success', 'Anda Berhasil Keluar Dari Aplikasi', 200);
    }
}
