<?php

namespace App\Services;

use App\Models\Search;

class SearchService
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

        return Search::where('username', $authUsername)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        $search = new Search;
        $search->username = auth('sanctum')->user()->username;
        $search->keyword = $request->input('keyword');
        $search->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Search  $search
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Search::find($id)->delete();
    }
}
