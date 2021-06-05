<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Resources\AuthTokenResource;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): AuthTokenResource
    {
        $registerData = $request->validated();
        $user = User::create($registerData);

        if ($request->hasFile('avatar')) {
            $registerData['avatar'] =  Profile::storeAvatarFile($request->file('avatar'));
        }

        $user->profile()->create($registerData);
        $deviceName = $request->header('User-Agent');
        return new AuthTokenResource($user->createToken($deviceName));
    }

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->validated())) {
            return response('', 401);
        }
        $deviceName = $request->header('User-Agent');
        return  new AuthTokenResource($request->user()->createToken($deviceName));
    }

    public function logout(Request $request): \Illuminate\Http\Response
    {
        $request->user()->currentAccessToken()->delete();
        return response()->noContent();
    }
}
