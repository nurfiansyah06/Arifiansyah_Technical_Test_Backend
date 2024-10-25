<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Log;
use Validator;
use App\Helpers\Helpers;

class AuthController extends Controller
{
    public function register() {
        $validator = Validator::make(request()->all(), [
            'username' => 'required|unique:users',
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);
  
        if($validator->fails()){
            return Helpers::failed(null, $validator->errors()->first(), 400);
        }
  
        $user = new User;
        $user->name = request()->name;
        $user->username = request()->username;
        $user->email = request()->email;
        $user->password = bcrypt(request()->password);
        $user->assignRole('client');
        $user->save();
  
        return Helpers::success($user, 'Registrasi Berhasil', 201);
    }

    public function login() {
        $user = request('user');
        $password = request('password');

        $fieldUser = filter_var($user, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [$fieldUser => $user, 'password' => $password];

        if (! $token = auth()->attempt($credentials)) {
            return Helpers::failed(null, 'Email atau username atau password tidak valid', 401);
        }

        $data = [
            'token' => $token
        ];
    
        return Helpers::success($data, "Login Berhasil", 200);
    }

    public function user(Request $request) {
        if (is_null($request->bearerToken())) {
            return Helpers::failed(null, 'Token tidak valid', 401);
        }

        $data = Auth::user();
        if (!$data) {
            return Helpers::failed(null, 'Unauthorized', 401);
        }

        $responseData = [
            'id' => $data->id,
            'name' => $data->name,
            'email' => $data->email,
            'email_verified_at' => $data->email_verified_at,
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at,
            'roles' => $data->roles()->first()->name,
        ];

        return Helpers::success($responseData, 'Get Data User Berhasil', 200);
    }

    public function updateProfile(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'username' => 'required',
        ]);

        if ($validator->fails()) {
            return Helpers::failed(null, $validator->errors()->first(), 400);
        }

        $user = User::find($id);
        if (Auth::user()->id == $user->id) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->password = bcrypt($request->password);
            $user->save();
            
            return Helpers::success($user, 'Update Profile Berhasil', 200);
        } else {
            return Helpers::failed(null, 'Unauthorized', 403);
        }
    }

    public function logout() {
        auth()->logout();
        return Helpers::success(null, 'Logout Berhasil', 200);
    }
}
