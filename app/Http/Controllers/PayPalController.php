<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\CompleteTrasaction;
use App\Models\ProcessTrasaction;
class PayPalController extends Controller
{

    public function processTransaction(Request $request, $transaction_id, $amount)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('successTransaction'),
                "cancel_url" => route('cancelTransaction'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $amount
                    ]
                ]
            ]
        ]);
        if (isset($response['id']) && $response['id'] != null) {


             
            // redirect to approve href
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {

                    $Trans=ProcessTrasaction::create([
                    'transaction_id'=>$transaction_id,
                    'amount'=>$amount,
                    'token'=>$response['id'],

                    ]);

                    return redirect()->away($links['href']);
                }
            }
     
            return response([


            'error'=>'Something went wrong',

            ], 400);
        } else {
            
            return response([


            'error'=>$response['message'] ?? 'Something went wrong.',

            ], 400);
        }
    }

    /**
     * success transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function successTransaction(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {


             $transinfo=ProcessTrasaction::where('token', $_GET['token'])->first();



             $Trans=CompleteTrasaction::create([
                'payerid'=>$_GET['PayerID'],
                'token'=>$_GET['token'],
                ]);

            return response([


            'message'=>'Transaction complete',
            'transaction_id' =>$transinfo->transaction_id

            ], 201);

            // return redirect()
            //     ->route('createTransaction')
            //     ->with('success', 'Transaction complete.');
        } else {
            return response([


            'error'=>$response['message'] ?? 'Something went wrong.',

            ], 400);
        }
    }
    /**
     * cancel transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelTransaction(Request $request)
    {
        // return redirect()
        //     ->route('createTransaction')
        //     ->with('error', $response['message'] ?? 'You have canceled the transaction.');


          return response([


            'error'=>$response['message'] ?? 'Something went wrong.',

            ], 400);
    }
}
