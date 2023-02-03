<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class TenantController extends Controller
{
    public function createTenant(Request $request)
    {
        try {
            //Validated
            $validateTenant = Validator::make(
                $request->all(),
                [
                    'landlord_id' => 'required',
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'email' => 'required|email',
                    'contact_no' => 'required',
                    'address' => 'required',
                    'status' => 'required',
                    'property_id' => 'required'
                ]
            );

            if ($validateTenant->fails()) {
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
                'status' => $request->status,
                'occupants' => $request->occupants,
                'vehicles' => $request->vehicles,
                'property_id' => $request->property_id
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
        $validateUserId = Validator::make(
            $request->all(),
            [
                'landlord_id' => 'required',
            ]
        );

        if ($validateUserId->fails()) {
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

    public function getTenantsByLandlordRequested(Request $request)
    {
        $validateUserId = Validator::make(
            $request->all(),
            [
                'landlord_id' => 'required|string|exists:tenants,landlord_id',
            ]
        );

        if ($validateUserId->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUserId->errors()
            ], 401);
        }

        $landlord_id = $request->landlord_id;

        $tenants = Tenant::where('landlord_id', $landlord_id)->where('status', 'requested')->get();


         $landlord = User::where('id', $landlord_id)->where('type', 'landlord')->get();

        return response()->json([
            'status' => true,
            'message' => 'Tenants Fetched Successfully',
            'landlord' => $landlord,
            'tenants' => $tenants
        ], 200);
    }

    public function getTenantsByLandlordAccepted(Request $request)
    {
        $validateUserId = Validator::make(
            $request->all(),
            [
               'landlord_id' => 'required|string|exists:tenants,landlord_id',
            ]
        );

        if ($validateUserId->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUserId->errors()
            ], 401);
        }

        $landlord_id = $request->landlord_id;

        $tenants = Tenant::where('landlord_id', $landlord_id)->where('status', 'accepted')->get();

        $landlord = User::where('id', $landlord_id)->where('type', 'landlord')->get();


        return response()->json([
            'status' => true,
            'message' => 'Tenants Fetched Successfully',
            'landlord' => $landlord,
            'tenants' => $tenants
        ], 200);
    }

    public function updateTenant(Request $request)
    {
        try {

            $validateTenant = Validator::make(
                $request->all(),
                [
                    'tenant_id' => 'required',
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'email' => 'required|email',
                    'contact_no' => 'required',
                    'address' => 'required',
                    'status' => 'required',
                    'property_id' => 'required'
                ]
            );

            if ($validateTenant->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateTenant->errors()
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

            $tenant->first_name = $request->first_name;
            $tenant->last_name = $request->last_name;
            $tenant->email = $request->email;
            $tenant->contact_no = $request->contact_no;
            $tenant->address = $request->address;
            $tenant->valid_id = $request->valid_id;
            $tenant->status = $request->status;
            $tenant->occupants = $request->occupants;
            $tenant->vehicles = $request->vehicles;
            $tenant->property_id = $request->property_id;
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

    public function toAccept(Request $request)
    {
        try {
            $validateId = Validator::make(
                $request->all(),
                [
                    'id' => 'required',
                ]
            );

            if ($validateId->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateId->errors()
                ], 401);
            }

            $id = $request->id;
            $tenant = Tenant::find($id);

            if ($tenant === null) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tenant does not exist.',
                ], 401);
            }

            $tenant->status = 'accepted';
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

    public function getTenantById(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'id' => 'required',
            ]
        );

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validate->errors()
            ], 401);
        }

        $id = $request->id;

        $tenant = Tenant::where('id', $id)->get();

        return response()->json([
            'status' => true,
            'message' => 'Tenant Fetched Successfully',
            'tenants' => $tenant
        ], 200);
    }

    public function getTenantsByHoaRequested(Request $request, $id)
    {
        $landlord_ids = User::select('id')->where('assoc_hoa_id', $id)->get();
        $tenants = Tenant::whereIn('landlord_id', $landlord_ids)->where('status', 'requested')->get();

        return response()->json([
            'status' => true,
            'message' => 'Tenants Fetched Successfully',
            'tenants' => $tenants
        ], 200);
    }

    public function getTenantsByHoaAccepted(Request $request, $id)
    {
        $landlord_ids = User::select('id')->where('assoc_hoa_id', $id)->get();
        $tenants = Tenant::whereIn('landlord_id', $landlord_ids)->where('status', 'accepted')->get();

        return response()->json([
            'status' => true,
            'message' => 'Tenants Fetched Successfully',
            'tenants' => $tenants
        ], 200);
    }

    public function deleteTenant(Request $request)
    {
        try {
            $validateId = Validator::make(
                $request->all(),
                [
                    'id' => 'required',
                ]
            );

            if ($validateId->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateId->errors()
                ], 401);
            }

            $id = $request->id;
            $tenant = Tenant::find($id);

            if ($tenant === null) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tenant does not exist.',
                ], 401);
            }

            $tenant->delete();

            return response()->json([
                'status' => true,
                'message' => 'Tenant Deleted Successfully',
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
