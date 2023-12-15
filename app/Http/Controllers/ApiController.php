<?php

namespace App\Http\Controllers;

class ApiController extends Controller
{
    protected function jsonResponse($data = null, $message = null,  $statusCode = 200)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
        ], $statusCode);
    }

    protected function successResponse($data = null, $message = 'Success', $statusCode = 200)
    {
        return $this->jsonResponse($data, $message, $statusCode);
    }


}
