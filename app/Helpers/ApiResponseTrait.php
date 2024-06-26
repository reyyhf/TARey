<?php

namespace App\Helpers;

trait ApiResponseTrait
{
    public function resultResponse($status, $message, $code, $data = null)
    {
        $response = [
            'meta' => [
                'status' => $status,
                'message' => $message,
            ],
        ];

        $response = array_merge($response, ['data' => $data]);

        return response()->json($response, $code);
    }
}
