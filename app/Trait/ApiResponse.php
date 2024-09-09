<?php

namespace App\Trait;
trait ApiResponse
{
    protected function successResponse($data,$code = 200)
    {
        return response()->json([
            'status' => true,
            'data' => $data,
        ],$code);
    }
    protected function errorResponse($message,$code = 200)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
        ],$code);
    }
}
