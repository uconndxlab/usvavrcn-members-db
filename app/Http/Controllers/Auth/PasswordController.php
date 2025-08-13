<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Mockery\Generator\StringManipulation\Pass\Pass;

class PasswordController extends Controller
{

    // User clicks "Forgot Password"
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    // User submits email for password reset
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        try {
            $status = $user ? Password::sendResetLink(
                $request->only('email')
            ) : Password::INVALID_USER;
        } catch(\Throwable $e) {
            Log::error('Password reset error: ' . $e->getMessage());
            return back()->withErrors(['email' => 'An error occurred while sending the password reset link.']);
        }

        return $status === Password::ResetLinkSent
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    // Automatically links to this page through sent email link
    public function showResetPassword(Request $request, $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    // User submits new password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
