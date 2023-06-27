<?php

namespace App\Traits;

trait APITrait
{
    public function response(mixed $data = [], bool $status = true, string $message = '', $code = 200)
    {
        return response()->json([
            'status' => $status,
            'data' => $data,
            'message' => $message,
        ],  $code);
    }

    public function responseSuccess(mixed $data)
    {
        return $this->response($data);
    }
}
