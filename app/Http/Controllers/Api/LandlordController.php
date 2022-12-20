<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Property;
use Illuminate\Http\Request;

class LandlordController extends Controller
{
    public function getLandlordsByHoaRequested(Request $request, $id)
    {
        $landlords = User::where('assoc_hoa_id', $id)->where('status', 'requested')->get();

        return response()->json([
            'status' => true,
            'message' => 'Landlords Fetched Successfully',
            'landlords' => $landlords
        ], 200);
    }

    public function getLandlordsByHoaAccepted(Request $request, $id)
    {
        $landlords = User::where('assoc_hoa_id', $id)->where('status', 'accepted')->get();

        return response()->json([
            'status' => true,
            'message' => 'Landlords Fetched Successfully',
            'landlords' => $landlords
        ], 200);
    }

    public function viewLandLord(Request $request, $id)
    {
        $landlord = User::find($id);

        if ($landlord === null) {
            return response()->json([
                'status' => false,
                'message' => 'Landlord does not exist.',
            ], 401);
        }

        if ($landlord->type !== "landlord") {
            return response()->json([
                'status' => false,
                'message' => 'User is not a landlord.',
            ], 401);
        }

        $properties = Property::where('landlord_id', $id)
        ->where('status', 'active')
        ->get();

        return response()->json([
            'status' => true,
            'message' => 'Landlord details Fetched Successfully.',
            'landlord' => $landlord,
            'properties' => $properties
        ], 200);
    }
}
