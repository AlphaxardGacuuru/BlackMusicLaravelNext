<?php

namespace App\Http\Services;

use App\Models\Poll;

class PollService
{
	public function store($request)
	{
        // Check if user has voted
        $checkPoll = Poll::where('username', auth('sanctum')->user()->username)
            ->where('post_id', $request->input('post'))
            ->exists();

        if (!$checkPoll) {
            $poll = new Poll;
            $poll->post_id = $request->input('post');
            $poll->username = auth('sanctum')->user()->username;
            $poll->parameter = $request->input('parameter');
            $poll->save();

            $message = "Voted";
        } else {
            Poll::where('username', auth('sanctum')->user()->username)
                ->where('post_id', $request->input('post'))
                ->delete();
				
            $message = "Vote removed";
        }

        return response($message, 200);
	}
}