<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    public function showForgotPasswordForm() {
        return view('auth.forgot-password');
    }

    public function sendResetOTP(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $otp = rand(100000, 999999);
        $expiresAt = Carbon::now()->addMinutes(1); 

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['otp' => $otp, 'expires_at' => $expiresAt, 'created_at' => now()]
        );

        Mail::raw("Your OTP is: $otp. It expires in 1 minute.", function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Password Reset OTP');
        });

        return redirect()->route('reset.password.form', ['email' => $request->email])
                         ->with('success', 'OTP sent to your email.');
    }

    

    public function showResetForm($email) {
        return view('auth.reset-password', compact('email'));
    }

    public function resetPassword(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|digits:6',
            'password' => 'required|min:6|confirmed',
        ]);

        $reset = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();

        if (!$reset) {
            return back()->with('error', 'Invalid OTP or OTP expired.');
        }

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password),
        ]);

        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect('adminlogin')->with('success', 'Password reset successful.');
    }
}
