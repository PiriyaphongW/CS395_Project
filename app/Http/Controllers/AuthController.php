<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validate = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'phoneNumber' => 'required|string|',
            'gender' => 'required|string|',
        ]);
        $user = user::create([
            'firstName' => $validate['firstName'],
            'lastName' => $validate['lastName'],
            'email' => $validate['email'],
            'password' => bcrypt($validate['password']),
            'phoneNumber' => $validate['phoneNumber'],
            'gender' => $validate['gender'],
        ]);

        //$token = $user->createToken($request->userAgent())->plainTextToken;
        $response = [
            'user' => $user,
            'token' => "Register Success",
            
        ];
        return response($response);

    }

    public function login(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',

        ]);

        $user = User::where('email', $validate['email'])->first();
        if (!$user || !Hash::check($validate['password'], $user->password)) {
            $response = [
                'message' => 'Email or Password Incorrect',
            ];
            return response($response);
        } else {

            $user->tokens()->delete(); #delete Token After login

            $token = $user->createToken($request->userAgent())->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token,
                'message'=> 'Login Success'
            ];
            return response($response);
        }
    }
     
    public function logout(Request $request){

        $request->user()->currentAccessToken()->delete();

        $response = [
            'message' => 'Logout Success' 
        ];
        return $response;
    }


}
