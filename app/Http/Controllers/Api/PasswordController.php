<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasswordController extends Controller
{
    public function forgotPassword(Request $request)
    {
        try {
            $validateEmail = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                ]
            );

            if ($validateEmail->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateEmail->errors()
                ], 401);
            }
    
            $status = Password::sendResetLink(
                $request->only('email')
            );

            if($status === Password::RESET_LINK_SENT) {
                return response()->json([
                    'status' => $status === Password::RESET_LINK_SENT,
                    'message' => "Reset password sent to email"
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'error' => $status
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $validateEmail = Validator::make(
                $request->all(),
                [
                    'token' => 'required',
                    'email' => 'required|email',
                    'password' => 'required',
                ]
            );

            if ($validateEmail->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateEmail->errors()
                ], 401);
            }

            $status = Password::reset(
                $request->only('email', 'password', 'token'),
                function ($user, $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));
        
                    $user->save();
        
                    event(new PasswordReset($user));
                }
            );

            if($status === Password::PASSWORD_RESET) {
                return response()->json([
                    'status' => true,
                    'message' => "Password has been successfully changed"
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'error' => $status
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $validateEmail = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'old_password' => 'required',
                    'new_password' => 'required|confirmed'
                ]
            );

            if ($validateEmail->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateEmail->errors()
                ], 401);
            }

            if(!Hash::check($request->old_password, auth()->user()->password)){
                return response()->json([
                    'status' => false,
                    'message' => 'Old Password Doesnt match.'
                ], 401);
            }

            User::whereId(auth()->user()->id)->update([
                'password' => Hash::make($request->new_password)
            ]);

            return response()->json([
                'status' => true,
                'message' => "Password has been successfully changed"
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
