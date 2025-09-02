<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Register view for 'user' role
    public function registerForm(Request $request)
    {
        if (!$request->filled(['username', 'no_telp'])) {
            return redirect()->route('user.login-view');
        }

        return spaRender($request, 'Lengkapi Data Pendaftaran', 'layouts.auth.content', 'pages.auth.register');
    }

    // Register logic for 'user' role
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:profiles,username_1',
            'no_telp'  => 'required|string|numeric|unique:profiles,no_telp',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => Role::where('name', 'user')->first()->id,
        ]);

        Profile::create([
            'username_1' => $request->username,
            'no_telp'    => $request->no_telp,
            'user_id'    => $user->id,
        ]);

        // Trigger event so Laravel sends verification email
        event(new Registered($user));

        Auth::login($user);

        return response()->json([
            'status'  => 'success',
            'message' => 'Registrasi berhasil! Silakan cek email untuk verifikasi.',
            'redirect' => route('verification.notice'),
        ]);
    }

    // Verification notice for 'user' role
    public function verificationNotice(Request $request)
    {
        if ($request->user()?->hasVerifiedEmail()) {
            return redirect()->route($request->user()->role->direct ?? 'landing');
        }

        return spaRender($request, 'Verifikasi Email', 'layouts.auth.content', 'pages.auth.notice');
    }

    // Resend verification email for 'user' role
    public function resendVerification(Request $request)
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

    // Login view for 'user' role
    public function userLoginForm(Request $request)
    {
        return spaRender($request, 'Masuk/Daftar', 'layouts.auth.content', 'pages.auth.user');
    }

    // Login logic for 'user' role
    public function userLogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'no_telp'  => 'required|string|numeric',
        ]);

        $profile = Profile::where('username_1', $request->username)->where('no_telp', $request->no_telp)->first();

        if (!$profile) {
            return response()->json([
                'status' => 'register_required',
                'message' => 'Akun belum terdaftar! Silahkan lengkapi data',
                'redirect' => route('register-view', [
                    'username' => $request->username,
                    'no_telp' => $request->no_telp,
                ]),
            ]);
        } else {
            $user = $profile->user;
            Auth::login($user);

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil login!',
                'redirect' => route($user->role->direct ?? 'landing'),
            ]);
        }
    }

    public function adminLoginForm(Request $request)
    {
        return spaRender($request, 'Masuk/Daftar', 'layouts.auth.content', 'pages.auth.admin');
    }
}
