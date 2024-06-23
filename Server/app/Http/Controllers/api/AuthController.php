<?php

namespace App\Http\Controllers\api;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signIn(UserRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = array_merge($request->all(), [
                'online' => User::Online['online'],
                'status' => User::Status['active']
            ]);

            User::create($user);
            DB::commit();
            return Helper::SuccessWithMessage();
        } catch (\Throwable $error) {
            DB::rollBack();
            return Helper::Error(
                [],
                400,
                $error->getMessage()

            );
        }
    }
    public function Login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('name', 'password'))) {
            return Helper::Error(
                [],
                400,
                'Invalid login credentials1'
            );
        }
        $user = User::where('name', $request->name)->first();
        if (!Hash::check($request->password, $user->password)) {
            return
                Helper::Error(
                    [],
                    401,
                    'Invalid login credentials'
                );
        }
        $token = $user->createToken(User::UserToken)->plainTextToken;
        return Helper::SuccessWithData([
            'token' => $token
        ]);
    }
    public function getUser(Request $request)
    {
        $user = auth()->user();
        return Helper::SuccessWithData($user);
    }
}
