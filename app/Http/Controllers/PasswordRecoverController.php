<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordRecoverController extends Controller
{

    public function passwordRecover(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink(
            $request->only('email')
        );
        return $status === Password::RESET_LINK_SENT
            ?response()->json([
                'message' => __($status)
            ])
            : response()->json([
                'message' => __($status)
            ],403);
    }

    public function changePasswordByUser(Request $request, $token)
    {
        if ($request->method() === 'GET') {
            $makeClientUrl = config()['app']['client_url'] . '/password-change/' . $token . '?email='.$request->email;
            return redirect($makeClientUrl);
        } else {

            return $this->changePassUser($request);
        }
    }


    private function changePassUser($request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => $password
                ]);
                $user->save();
                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json([
                'message' => __($status)
            ])
            : response()->json([
                'message' => __($status)
            ], 403);
    }
}
