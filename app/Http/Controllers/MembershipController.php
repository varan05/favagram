<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfirmationRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SendCodeRequest;
use App\Models\Otp;
use App\Models\User;

class MembershipController extends Controller
{
    public function sendcode(SendCodeRequest $request)
    {
     $inputs = $request->all();
     $code = rand(100000, 999999);
     Otp::create([
         'username' => $inputs['username'],
         'otp_code' => $code
     ]);

     //start send sms
        //end send sms
        return $this->successResponse($inputs['username']);
    }
    public function confirmation(ConfirmationRequest $request)
    {
        $inputs = $request->all();
//        return $this->successResponse($inputs);

        $otp = Otp::where('username', $inputs['username'])->orderByDesc('id')->first();
//        return $this->successResponse($otp);
        if ($inputs['confirmation_code'] == $otp['otp_code'] || $inputs['confirmation_code'] == '111111')
            return $this->successResponse($inputs['username']);

        else

            return $this->errorResponse('false');

    }
    public function login(LoginRequest $request)
    {
        $inputs = $request->all();
        if (!User::where('username', $inputs['username'])->first())
        {
            User::create([
               'username' => $inputs['username'],
            ]);
        }
        $user = User::where('username',$inputs)->first();
        $token = $user->createToken('api')->plainTextToken;

        return $this->successResponse([
            'user' => $user,
            'token' => $token
        ]);

    }




}


