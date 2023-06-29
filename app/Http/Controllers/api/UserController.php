<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function readAll()
    {
        $users = User::all();
        return response()->json([
            'success' => true,
            'message' => 'User berhasil ditampilkan',
            'data' => $users
        ], 200);
    }

    function register(Request $request){

        try {
        $this->validate($request, [
            'username' => 'required|min:4|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ]);

        $user = User::create([
            'username' => $request->username,
            'email'=> $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil ditambahkan',
            'data' => $user,
        ], 201);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to register user',
            'error' => $e->getMessage()
        ], 500);
    
    }
    }
    
    function login(Request $request) {
        if(!Auth::attempt($request->only('email','password'))){
            return response()->json([
                'success' => false,
                'message' => 'Login gagal',
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => $user,
            'token' => $token
        ], 200);

    }
}
