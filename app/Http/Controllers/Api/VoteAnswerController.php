<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Answer;

class VoteAnswerController extends Controller
{
    public function __invoke(Answer $answer)
    {
        $vote = (int) Request()->vote;

        $votesCount = auth()->user()->voteAnswer($answer, $vote)->votes_count;

        return response()->json([
            'message'    => 'Thanks for the feedback',
            'votesCount' => $votesCount
        ]);
        
    }
}
