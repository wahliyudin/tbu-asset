<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Traits\APITrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use APITrait;

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $auth = auth()->user();
                $success['token'] =  $auth->createToken('PassportAuth')->plainTextToken;
                $success['employee'] =  $auth;

                return $this->responseSuccess($success);
            } else {
                return $this->response([], false, 'Something went wrong', 400);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
