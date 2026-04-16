<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            if ($request->wantsJson()) {
                return response()->json($validator->errors(), 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        // Coba login
        $attempt = Auth::attempt($request->only('email', 'password'));
        
        if ($attempt) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($request->wantsJson()) {
                $token = $user->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'message' => 'Login berhasil',
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'data' => $user
                ]);
            }
            
            // Tampilkan pesan sukses login dan info redirect memakai URL langsung menghindari bentrok nama Route dengan API
            if (strtolower(str_replace(' ', '', $user->role)) === 'superadmin') {
                return redirect('/superadmin/pasar')->with('success', 'Selamat datang Super Admin!');
            }
            return redirect('/admin/pasar')->with('success', 'Berhasil login sebagai Admin!');
        }

        // Jika salah email/password
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Email atau password salah.'
            ], 401);
        }

        return back()->with('error', 'Email atau password salah!')->withInput();
    }

    public function logout(Request $request)
    {
        // Hapus token jika login via API
        if ($request->user() && $request->user()->currentAccessToken()) {
            $request->user()->currentAccessToken()->delete();
        }

        // Logout session web
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Logout berhasil.'
            ]);
        }

        return redirect('/login')->with('success', 'Anda telah berhasil logout.');
    }
}
