<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Follow;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => [
				'required',
                'string',
                'startsWith:@',
                'min:2',
                'max:15',
                'unique:users',
                'regex:/^\S+$/',
            ],
            'phone' => [
				'required',
                'string',
                'startsWith:0',
                'min:10',
                'max:10',
                'unique:users',
            ],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
			'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Notify User
        // Mail::to($request->email)
            // ->send(new WelcomeMail($request->username));

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->phone),
            'phone' => $request->phone,
            'avatar' => $request->avatar,
            'withdrawal' => '1000',
        ]);

        /* User should follow themselves */
        $follow = new Follow;
        $follow->followed = $request->username;
        $follow->username = $request->username;
        $follow->muted = "show";
        $follow->save();

        /* User should follow @blackmusic */
        $follow = new Follow;
        $follow->followed = '@blackmusic';
        $follow->username = $request->username;
        $follow->muted = "show";
        $follow->save();

        event(new Registered($user));

        Auth::login($user, $remember = true);

        // return response()->noContent();

		/*
		* Create Token */
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user->createToken($request->device_name)->plainTextToken;
    }
}
