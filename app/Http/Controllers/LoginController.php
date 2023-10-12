<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();


            $token = $user->createToken('Token Name')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'Login berhasil',
                'data' => [
                    'user' => $user,
                    'token' => $token
                ]
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Login gagal. Nama pengguna atau kata sandi tidak valid.'
            ], 401); // 401 adalah status HTTP untuk Unauthorized
        }
    }
}
