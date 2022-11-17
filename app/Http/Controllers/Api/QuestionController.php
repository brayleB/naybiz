<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class QuestionController extends Controller
{
    public function createQuestions(Request $request)
    {
        try {  
            $validateQuestions = Validator::make($request->all(), 
            [
                'hoa_id' => 'required',
                'type' => 'required',
                'question' => 'required',
                'options' => 'required',
                'answer' => 'required',
                'description' => 'required',
                'status' => 'required'             
            ]);


            if($validateQuestions->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateQuestions->errors()
                ], 401);
            }

            $question = Question::create([
                'hoa_id' => $request->hoa_id,
                'type' => $request->type,
                'question' => $request->question,
                'options' => $request->options,
                'answer' => $request->answer,
                'description' => $request->description,
                'status' => $request->status
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Question Created Successfully',
                'question' => $question
            ], 200);


        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    
    public function getQuestionsByHoa(Request $request)
    {
        $validateUserId = Validator::make($request->all(), 
        [
            'hoa_id' => 'required',         
        ]);

        if($validateUserId->fails()){
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUserId->errors()
            ], 401);
        }

        $hoa_id = $request->hoa_id;

        $questions = Question::whereIn('hoa_id', array(0, $hoa_id))
            ->whereIn('status', array('active', 'inactive'))
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Questions Fetched Successfully',
            'questions' => $questions
        ], 200);
    }

    public function questionaire(Request $request)
    {
        $validateUserId = Validator::make($request->all(), 
        [
            'hoa_id' => 'required',         
        ]);

        if($validateUserId->fails()){
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUserId->errors()
            ], 401);
        }

        $hoa_id = $request->hoa_id;

        $questions = Question::whereIn('hoa_id', array(0, $hoa_id))
            ->where('status', 'active')
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Questions Fetched Successfully',
            'questions' => $questions
        ], 200);
    }

    public function trash(Request $request)
    {
        try {
            $validateId = Validator::make($request->all(), 
            [
                'question_id' => 'required',         
            ]);

            if($validateId->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateId->errors()
                ], 401);
            }

            $question_id = $request->question_id;
            $question = Question::find($question_id);

            if ($question === null) {
                return response()->json([
                    'status' => false,
                    'message' => 'Question does not exist.',
                ], 401);
            }

            $question->status = 'trash';
            $question->save();

            return response()->json([
                'status' => true,
                'message' => 'Question Updated Successfully',
                'question' => $question
            ], 200);


        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
