<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return response()->noContent();
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Delete Current Access Token
        $hasLoggedOut = auth("sanctum")
            ->user()
            ->currentAccessToken()
            ->delete();

        if ($hasLoggedOut) {
            $message = "Logged Out";
        } else {
            $message = "Failed to log out";
        }

        return response(["message" => $message], 200);
    }

    /*
     * Token Based Login
     */
    public function token(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('phone', $request->phone)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'phone' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Give @blackmusic all abilities
        if ($user->username == '@blackmusic') {
            $token = $user->createToken($request->device_name, ['*'])->plainTextToken;
        } else {
            $token = $user->createToken($request->device_name)->plainTextToken;
        }

        return response([
            "message" => "Logged in",
            "data" => $token,
        ], 200);
    }
}
