<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Question;
use App\Answer;


class VotablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('votables')->where('votable_type', 'App\Question')->delete();
        DB::table('votables')->where('votable_type', 'App\Answer')->delete();

        $users = User::all();
        $numberOfUser = count($users);
        $votes = [-1, 1];

        foreach(Question::all() as $question) 
        {
            for($i = 0; $i < rand(1, $numberOfUser); $i++) 
            {
                $user = $users[$i];

                $user->voteQuestion($question, $votes[rand(0,1)]);
            }
        }

        foreach(Answer::all() as $answer) 
        {
            for($i = 0; $i < rand(1, $numberOfUser); $i++) 
            {
                $user = $users[$i];

                $user->voteAnswer($answer, $votes[rand(0,1)]);
            }
        }
    }
}
