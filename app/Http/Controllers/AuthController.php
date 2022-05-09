<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username' => 'required|unique:users',
            'nama' => ['required'],
            'password' => ['required'],
            'role' => ['required'],
            'confirm_password' => ['required']
            ]);
            
            if ($validator->fails()) {
                $response = [
                    'message' => 'Username sudah terdaftar',
                    'status' => 2,
                    'validator' => $validator->errors()
                ];
                return response()->json($response, Response::HTTP_OK);
            }

            if ($request->password != $request->confirm_password) {
                $response = [
                    'message' => 'Password harus sama',
                    'status' => 0
                ];
                        
                return response()->json($response, Response::HTTP_CREATED);
            }

            $aktekelahiran = User::create([
                'username' => $request->username,
                'nama' => $request->nama,
                'role' => 0,
                'password' => Hash::make($request->password)
            ]);
       
            
            $response = [
            'message' => 'Akte kelahiran berhasil',
            'data' => 1
            ];
                
            return response()->json($response, Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('username', 'password')))
        {
            $response = [
                'data' => null,
                'access_token' =>null,
                'token_type' =>'Bearer',
                'status' => 0
            ];
    
            return response()->json($response,Response::HTTP_CREATED);
    
        }

        $updatetoken = User::where('username',$request->username)->update(['token_notif' => $request->token_notif]);
        $user = User::where('username', $request['username'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        $response = [
            'data' => $user,
            'access_token' =>$token,
            'token_type' =>'Bearer',
            'status' => 1        ];


        return response()->json($response,Response::HTTP_CREATED);
        
    }
}