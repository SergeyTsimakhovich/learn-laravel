<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Requests\AskQuestionRequest;
use App\Http\Resources\QuestionResource;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::latest()->with('user')->paginate(5);

        sleep(4);

        return QuestionResource::collection($questions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AskQuestionRequest $request)
    {
        $question = $request->user()->questions()->create($request->only('title', 'body'));

        sleep(5);

        return response()->json([
            'message' => "Your question has been submitted",
            'question' => new QuestionResource($question)
        ]); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {   
        return response()->json([
            new QuestionResource($question)
        ]);
}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(AskQuestionRequest $request, Question $question)
    {
        $this->authorize("update", $question);
    
        $question->update($request->only('title', 'body'));
    
        return response()->json([
            'message' => "Your question has been updated.",
            'body_html' => $question->body_html
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $this->authorize("delete", $question);
 
        $question->delete();
    
        return response()->json([
            'message' => "Your question has been deleted."
        ]);
    }
}
