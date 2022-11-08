<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
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

            $validateFile = Validator::make(
                $request->all(),
                [
                    'valid_id' => 'mimes:jpg,jpeg,png,bmp,tiff |max:4096',
                ],
                $messages = [
                    'mimes' => 'Please insert image only',
                    'max'   => 'Image should be less than 4 MB'
                ]
            );

            if ($validateFile->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateFile->errors()
                ], 401);
            }

            $file = NULL;

            if ($request->file('valid_id')) {
                //store file into document folder
                $file = $request->file('valid_id')->store('tenants');
            }

            $tenant = Tenant::create([
                'landlord_id' => $request->landlord_id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'contact_no' => $request->contact_no,
                'address' => $request->address,
                'valid_id' => $file,
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

        $tenants = Tenant::where('landlord_id', $landlord_id)->where('status', 'requested')->get();

        return response()->json([
            'status' => true,
            'message' => 'Tenants Fetched Successfully',
            'tenants' => $tenants
        ], 200);
    }
    public function getTenantsByLandlordAccepted(Request $request)
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

        $tenants = Tenant::where('landlord_id', $landlord_id)->where('status', 'accepted')->get();

        return response()->json([
            'status' => true,
            'message' => 'Tenants Fetched Successfully',
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

            $validateFile = Validator::make(
                $request->all(),
                [
                    'valid_id' => 'mimes:jpg,jpeg,png,bmp,tiff |max:4096',
                ],
                $messages = [
                    'mimes' => 'Please insert image only',
                    'max'   => 'Image should be less than 4 MB'
                ]
            );

            if ($validateFile->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateFile->errors()
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

            $file = NULL;
            
            //remove old file
            if($tenant->valid_id) {
                Storage::delete($tenant->valid_id);
            }

            if ($request->file('valid_id')) {
                //store file into properties folder
                $file = $request->file('valid_id')->store('tenants');
            }

            $tenant->first_name = $request->first_name;
            $tenant->last_name = $request->last_name;
            $tenant->email = $request->email;
            $tenant->contact_no = $request->contact_no;
            $tenant->address = $request->address;
            $tenant->valid_id = $file;
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
}
