<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;

class VoteQuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Question $question)
    {
        $vote = (int) Request()->vote;

        $votesCount = auth()->user()->voteQuestion($question, $vote)->votes_count;

        if (request()->expectsJson()) {
            return response()->json([
               'votesCount' => $votesCount
            ]);
        }

        return back();
    }
}
