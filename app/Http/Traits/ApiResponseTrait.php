<?php

namespace App\Http\Traits;


use Symfony\Component\HttpFoundation\Response;

trait ApiResponseTrait
{
    public function index()
    {
    }

    public function returnError($errNum = 400, $msg)
    {
        return response()->json([
            'status' => 'failure',
            'errNum' => $errNum,
            'message' => $msg
        ], Response::HTTP_OK);
    }

    public function returnErrorWithData($data, $errNum = 400, $msg)
    {
        return response()->json([
            'status' => 'failure',
            'errNum' => $errNum,
            'data' => $data,
            'message' => $msg
        ], Response::HTTP_OK);
    }

    public function returnValidationErrors($errors, $msg = "")
    {
        return response()->json([
            'status' => 'failure',
            'errNum' => 422,
            'message' => $msg,
            'errors' => $errors
        ], 200);
    }

    public function returnSuccess($msg = "")
    {
        return response()->json([
            'status' => 'success',
            'message' => $msg
        ], Response::HTTP_OK);
    }

    public function returnData($data, $msg = "")
    {
        return response()->json([
            'status' => 'success',
            'message' => $msg,
            'data' => $data
        ], Response::HTTP_OK);
    }
}
