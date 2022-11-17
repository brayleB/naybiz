<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\TenantInvitation;
use App\Mail\LandlordInvitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function inviteTenant(Request $request)
    {
        $email = $request->email;
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $link = $request->link;


        Mail::to($email)->send(new TenantInvitation($first_name, $last_name, $link));

        return response()->json([
            'status' => true,
            'message' => 'Tenant invitation sent Successfully.'
        ], 200);
    }

    public function inviteLandlord(Request $request)
    {
        $email = $request->email;
        $link = $request->link;


        Mail::to($email)->send(new LandlordInvitation($link));

        return response()->json([
            'status' => true,
            'message' => 'Landlord invitation sent Successfully.'
        ], 200);
    }
}
