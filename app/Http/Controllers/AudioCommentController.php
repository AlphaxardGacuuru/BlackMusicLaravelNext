<?php

namespace App\Http\Controllers;

use App\Events\AudioCommentedEvent;
use App\Models\Audio;
use App\Models\AudioComment;
use App\Http\Services\AudioCommentService;
use Illuminate\Http\Request;

class AudioCommentController extends Controller
{
    public function __construct(protected AudioCommentService $service)
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->service->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'text' => 'required',
        ]);

        $saved = $this->service->store($request);

        $audio = Audio::find($request->input("id"));

        AudioCommentedEvent::dispatchIf($saved, $audio);

        return response("Comment Posted", 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AudioComment  $audioComment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->service->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AudioComment  $audioComment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AudioComment $audioComment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AudioComment  $audioComment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->service->destroy($id);
    }
}
