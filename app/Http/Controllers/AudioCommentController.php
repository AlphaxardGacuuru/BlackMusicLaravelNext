<?php

namespace App\Http\Controllers;

use App\Http\Services\AudioCommentService;
use App\Models\AudioComment;
use Illuminate\Http\Request;

class AudioCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AudioCommentService $service)
    {
        return $service->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, AudioCommentService $service)
    {
        $this->validate($request, [
            'text' => 'required',
        ]);

        return $service->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AudioComment  $audioComment
     * @return \Illuminate\Http\Response
     */
    public function show($id, AudioCommentService $service)
    {
        return $service->show($id);
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
    public function destroy($id, AudioCommentService $service)
    {
        return $service->destroy($id);
    }
}
