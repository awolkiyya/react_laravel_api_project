<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\GoogleAuth;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    // this is store the authenticated by the googleAuth
    public function signup(GoogleAuth $request){
        //  now here first store the data on the client tables
        // dd($request);
        $user =User::create([
              'name'=> $request['name'],
              'email' => $request['email'],
              'profile_url' => $request['profile_url'],
              'password'=>bcrypt($request['password'])
        ]);
        if (!Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            return response([
                'error' => 'The Provided credentials are not correct'
            ], 422);
        }
        $user = Auth::user();
        // return $user;
        $token = $user->createToken('client')->plainTextToken;
        
        return response([
            'user' => $user,
            'token' => $token
        ]);
       
        
    }
    public function logout()
    {
        /** @var User $user */
        // $user = Auth::user();
        // Revoke the token that was used to authenticate the current request...
        auth('sanctum')->user()->currentAccessToken()->delete();

        return response([
            'success' => true
        ]);
    }
    public function getMyData(Request $request)
    { 
        return  Auth::user();
    }
}
