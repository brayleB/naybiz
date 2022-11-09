<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RuleController extends Controller
{
    public function createRule(Request $request)
    {
        try {
            //Validated
            $validation = Validator::make(
                $request->all(),
                [
                    'hoa_id' => 'required',
                ]
            );

            if ($validation->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validation->errors()
                ], 401);
            }

            $rule = Rule::create([
                'hoa_id' => $request->hoa_id,
                'body' => $request->body
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Rule Created Successfully',
                'tenant' => $rule
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    
    public function getRuleById(Request $request, $id)
    {
        $rule = Rule::find($id);

        if ($rule === null) {
            return response()->json([
                'status' => false,
                'message' => 'Rule does not exist.',
            ], 401);
        }

        return response()->json([
            'status' => true,
            'message' => 'Rule Fetched Successfully',
            'rule' => $rule
        ], 200);
    }
}
