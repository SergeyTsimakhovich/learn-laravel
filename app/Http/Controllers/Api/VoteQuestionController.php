<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Question;

class VoteQuestionController extends Controller
{
    public function __invoke(Question $question)
    {
        $vote = (int) Request()->vote;

        $votesCount = auth()->user()->voteQuestion($question, $vote)->votes_count;
        
        return response()->json([
            'message'    => 'Thanks for the feedback',
            'votesCount' => $votesCount
        ]);
    }
}
