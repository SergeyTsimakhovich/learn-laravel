<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Answer;

class VoteAnswerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Answer $answer)
    {
        $vote = (int) Request()->vote;

        $votesCount = auth()->user()->voteAnswer($answer, $vote)->votes_count;

        if (request()->expectsJson()) {
            return response()->json([
                'votesCount' => $votesCount
            ]);
        }

        return back();
    }
}
