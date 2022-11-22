<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PropertyController extends Controller
{
    public function addProperty(Request $request)
    {
        try {
            //Validated
            $validateProperty = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'hoa_id' => 'required',
                    'address' => 'required',
                    'status' => 'required'
                ]
            );

            if ($validateProperty->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateProperty->errors()
                ], 401);
            }                 
            $validateFile = Validator::make(
                $request->all(),
                [
                    'image' => 'mimes:jpg,jpeg,png,bmp,tiff |max:4096',
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
                    'errors' => $validateFile->errors(),                  
                ], 401);
            }

            $file = NULL;

            if ($request->file('image')) {
                //store file into properties folder
                $file = $request->file('image')->store('media/properties');
            }

            $property = Property::create([
                'name' => $request->name,
                'hoa_id' => $request->hoa_id,
                'landlord_id' => $request->landlord_id,
                'tenant_id' => $request->tenant_id,
                'address' => $request->address,
                'description' => $request->description,
                'image' => $file,
                'status' => $request->status
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Property Created Successfully',
                'property' => $property
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getPropertyByLandlord(Request $request)
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

        $properties = Property::where('landlord_id', $landlord_id)
            ->where('status', 'active')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Properties Fetched Successfully',
            'properties' => $properties
        ], 200);
    }

    public function trash(Request $request)
    {
        try {
            $validateId = Validator::make(
                $request->all(),
                [
                    'property_id' => 'required',
                ]
            );

            if ($validateId->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateId->errors()
                ], 401);
            }

            $property_id = $request->property_id;
            $property = Property::find($property_id);

            if ($property === null) {
                return response()->json([
                    'status' => false,
                    'message' => 'Property does not exist.',
                ], 401);
            }

            $property->status = 'trash';
            $property->save();

            return response()->json([
                'status' => true,
                'message' => 'Property Updated Successfully',
                'property' => $property
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function update(Request $request)
    {
        try {

            $validateProperty = Validator::make(
                $request->all(),
                [
                    'property_id' => 'required',
                    'name' => 'required',
                    'address' => 'required',
                    'status' => 'required'
                ]
            );

            if ($validateProperty->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateProperty->errors()
                ], 401);
            }

            $validateFile = Validator::make(
                $request->all(),
                [
                    'image' => 'mimes:jpg,jpeg,png,bmp,tiff |max:4096',
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

            $property_id = $request->property_id;

            $property = Property::find($property_id);

            if ($property === null) {
                return response()->json([
                    'status' => false,
                    'message' => 'Property does not exist.',
                ], 401);
            }

            $file = NULL;
            
            //remove old file
            if($property->image) {
                Storage::delete($property->image);
            }

            if ($request->file('image')) {
                //store file into properties folder
                $file = $request->file('image')->store('media/properties');
                
            }

            $property->name =  $request->name;
            $property->landlord_id =  $request->landlord_id;
            // $property->tenant_id =  $request->tenant_id;
            $property->address =  $request->address;
            $property->description =  $request->description;
            $property->image =  $file;
            $property->status =  $request->status;
            $property->save();

            return response()->json([
                'status' => true,
                'message' => 'Property Updated Successfully',
                'property' => $property
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function setTenant(Request $request)
    {
        try {
            $validateId = Validator::make(
                $request->all(),
                [
                    'property_id' => 'required',
                    'tenant_id' => 'required'
                ]
            );

            if ($validateId->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateId->errors()
                ], 401);
            }

            $property_id = $request->property_id;
            $property = Property::find($property_id);

            if ($property === null) {
                return response()->json([
                    'status' => false,
                    'message' => 'Property does not exist.',
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

            $property->tenant_id = $tenant_id;
            $property->save();

            return response()->json([
                'status' => true,
                'message' => 'Property Updated Successfully',
                'property' => $property
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function getPropertiesByHoaAvailable(Request $request, $id)
    {
        $properties = Property::where('hoa_id', $id)->where('tenant_id' , null)->get();

        return response()->json([
            'status' => true,
            'message' => 'Properties Fetched Successfully',
            'properties' => $properties
        ], 200);
    }

    public function getPropertiesByHoaOccupied(Request $request, $id)
    {
        $properties = Property::where('hoa_id', $id)->where('tenant_id', '!=' , null)->get();

        return response()->json([
            'status' => true,
            'message' => 'Properties Fetched Successfully',
            'properties' => $properties
        ], 200);
    }

    public function deleteProperty(Request $request)
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
            $property = Property::find($id);

            if ($property === null) {
                return response()->json([
                    'status' => false,
                    'message' => 'Property does not exist.',
                ], 401);
            }

            $property->delete();

            return response()->json([
                'status' => true,
                'message' => 'Property Deleted Successfully',
                'property' => $property
            ], 200);
            
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
