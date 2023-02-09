<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
            "name" => "Yearly Subscription",
            "description" => "Yearly plan",
            "status" => "ACTIVE",
            "billing_cycles" =>
                  array(
                        

                        array(

                        "frequency" =>array(
                                        "interval_unit" => "YEAR",  //MONTH / YEAR
                                        "interval_count" => "1"
                                        ),


                        "tenure_type" => "REGULAR",
                        "sequence" => "1",
                        "total_cycles" => "1",

                        "pricing_scheme" =>array(
                                   "fixed_price" =>array(
                                    "value" => "1000",
                                    "currency_code" => "USD"
                                  ),
                        ),


                        ),
             
                     ),
               
            "payment_preferences" =>array(
                "auto_bill_outstanding" => "true",
                "setup_fee" =>array(
                                "value" => "10",
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
                                            'id'=>$elem['id'],
                                            'product_id'=>$elem['product_id'],
                                            'product_name'=>$this->showproductsDetail($elem['product_id']),
                                            'status'=>$elem['status'],
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
                 }   
                

             }   

             return $arrayVAL;

         

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


           $plan_id='P-59H65099GB516305HMPR67YQ';


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



            // "name" =>array("given_name" => "FooBuyer", "surname" => "Jones"),
            // return  array(
            // "plan_id" => $request->plan_id,   
            // "subscriber" => array(
                
            //      'email'=>"val@example.com",
            //      "shipping_address" => array("name" =>array("full_name" =>"VALTOT"),

            //          "address"=>array("address_line_1" =>"2211 N First Street",
            //             "address_line_2" =>"Building 17",
            //             "admin_area_2" =>"San Jose",
            //              "admin_area_1" =>"CA",
            //              "postal_code" =>"95131",
            //              "country_code" =>"US" ),

            //         ),

            //     ), 
         
            // );


            $fields=$request->validate([
                'email'=>'required|email',
                'password'=>'required|string',
                'plan_id'=>'required|string',
                'full_name'=>'required|string',
                'address_line_1'=>'required|string',
                'address_line_2'=>'nullable|string',
             
                // 'postal_code'=>'required|string',
                // 'country_code'=>'required|string',

            ]);



         


           $bearer_token= $this->getauth();


            $data =  array(
            "plan_id" => $request->plan_id,   
            "subscriber" => array(
                 'email'=>"val@example.com",
                 "shipping_address" => array("name" =>array("full_name" =>$request->full_name),

                     "address"=>array(
                        "address_line_1" =>$request->address_line_1,
                        "address_line_2" =>($request->address_line_2=='')? $request->address_line_1: $request->address_line_2,
                        "admin_area_2" =>"San Jose",
                        "admin_area_1" =>"CA",
                        "postal_code" =>"95131",
                        "country_code" =>"US" ),

                    ),

                ), 
         
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

           echo $output = curl_exec($ch);
            curl_close($ch);




            //  $response=[


            //     'message'=>'Sucessfully save',
               

            // ];

            // return response($response, 201);



 
          

     }   



    


}
