<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\SubcriptionPayment;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class Payment extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     function getauth()
    {
      

        $username = "AZaxPe3pll4ZAqFAp4QXXFUB88WfYdBBPB5zaWwtbI4NPRcBQ3bTqmVACuj2xw88Q_TyxreAFW79FZ4N";
        $password = "EN9dMPrGIxoDJobqghkgy2FWV_2m92pj4BnLCW_NuvYR-UlbElirUvNxMXfMW1tm3gQiz-RHqYfuivgY";
        $data = array("grant_type" => "client_credentials", "ignoreCache" => "true", "return_authn_schemes" => "true", "return_client_metadata" => "true", "return_unconsented_scopes" => "true");

        $url = "https://api-m.sandbox.paypal.com/v1/oauth2/token";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

        $output = curl_exec($ch);
        curl_close($ch);



        $output = json_decode($output, true);

        return $output["access_token"];;

    

    }


    public function createProductSubcription(Request $request)
    {


        $timestamp = date("Y-m-d H:i:s",  time());
        


        $bearer_token= $this->getauth();
        $data = array("name" => "Homeowner Association Registration fee",
            "type" => "SERVICE",
            "description" => "HOA",
            "category" => "MEMBERSHIP_CLUBS_AND_ORGANIZATIONS",
            "image_url" => 'https://example.com/gallary/images/$timestamp.jpg',
            "home_url" => 'https://example.com/catalog/$timestamp.jpg',

        );
        $json_data = json_encode($data);

        $url = "https://api-m.sandbox.paypal.com/v1/catalogs/products";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($json_data),
            "Authorization: Bearer $bearer_token"
        ));

        $output = curl_exec($ch);
        curl_close($ch);



        print $output;


    }    



      public function listProductSubcription(Request $request)
    {

            $bearer_token= $this->getauth();
        
            $url = "https://api-m.sandbox.paypal.com/v1/catalogs/products?page_size=1&page=10&total_required=true&page=2";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $bearer_token"
            ));

            $output = curl_exec($ch);
            curl_close($ch);

           
                 foreach( json_decode($output, true) as $key => $value) {

            
                 if (is_array($value)) {

                    foreach ($value as $elem) {
                     
                        if (is_array($elem)) {
                            
                               
                                return($elem);
                          
                              
                          }
                    }    
                 }   
                

             }   

    }    

    public function createSubcriptionPlan(Request $request)
    {


       $bearer_token= $this->getauth(); 


       $data = array("product_id" => "PROD-8R287189RF912832F",
            "name" => "Monthly Subscription",
            "description" => "Monthly plan",
            "status" => "ACTIVE",
            "billing_cycles" =>
                  array(
                        

                        array(

                        "frequency" =>array(
                                        "interval_unit" => "MONTH",  //MONTH / YEAR
                                        "interval_count" => "1"
                                        ),


                        "tenure_type" => "REGULAR",
                        "sequence" => "1",
                        "total_cycles" => "12",

                        "pricing_scheme" =>array(
                                   "fixed_price" =>array(
                                    "value" => "100",
                                    "currency_code" => "USD"
                                  ),
                        ),


                        ),
             
                     ),
               
            "payment_preferences" =>array(
                "auto_bill_outstanding" => "true",
                "setup_fee" =>array(
                                "value" => "0",
                                "currency_code" => "USD"
                                ),

                 "setup_fee_failure_action" =>"CONTINUE",
                 "payment_failure_threshold" =>"3",
                ),

                "taxes" =>array(
                    "percentage" => "12",
                    "inclusive" => "true"
                )
                
            
        );



    

       
        $json_data = json_encode($data);

        $url = "https://api-m.sandbox.paypal.com/v1/billing/plans";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($json_data),
            "Authorization: Bearer $bearer_token"
        ));

        $output = curl_exec($ch);
        curl_close($ch);



        return $output;



    }    



     public function listPlanSubcription(Request $request)
    {


          try {


            $bearer_token= $this->getauth();
        
            $url = "https://api-m.sandbox.paypal.com/v1/billing/plans??page_size=10&page=1&total_required=true";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $bearer_token"
            ));

            $output = curl_exec($ch);
            curl_close($ch);

        //  echo $output;
            //print_r(json_decode($output, true));

             $arrayVAL=[];

              foreach( json_decode($output, true) as $key => $value) {



            
                 if (is_array($value)) {

                    foreach ($value as $elem) {
                       // unset($elem['links']);
                        if (is_array($elem)) {
                           
                       
                             
                                   // $arrayVAL[]=$elem;

                              if (array_key_exists('id',$elem) || array_key_exists('product_id',$elem) || array_key_exists('name',$elem) || array_key_exists('status',$elem) || array_key_exists('description',$elem)|| array_key_exists('usage_type',$elem) || array_key_exists('create_time',$elem)){

                                    if($elem['status']=='ACTIVE'){
                                       $arrayVAL[]= array(
                                            'status' => true,
                                            'id'=>$elem['id'],
                                            'product_id'=>$elem['product_id'],
                                            'product_name'=>$this->showproductsDetail($elem['product_id']),
                                            'status_plan'=>$elem['status'],
                                            'description'=>$elem['description'],
                                            'usage_type'=>$elem['usage_type'],
                                            'create_time'=>$elem['create_time'],
                                            'billing_cycles'=>$this->showSubcriptionDetail($elem['id'])

                                         );
                                    }
                                }   

                                   //  if (array_key_exists('id',$elem)){

                                   //   $arrayVAL[]=$this->showSubcriptionDetail($elem['id']);
                                   //  echo  ($elem['id']);

                              

                              
                          }
                    }    
                 }else{
                return response()->json([
                'status' => false,
                'message' => 'No  record found',
             
                ], 401);
                 }   
                

             }   

             return $arrayVAL;

         } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }     

    }  

     function showSubcriptionDetail($plan_id)
    {

     
       

        $bearer_token= $this->getauth();

        $url = "https://api-m.sandbox.paypal.com/v1/billing/plans/$plan_id";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Authorization: Bearer $bearer_token"
        ));

        $output = curl_exec($ch);
        curl_close($ch);





        $arrayVAL=[];

          foreach( json_decode($output, true) as $key => $value) {
        

                if($key=='billing_cycles'){
                    $arrayVAL= $value;
                }
                

         }   

         return $arrayVAL;

           


            //print_r(json_decode($output, true));

  


    }    


     public function showproductsDetail($plan_id)
    {

     
        // $plan_id='PROD-8R287189RF912832F';

        $bearer_token= $this->getauth();

        $url = "https://api-m.sandbox.paypal.com/v1/catalogs/products/$plan_id";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Authorization: Bearer $bearer_token"
        ));

        $output = curl_exec($ch);
        curl_close($ch);





          $productname='';
          foreach( json_decode($output, true) as $key => $value) {
        

                if($key=='name'){
                    $productname= $value;
                }
                

         }   

        return  $productname;

           


    //         //print_r(json_decode($output, true));

  


    } 


    public function deletePlanSubcription(Request $request){


            $bearer_token= $this->getauth();
            $planId = 'P-4LD85588PR800863LMPR66GA';


            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://api.sandbox.paypal.com/v1/payments/billing-plans/' . $planId);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $bearer_token,
            ));

          echo  $response = curl_exec($ch);
            curl_close($ch);

            $result = json_decode($response, true);
    } 



     public function deactivatePlanSubcription(Request $request){


           $plan_id='P-7JJ47571FM7061540MPR7FEY';


          $bearer_token= $this->getauth();
        
            $url = "https://api-m.sandbox.paypal.com/v1/billing/plans/$plan_id/deactivate";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $bearer_token"
            ));

            $output = curl_exec($ch);
            curl_close($ch);

            



           return json_encode($output, JSON_PRETTY_PRINT);

     }   





          public function subscribeRegister(Request $request){




           try {     

   
              $validateUser = Validator::make($request->all(), 
            [
              'username'=>'required|unique:users,username',
                'email'=>'required|email|unique:users,email',
                'password'=>'required|string',
                'plan_id'=>'required',
                'full_name'=>'required|string',       
            ]);


            if($validateUser->fails()){
            return response()->json([
            'status' => false,
            'message' => 'validation error',
            'errors' => $validateUser->errors()
            ], 401);
            }        



           $bearer_token= $this->getauth();


            $data =  array(
            "plan_id" => $request->plan_id,   
            "subscriber" => array(
                 'email'=>"val@example.com",
                 "shipping_address" => array("name" =>array("full_name" =>$request->full_name),

                     "address"=>array(
                        // "address_line_1" =>$request->address_line_1,
                        // "address_line_2" =>($request->address_line_2=='')? $request->address_line_1: $request->address_line_2,
                        "admin_area_2" =>"San Jose",
                        "admin_area_1" =>"CA",
                        "postal_code" =>"95131",
                        "country_code" =>"US" ),

                    ),



                ), 

          "application_context"=>array(
                    "brand_name" =>'NAYBIZ',
                    "shipping_preference" =>'GET_FROM_FILE',
                    "user_action" =>"SUBSCRIBE_NOW",
                    "return_url" =>(request()->secure())? 'https://naybiz.com/api/approve/registration' : 'http://127.0.0.1:8000/api/approve/registration',
                    "cancel_url" => (request()->secure())? 'https://naybiz.com/login' : 'http://127.0.0.1:8000/login'),
         
            );
           $json_data = json_encode($data);

            $url = "https://api-m.sandbox.paypal.com/v1/billing/subscriptions";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($json_data),
                "Authorization: Bearer $bearer_token"
            ));

            $output = curl_exec($ch);


            curl_close($ch);


          

               



          foreach( json_decode($output, true) as $key => $value) {


                if (is_array($value)) {

                  foreach ($value as $elem) {

                    if (array_key_exists('href',$elem)){

                   

                        if (str_contains($elem['href'],'subscriptions' )) {


                            // create user account for hoa

                                 $user = User::create([
                                'username' => $request->username,
                                'email' => $request->email,
                                'password' => Hash::make($request->password),
                                'type' => 'hoa',
                                'status' =>'pending',
                                'ba_token' => str_replace("https://www.sandbox.paypal.com/webapps/billing/subscriptions?ba_token=","",$elem['href']),
                                ]);


                                // $SubcriptionPayment = SubcriptionPayment::create([
                                // 'user_id' => $user->id,
                                // 'ba_token' => str_replace("https://www.sandbox.paypal.com/webapps/billing/subscriptions?ba_token=","",$elem['href']),

                                // 'status' =>'pending',
                                // ]);



                                $response=[


                                 'redirect_link'=> $elem['href'],


                                ];

                                return response($response, 201);


                      

                            



                        }
                  }  

                  // print_r($value);
                
              }   


          }  

 
       }

       } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }  

     }   



       public function subcriptionApprove(Request $request){




            $user=User::where('ba_token', $_GET['ba_token'])->first();

            echo $user->id;

             User::UpdateOrCreate(
                ['id' =>   $user->id],
                [    

                'status' =>'subscribed',
                ]
            );


            $SubcriptionPayment = SubcriptionPayment::create([
                'user_id'=> $user->id,
                'subscription_id'=>$_GET['subscription_id'],
                'ba_token'=> $_GET['ba_token'],
                'token'=>  $_GET['token'],
                'status' =>'paid',
            ]);



             return redirect('https://naybiz.com/login');




       }


     public function listTrasactionforSubcription($subcriptionid){



        $bearer_token= $this->getauth();

        $url = "https://api-m.sandbox.paypal.com/v1/billing/subscriptions/$subcriptionid";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Authorization: Bearer $bearer_token"
        ));

         $output = curl_exec($ch);
        curl_close($ch);


        return  $output = json_decode($output, true);


     }


     public function listusertransaction(Request $request){

        try {



           $validateUser = Validator::make($request->all(), 
            [
              'user_id'=>'required|exists:users,id',
                 
            ]);


            if($validateUser->fails()){
            return response()->json([
            'status' => false,
            'message' => 'validation error',
            'errors' => $validateUser->errors()
            ], 401);
            }        



            $checkifexist=SubcriptionPayment::where('user_id', $request->user_id)->orderBy('id', 'DESC')->count();


            if ($checkifexist==0){
                return response()->json([
                'status' => false,
                'message' => 'not record found'
                ], 401);
            }

              if ($validateFile->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateFile->errors()
                ], 401);
            }

           // $fields=$request->validate([
           //      'user_id'=>'required|exists:users,id',
           //  ]);

         $SubcriptionPayment=SubcriptionPayment::where('user_id', $request->user_id)->orderBy('id', 'DESC')->get();


         $Subscrip_list = array();



        foreach ($SubcriptionPayment as $data) {

             $Subscrip_list [] =array(

                    "id" => $data->id,
                    "user_id"=>$data->user_id,
                    "subscription_id"=>$data->subscription_id,
                    "subscription_info"=>$this->listTrasactionforSubcription($data->subscription_id),
                    "ba_token"=>$data->ba_token,
                    "token"=>$data->token,
                    "created_at"=>$data->created_at,
                    "updated_at"=>$data->updated_at,
                );

        }


   


        return response($Subscrip_list, 201);


         } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

     }



    


}
