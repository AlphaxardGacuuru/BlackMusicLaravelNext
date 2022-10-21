<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

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

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->phone),
            'phone' => $request->phone,
            'pp' => $request->avatar,
            'withdrawal' => '1000',
        ]);

        event(new Registered($user));

        Auth::login($user, $remember = true);

        return response()->noContent();
    }
}
