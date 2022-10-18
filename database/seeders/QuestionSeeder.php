<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('questions')->insert([

            [
                'question' => 'Question 1?',
                'first_choice' => 'Yes',
                'second_choice' => 'No',
                'third_choice' => 'Maybe',
                'fourth_choice' => 'Undecided',
                'answer' => 'first_choice',
                'description' => 'First Question',
                'status' => 'active',
            ],
            [
                'question' => 'Question 2?',
                'first_choice' => 'Yes',
                'second_choice' => 'No',
                'third_choice' => 'Maybe',
                'fourth_choice' => 'Undecided',
                'answer' => 'third_choice',
                'description' => '2nd Question',
                'status' => 'active',
            ],
            [
                'question' => 'Question 3?',
                'first_choice' => 'Yes',
                'second_choice' => 'No',
                'third_choice' => 'Maybe',
                'fourth_choice' => 'Undecided',
                'answer' => 'fourth_choice',
                'description' => '3rd Question',
                'status' => 'active',
            ],
            [
                'question' => 'Question 4?',
                'first_choice' => 'Yes',
                'second_choice' => 'No',
                'third_choice' => 'Maybe',
                'fourth_choice' => 'Undecided',
                'answer' => 'fourth_choice',
                'description' => '4th Question',
                'status' => 'active',
            ],
            [
                'question' => 'Question 5?',
                'first_choice' => 'Yes',
                'second_choice' => 'No',
                'third_choice' => 'Maybe',
                'fourth_choice' => 'Undecided',
                'answer' => 'first_choice',
                'description' => '5th Question',
                'status' => 'active',
            ],
            [
                'question' => 'Question 6?',
                'first_choice' => 'Yes',
                'second_choice' => 'No',
                'third_choice' => 'Maybe',
                'fourth_choice' => 'Undecided',
                'answer' => 'second_choice',
                'description' => '6th Question',
                'status' => 'active',
            ],
            [
                'question' => 'Question 7?',
                'first_choice' => 'Yes',
                'second_choice' => 'No',
                'third_choice' => 'Maybe',
                'fourth_choice' => 'Undecided',
                'answer' => 'first_choice',
                'description' => '7th Question',
                'status' => 'active',
            ],
            [
                'question' => 'Question 8?',
                'first_choice' => 'Yes',
                'second_choice' => 'No',
                'third_choice' => 'Maybe',
                'fourth_choice' => 'Undecided',
                'answer' => 'third_choice',
                'description' => '8th Question',
                'status' => 'active',
            ],
            [
                'question' => 'Question 9?',
                'first_choice' => 'Yes',
                'second_choice' => 'No',
                'third_choice' => 'Maybe',
                'fourth_choice' => 'Undecided',
                'answer' => 'first_choice',
                'description' => '9th Question',
                'status' => 'active',
            ],
            [
                'question' => 'Question 10?',
                'first_choice' => 'Yes',
                'second_choice' => 'No',
                'third_choice' => 'Maybe',
                'fourth_choice' => 'Undecided',
                'answer' => 'second_choice',
                'description' => '10th Question',
                'status' => 'active',
            ],
        ]);
    }
}
