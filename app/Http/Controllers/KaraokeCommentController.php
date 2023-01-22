<?php

namespace App\Http\Controllers;

use App\Http\Services\KaraokeCommentService;
use App\Models\KaraokeComment;
use Illuminate\Http\Request;

class KaraokeCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(KaraokeCommentService $karaokeCommentService)
    {
        return $karaokeCommentService->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, KaraokeCommentService $karaokeCommentService)
    {
        $this->validate($request, [
            'text' => 'required',
        ]);

		return $karaokeCommentService->store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KaraokeComment  $karaokeComment
     * @return \Illuminate\Http\Response
     */
    public function show(KaraokeComment $karaokeComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KaraokeComment  $karaokeComment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KaraokeComment $karaokeComment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KaraokeComment  $karaokeComment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, KaraokeCommentService $karaokeCommentService)
    {
        return $karaokeCommentService->destroy($id);
    }
}
