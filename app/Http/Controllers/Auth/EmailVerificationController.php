<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    // Verification notice for 'user' role
    public function notice(Request $request)
    {
        if ($request->user()?->hasVerifiedEmail()) {
            return redirect()->route($request->user()->role->direct ?? 'user.dashboard');
        }

        return spaRender($request, 'pages.auth.notice');
    }

    // Resend verification email for 'user' role
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json([
                'status'   => 'success',
                'message'  => 'Email sudah terverifikasi.',
                'redirect' => route('home'),
            ]);
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json([
            'status'  => 'success',
            'message' => 'Link verifikasi baru sudah dikirim ke email kamu.',
        ]);
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        $user = $request->user();

        $user->load('role');
        return redirect()->route($user->role->redirect ?? 'user.dashboard');
    }
}
