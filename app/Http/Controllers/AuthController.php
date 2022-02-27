<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Auth;
use Validator;

class AuthController extends Controller
{
    public function register(Request $request){
        $validateData = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $validateData);

        if($validator->fails()){
            return response()->json([
                'message' => 'Error'
            ], 401);
        } else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'message'=>'berhasil daftar',
                'token_type' => 'Bearer'
            ], 200);
        }
    }

    public function login(Request $request){
        if(!Auth::attempt($request->only('email', 'password'))){
            return response()->json([
                'message' => 'Invalid Login Details'
            ], 401);
        } else {
            $user = User::where('email', $request->email)->firstOrFail();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'message'=>'berhasil login',
                'token_type' => 'Bearer'
            ], 200);
        }
    }

    public function logout(){
        auth()->user()->tokens()->delete();
        $response = [
            'status'=> true,
            'message'=>'berhasil logout',
        ];
        return response($response,201);
    }

    public function guest(){
        return response()->json([
            'error' => 'login dulu ya'
        ], 401);
    }
}
