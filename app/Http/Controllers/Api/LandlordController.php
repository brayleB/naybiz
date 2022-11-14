<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
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
}
