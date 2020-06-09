<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);

Route::view('/{any}', 'spa')->where('any', '.*');

Route::get('/', 'QuestionsController@index');

Route::resource('users', 'UsersController');

Route::resource('questions', 'QuestionsController')->except('show');

Route::get('questions/{slug}', 'QuestionsController@show')->name('questions.show');

Route::resource('questions.answers', 'AnswersController')->except(['create', 'show']);

Route::post('answers/{answer}/accept', 'AcceptAnswerController')->name('answers.accept');

Route::post('questions/{question}/favorites', 'FavoritesController@store')->name('questions.favorite');
Route::delete('questions/{question}/favorites', 'FavoritesController@destroy')->name('questions.unfavorite');

Route::post('questions/{question}/vote', 'VoteQuestionController')->name('questions.vote');
Route::post('answers/{answer}/vote', 'VoteAnswerController')->name('answers.vote');






