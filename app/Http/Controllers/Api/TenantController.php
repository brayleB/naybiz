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
                'landlord_id' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required',
                'contact_no' => 'required',
                'address' => 'required',
                'valid_id' => 'required',
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
                'landlord_id' => $request->landlord_id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'contact_no' => $request->contact_no,
                'address' => $request->address,
                'valid_id' => $request->valid_id,
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

    public function getTenantsByLandlord(Request $request)
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

        $tenants = Tenant::where('landlord_id', $landlord_id)->get();

        return response()->json([
            'status' => true,
            'message' => 'Tenants Fetched Successfully',
            'tenants' => $tenants
        ], 200);

    }

    public function updateTenant(Request $request)
    {
        try {
            
            $validateTenant = Validator::make($request->all(), 
            [
                'tenant_id' => 'required',
                'status' => 'required'  
            ]);

            if($validateTenant->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateTenant->errors()
                ], 401);
            }

            $tenant_id = $request->tenant_id;
            $status = $request->status;

            $tenant = Tenant::find($tenant_id);

            if ($tenant === null) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tenant does not exist.',
                ], 401);
             }

            $tenant->status = $status;
            $tenant->save();

            return response()->json([
                'status' => true,
                'message' => 'Tenants Updated Successfully',
                'tenant' => $tenant
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }

    public function toQuiz(Request $request)
    {
        try {
            $validateId = Validator::make($request->all(), 
            [
                'tenant_id' => 'required',         
            ]);

            if($validateId->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateId->errors()
                ], 401);
            }

            $tenant_id = $request->tenant_id;
            $tenant = Tenant::find($tenant_id);

            if ($tenant === null) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tenant does not exist.',
                ], 401);
            }

            $tenant->status = 'quiz';
            $tenant->save();

            return response()->json([
                'status' => true,
                'message' => 'Tenant Updated Successfully',
                'tenant' => $tenant
            ], 200);


        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
