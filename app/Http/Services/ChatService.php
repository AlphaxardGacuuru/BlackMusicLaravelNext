<?php

namespace App\Http\Services;

use App\Models\Chat;

class ChatService
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check if user is logged in
        $auth = auth('sanctum')->user();

        $authUsername = $auth ? $auth->username : '@guest';

        $getChat = Chat::orderBy('id', 'ASC')->get();

        $chat = [];

        // Populate array
        foreach ($getChat as $chatItem) {
            array_push($chat, $this->structure($chatItem, $authUsername));
        }

        return $chat;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show($username)
    {
        // Check if user is logged in
        $auth = auth('sanctum')->user();

        $authUsername = $auth ? $auth->username : '@guest';

        $getChat = Chat::where('username', $username)->first();

        $chat = [];

        // Populate array
        array_push($chat, $this->structure($getChat, $authUsername));

        return $chat;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update($request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function structure($chart)
    {
        return [
            "id" => $chart->id,
            "name" => $chart->user->name,
            "username" => $chart->user->username,
            "to" => $chart->to,
            "pp" => $chart->user->avatar,
            "decos" => $chart->user->decos->count(),
            "text" => $chart->text,
            "media" => $chart->media,
            "createdAt" => $chart->created_at,
        ];
    }
}
