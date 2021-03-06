<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserQuestionsAnswersTableSeeder::class);
        $this->call(FavoritesTableSeeder::class);
        $this->call(VotablesTableSeeder::class);
    }
}
