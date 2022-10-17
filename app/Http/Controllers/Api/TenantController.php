<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class TenantController extends Controller
{
    public function createTenant(Request $request)
    {
        try {
            //Validated
            $validateTenant = Validator::make($request->all(), 
            [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:tenants,email',
                'contact_no' => 'required',
                'user_id' => 'required',
                'status' => 'required'               
            ]);

            if($validateTenant->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateTenant->errors()
                ], 401);
            }

            $tenant = Tenant::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'contact_no' => $request->contact_no,
                'user_id' => $request->user_id,
                'status' => $request->status
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Tenant Created Successfully',
                'tenant' => $tenant
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getTenantsByUser(Request $request)
    {
        $validateUserId = Validator::make($request->all(), 
        [
            'user_id' => 'required',         
        ]);

        if($validateUserId->fails()){
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUserId->errors()
            ], 401);
        }

        $user_id = $request->user_id;

        $tenants = Tenant::where('user_id', $user_id)->get();

        return response()->json([
            'status' => true,
            'message' => 'Tenants Fetched Successfully',
            'tenants' => $tenants
        ], 200);

    }
}
