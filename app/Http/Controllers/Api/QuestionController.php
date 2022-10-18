<?php

namespace App\Http\Controllers\api;

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
                'questions' => 'required|array',
                'questions.*.landlord_id' => 'required',
                'questions.*.type' => 'required',
                'questions.*.question' => 'required',
                'questions.*.first_choice' => 'required',
                'questions.*.second_choice' => 'required',
                'questions.*.answer' => 'required',
                'questions.*.description' => 'required',
                'questions.*.status' => 'required'                    
            ]);


            if($validateQuestions->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateQuestions->errors()
                ], 401);
            }

            $now = Carbon::now()->toDateTimeString();

            $newArray = array();
            foreach($request->questions as $item){
                $item['created_at'] = $now;
                $item['updated_at'] = $now;
                $newArray[] = $item;
            }

            $questions = Question::insert(
                $newArray
            );

            return response()->json([
                'status' => true,
                'message' => 'Questions Created Successfully',
                'questions' => $newArray
            ], 200);


        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    
    public function getQuestionsByLandlord(Request $request)
    {
        $validateUserId = Validator::make($request->all(), 
        [
            'landlord_id' => 'required',         
        ]);

        if($validateUserId->fails()){
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUserId->errors()
            ], 401);
        }

        $landlord_id = $request->landlord_id;

        $questions = Question::whereIn('landlord_id', array(0, $landlord_id))
            ->whereIn('status', array('active', 'inactive'))
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Questions Fetched Successfully',
            'tenants' => $questions
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
                'tenant' => $question
            ], 200);


        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
