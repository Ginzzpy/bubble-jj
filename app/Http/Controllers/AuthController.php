<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Role;
use App\Models\Viewer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function adminLoginForm()
    {
        return view('pages.auth.admin-login');
    }

    public function viewerLoginForm()
    {
        return view('pages.auth.viewer-login');
    }

    public function login(Request $request)
    {
        if ($request->has('password')) {
            // Admin login logic
            $credentials = $request->validate([
                'username' => 'required',
                'password' => 'required|string',
            ]);

            $admin = Admin::where('username', $credentials['username'])->first();

            if (!$admin) {
                return back()->withErrors([
                    'username' => 'Username tidak ditemukan.',
                ])->onlyInput('username');
            }

            if (!Auth::guard('admin')->attempt($credentials)) {
                return back()->withErrors([
                    'password' => 'Masukkan kata sandi yang benar.',
                ])->onlyInput('password');
            }

            Auth::guard('admin')->login($admin);
            $request->session()->regenerate();
            $redirect = $admin->role->direct ?? 'dashboard';
            return redirect()->route($redirect);
        } else if ($request->has('no_telp')) {
            // Validasi input
            $credentials = $request->validate([
                'username' => 'required',
                'no_telp'  => 'required|string',
            ]);

            $viewer = Viewer::where('username1', $credentials['username'])
                ->where('no_telp', $credentials['no_telp'])
                ->first();

            // === CASE 1: Kombinasi ada (user lama) ===
            if ($viewer) {
                Auth::guard('viewer')->login($viewer);
                $request->session()->regenerate();
                $redirect = $viewer->role->direct ?? 'upload';

                if (is_null($viewer->password)) {
                    // User lama tapi belum pernah set password
                    return redirect()->route($redirect)->with('set_password_required', true);
                }

                return redirect()->route($redirect)->with('success', 'Login berhasil, selamat datang!');
            }

            // === CASE 2: Username ada tapi no_telp tidak cocok ===
            if (Viewer::where('username1', $credentials['username'])->exists()) {
                return back()->withErrors([
                    'no_telp' => 'Nomor Whatsapp tidak cocok dengan username ini.',
                ])->onlyInput('no_telp');
            }

            // === CASE 3: No_telp ada tapi username tidak cocok ===
            if (Viewer::where('no_telp', $credentials['no_telp'])->exists()) {
                return back()->withErrors([
                    'username' => 'Username tidak cocok dengan nomor Whatsapp ini.',
                ])->onlyInput('username');
            }

            // === CASE 4: Belum ada → buat akun baru ===
            $viewer = Viewer::create([
                'username1' => $credentials['username'],
                'no_telp'   => $credentials['no_telp'],
                'role_id'   => Role::where('name', 'viewer')->first()->id,
                'password'  => null, // default null
            ]);

            Auth::guard('viewer')->login($viewer);
            $request->session()->regenerate();
            $redirect = $viewer->role->direct ?? 'upload';

            session(['set_password_required' => true]);
            return redirect()->route($redirect);
        }
    }

    public function verifyPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $viewer = Auth::guard('viewer')->user();

        if (!Hash::check($request->password, $viewer->password)) {
            Alert::toast('Password salah.', 'error');
            return redirect()->back();
        }

        Alert::toast('Password benar!', 'success');
        return redirect()->route('viewer.account');
    }

    public function savePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        /** @var \App\Models\Viewer $viewer */
        $viewer = Auth::guard('viewer')->user();
        if (!$viewer) {
            $redirect = $viewer->role->direct ?? 'upload';
            Alert::toast('User tidak ditemukan.', 'error');
            return redirect()->route($redirect);
        }

        $viewer->update([
            'password' => Hash::make($request->password),
        ]);

        $request->session()->forget('set_password_required');

        $redirect = $viewer->role->direct ?? 'upload';
        Alert::toast('Password berhasil diset!', 'success');
        return redirect()->route($redirect);
    }


    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('viewer')->check()) {
            Auth::guard('viewer')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }
}
