<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AnswersResource;

class AnswersController extends Controller
{

    public function index(Question $question)
    {
        $answers = $question
            ->answers()
            ->with('user')
            ->where(function ($q) {
                if (request()->has('excludes')) {
                    $q->whereNotIn('id', request()->query('excludes'));
                }
            })
            ->simplePaginate(3);

        return AnswersResource::collection($answers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Question $question, Request $request)
    {
        $request->validate([
            'body' => 'required'
        ]);

        $answer = $question->answers()->create(['body' => $request->body, 'user_id' => Auth::id()]);

        sleep(3);

        return response()->json([
            'answer' => new AnswersResource($answer->load('user')),
            'message' => 'Your answer has been submitted succefully'
        ]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);

        $answer->update($request->validate([
            'body' => 'required',
        ]));

        return response()->json([
            'message' => 'Your answer has been updated succefully',
            'body_html' => $answer->body_html,
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question, Answer $answer)
    {
        $this->authorize('delete', $answer);

        $answer->delete();

        return response()->json([
            'message' => 'Your answer has been removed succefully',
            'body_html' => $answer->body_html,
        ]);
        
    }
}
