<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PropertyController extends Controller
{
    public function addProperty(Request $request)
    {
        try {
            //Validated
            $validateProperty = Validator::make($request->all(), 
            [
                'name' => 'required',
                'hoa_id' => 'required',
                'address' => 'required',
                'price' => 'required',
                'status' => 'required'          
            ]);

            if($validateProperty->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateProperty->errors()
                ], 401);
            }

            $property = Property::create([         
                'name' => $request->name,
                'hoa_id' => $request->hoa_id,
                'landlord_id' => $request->landlord_id,
                'address' => $request->address,
                'description' => $request->description,
                'image' => $request->image,
                'price' => $request->price,
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
            $validateId = Validator::make($request->all(), 
            [
                'property_id' => 'required',         
            ]);

            if($validateId->fails()){
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

            $validateProperty = Validator::make($request->all(), 
            [
                'property_id' => 'required',
                'name' => 'required',
                'address' => 'required',
                'price' => 'required',
                'status' => 'required'          
            ]);

            if($validateProperty->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateProperty->errors()
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

            $property->name =  $request->name;
            $property->landlord_id =  $request->landlord_id;
            // $property->tenant_id =  $request->tenant_id;
            $property->address =  $request->address;
            $property->description =  $request->description;
            $property->image =  $request->image;
            $property->price =  $request->price;
            $property->status =  $request->status;
            $property->save();

            return response()->json([
                'status' => true,
                'message' => 'Property Updated Successfully',
                'tenant' => $property
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
            $validateId = Validator::make($request->all(), 
            [
                'property_id' => 'required',
                'tenant_id' => 'required'      
            ]);

            if($validateId->fails()){
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
}
