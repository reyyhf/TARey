<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponseTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use ApiResponseTrait,
        AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    protected function serviceResponseHandler($service)
    {
        try {
            return $service;
        } catch (\Throwable $th) {
            return $this->resultResponse('error', $th->getMessage(), 500);
        }
    }
}
