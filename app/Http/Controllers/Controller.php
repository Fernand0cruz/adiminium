<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

abstract class Controller
{
    public function success($data = [], $message = 'Success', $status = 200)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    public function error($message = 'Error', $status = 500)
    {
        Log::error($message);
        return response()->json([
            'status' => false,
            'message' => $message
        ], $status);
    }
}

