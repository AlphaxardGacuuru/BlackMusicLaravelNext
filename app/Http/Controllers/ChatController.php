<?php

namespace App\Http\Controllers;

use App\Events\ChatDeletedEvent;
use App\Events\NewChatEvent;
use App\Models\Chat;
use App\Models\User;\ChatService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ChatService $chartService)
    {
        return $chartService->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ChatService $service)
    {
        $this->validate($request, [
            'text' => 'required',
        ]);

        $response = $service->store($request);

        $user = User::where("username", $request->input("to"))->get()->first();

        NewChatEvent::dispatchIf($response["saved"], $response["chat"], $user);

        return response("Message sent", 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show($username, ChatService $service)
    {
        return $service->show($username);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, ChatService $service)
    {
        $response = $service->destroy($id);

        ChatDeletedEvent::dispatchIf($response, $id);

        return response("Chat deleted", 200);
    }
}
