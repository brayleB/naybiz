<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function getAll()
    {
        $questions = Question::all();
        
        return response()->json([
            'status' => true,
            'message' => 'Questions Fetched Successfully',
            'data' => $questions
        ], 200);
    }
}
