<?php

namespace App\Services;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ChatService extends Service
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getChat = Chat::where('username', $this->username)
            ->orWhere('to', $this->username)
            ->orderBy('id', 'DESC')
            ->get();

        $chatThreadsZero = [];
        $chatThreads = [];

        // Get sender and recipient
        foreach ($getChat as $key => $chatItem) {
            array_push($chatThreadsZero, $chatItem->username);
            array_push($chatThreadsZero, $chatItem->to);
        }

        // Get only unique entries
        $chatThreadsZero = array_unique($chatThreadsZero);

        // Remove auth username
        $key = array_search($this->username, $chatThreadsZero);

        unset($chatThreadsZero[$key]);

        // Get threads
        foreach ($chatThreadsZero as $key => $username) {
            $chat = Chat::where('username', $this->username)
                ->where('to', $username)
                ->orWhere('username', $username)
                ->where('to', $this->username)
                ->orderBy('id', 'DESC')
                ->first();

            // Get user info
            $chatUser = User::where('username', $username)->first();

            array_push($chatThreads, [
                'id' => $chat->id,
                'avatar' => $chatUser->avatar,
                'name' => $chatUser->name,
                'username' => $username,
                'to' => $chat->to,
                'text' => $chat->text,
                'hasMedia' => $chat->media,
                'createdAt' => $chat->created_at,
            ]);
        }

        return $chatThreads;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show($username)
    {
        $getChat = Chat::where("username", $this->username)
            ->where("to", $username)
            ->orWhere("username", $username)
            ->where("to", $this->username)
            ->orderBy('id', 'ASC')->get();

        $chat = [];

        // Populate array
        foreach ($getChat as $chatItem) {
            array_push($chat, $this->structure($chatItem, $this->username));
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
        /* Create new post */
        $chat = new Chat;
        $chat->username = auth("sanctum")->user()->username;
        $chat->to = $request->input('to');
        $chat->text = $request->input('text');
        $chat->media = $request->input('media');

        return $chat->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $chatItem = Chat::find($id);

        $media = substr($chatItem->media, 9);

        Storage::delete('public/' . $media);

        Chat::find($id)->delete();

        return response("Chat deleted", 200);
    }

    private function structure($chart)
    {
        return [
            "id" => $chart->id,
            "name" => $chart->user->name,
            "username" => $chart->user->username,
            "to" => $chart->to,
            "avatar" => $chart->user->avatar,
            "decos" => $chart->user->decos->count(),
            "text" => $chart->text,
            "media" => $chart->media,
            "createdAt" => $chart->created_at,
        ];
    }
}
