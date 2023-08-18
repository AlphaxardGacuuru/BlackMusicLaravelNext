<?php

namespace App\Http\Services;

use App\Models\Poll;

class PollService extends Service
{
    public function store($request)
    {
        // Check if user has voted
        $getPoll = Poll::where('username', auth('sanctum')->user()->username)
            ->where('post_id', $request->input('post'));

        $hasVoted = $getPoll->exists();

        // Check if poll exists
        if ($hasVoted) {
            // Get Poll
            $poll = $getPoll->first();
            // Delete Poll
            $getPoll->delete();

            $message = "Vote removed";
            $saved = false;
        } else {
            $poll = new Poll;
            $poll->post_id = $request->input('post');
            $poll->username = auth('sanctum')->user()->username;
            $poll->parameter = $request->input('parameter');
            $poll->save();

            $message = "Voted";
            $saved = true;
        }

        return [$saved, $message, $poll];
    }
}
