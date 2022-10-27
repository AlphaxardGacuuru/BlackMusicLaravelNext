<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function auth()
    {
        // Check if user is logged in
        if (Auth::check()) {

            $auth = Auth::user();

            // Get Cost of Bought Videos at each price
            $totalVideos = $auth->boughtVideos->count() * 20;
            $totalAudios = $auth->boughtAudios->count() * 10;

            // Get Total Cash paid
            $kopokopo = $auth->kopokopos->sum('amount');
            $balance = $kopokopo - ($totalVideos + $totalAudios);

            // Format profile pic
            $pp = preg_match("/http/", $auth->pp) ?
            $auth->pp :
            "/storage/" . $auth->pp;

            return [
                "id" => $auth->id,
                "name" => $auth->name,
                "username" => $auth->username,
                "email" => $auth->email,
                "phone" => $auth->phone,
                "account_type" => $auth->account_type,
                "pp" => $pp,
                "pb" => $auth->pb,
                "bio" => $auth->bio,
                "dob" => $auth->dob,
                "withdrawal" => $auth->withdrawal,
                "decos" => $auth->decos->count(),
                "fans" => Follow::where('followed', $auth->username)->count() - 1,
                "following" => $auth->follows->count(),
                "posts" => $auth->posts->count(),
                "balance" => $balance,
                "created_at" => $auth->created_at,
            ];
        }
    }
}
