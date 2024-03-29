<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Database\Seeders\QuestionSeeder;

class AuthController extends Controller
{
    /**
     * Create User
     * @param Request $request
     * @return User 
     */
    public function createUser(Request $request)
    {
        try {


            //Validated
            $validateUser = Validator::make($request->all(), 
            [
                'username' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'type' => 'required',
                'status' => 'required'               
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }        
           
            $user = User::create([
                'assoc_hoa_id' => $request->assoc_hoa_id,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'image' =>  $request->image,
                'type' => $request->type,
                'status' => $request->status
            ]);

            if($user->type == 'hoa') {
                $questionSeeder = new QuestionSeeder();
                $questionSeeder->run($user->id);
            }

            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken,
                'user' => $user
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request)
    {


       

        try {
            $validateUser = Validator::make($request->all(), 
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            //check hoa if paid



            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();




             


            if($user->type=='hoa'){
                if($user->status !='subscribed'){
                    return response()->json([
                    'status' => false,
                    'message' => 'user not yet subscribe.',
                    'pay_here' => 'https://www.sandbox.paypal.com/webapps/billing/subscriptions?ba_token='.$user->ba_token,
                    ], 401);

                }
            }

        
            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken,
                'user' => $user
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


    /**
     * Logout User
     * @param Request $request
     * @return User 
     */
    public function logout(Request $request)
    {
        try {
            auth()->user()->tokens()->delete();   
            return response()->json([       
                'status' => true,        
                'message' => 'User Logged Out Successfully',                
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
        
    }

    public function updateUserProfile(Request $request, $id)
    {
        try {

            $validateFile = Validator::make(
                $request->all(),
                [
                    'image' => 'mimes:jpg,jpeg,png,bmp,tiff |max:8192',
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

            $user = User::find($id);

            if ($user === null) {
                return response()->json([
                    'status' => false,
                    'message' => 'User does not exist.',
                ], 401);
            }

            $validateEmail = Validator::make(
                $request->all(),
                [
                    'email' => 'email|unique:users,email,'.$user->id
                ]
            );

            if ($validateEmail->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateEmail->errors()
                ], 401);
            }

            $email = $request->email;
            if($email) {
                $user->email = $email;
            }

            $file = NULL;
            
            //remove old file
            if($user->image) {
                Storage::delete($user->image);
            }

            if ($request->file('image')) {
                //store file into properties folder
                $file = $request->file('image')->store('media/users');
                
            }

             $user->image = $file;
             $user->first_name = $request->first_name;
             $user->last_name = $request->last_name;
             $user->contact_no = $request->contact_no;
             $user->address = $request->address;
             $user->city = $request->city;
             $user->state = $request->state;
             $user->country = $request->country;
             $user->save();

            return response()->json([
                'status' => true,
                'message' => 'User Updated Successfully.',
                'user' => $user
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }

    public function getUserById(Request $request, $id)
    {
        $user = User::find($id);

        if ($user === null) {
            return response()->json([
                'status' => false,
                'message' => 'User does not exist.',
            ], 401);
        }

        return response()->json([
            'status' => true,
            'message' => 'User Fetched Successfully',
            'user' => $user
        ], 200);
    }  
    
    public function getAllHoa()
    {
        $user = User::where('type', 'hoa')->get();

        return response()->json([
            'status' => true,
            'message' => 'HOA`s Fetched Successfully',
            'User' => $user
        ], 200);
    }
}