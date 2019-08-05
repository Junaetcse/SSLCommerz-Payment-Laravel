<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\SSLCommerzLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Routing\UrlGenerator;
use App\Http\Controllers;


class PublicSslCommerzPaymentController extends Controller
{
    //

    public function index(Request $request){
        $sslc = new SSLCommerz();
        $payment_info = $sslc->paymentInfo($request->all());
    
        if($payment_info){
            $results = $sslc->initiate($payment_info, false);
            
            if ($results != null) {
                Transaction::updateTransaction($payment_info['tran_id'], Transaction::STATUS_INITIATED);
                SSLCommerzLog::storeSSLCommerzLog($request->get('user_id'), $payment_info['tran_id'],'INITIATED','Transection has initiated',null);
                Log::info("This transection  initiate : " .$payment_info['tran_id']);
              
                if (isset($results['GatewayPageURL'])) {
                  
                    if($request->ajax()){
                        $response['status']= $results['status'];
                        $response['GatewayPageURL']= $results['GatewayPageURL'];
                        $response['tran_id'] = $payment_info['tran_id'];
                        return $this->respond($response);
                    }

                    return Redirect::to($results['GatewayPageURL']);
                }else {
                    return "No redirect URL found!";
                }
                
               
            }
        }
    }

    public function success(Request $request)
    {
        
        Log::info('Transaction id - '.$request->get('tran_id'),$request->all());
       
        $sslc = new SSLCommerz();
        $tran_id = $request->get('tran_id');
        $order_detials = Transaction::getTransaction($tran_id)->first();
        // $user_id = $order_detials->user->id;
        // $subs_id = $order_detials->subscription->id;
       

        if($order_detials->transaction_status== Transaction::STATUS_INITIATED){
            Log::info('SSLCOMMERZ_CALLBACK_SUCCESS:- Transaction status initiate:  '.$tran_id);

            $validation = $sslc->orderValidate($tran_id, $order_detials->amount, $order_detials->currency, $request->all());
            if($validation == TRUE) {
                Log::info('SSLCOMMERZ_CALLBACK_SUCCESS:- Enter if validation true ');
               Transaction::updateTransaction($tran_id,Transaction::STATUS_COMPLETED);
                $message = "Transaction is successfully Complete";
               // return view('payment-redirect-page')->with('message','Transaction is successfully Complete');
            }else {

                Transaction::updateTransaction($tran_id,Transaction::STATUS_FAILED);
                $message = "validation Fail Validate";
               // return view('payment-redirect-page')->with('message','validation Fail Validate');
            }

        } else if($order_detials->transaction_status== Transaction::STATUS_COMPLETED) {
            $message = "Transaction is successfully Complete";
            //return view('payment-redirect-page')->with('message','Transaction is successfully Complete');

        } else {
            $message = "Invalid Transaction";
            //return view('payment-redirect-page')->with('message','Invalid Transaction');
        }
        return view('home')->with('message',$message);
    }


    public function fail(Request $request)
    {
        $tran_id = $request->get('tran_id');
        $order_detials = Transaction::getTransaction($tran_id)->first();
        if($order_detials->transaction_status== Transaction::STATUS_INITIATED)
        {
            Transaction::updateTransaction($tran_id,Transaction::STATUS_FAILED);
            Log::info('Transaction Fail  Transaction :-'.$tran_id);
            $message = "Transaction is Falied";

        }
        else if($order_detials->transaction_status== Transaction::STATUS_COMPLETED)
        {
            Log::info('Transaction is already Successful :-'.$tran_id);
            $message = "Transaction is already Successful";
        }
        else
        {
            $message = "Transaction is Invalid";
        }
        return $message;

    }



    public function cancel(Request $request)
    {
        $tran_id = $request->get('tran_id');
        $order_detials = Transaction::getTransaction($tran_id)->first();

        if($order_detials->transaction_status== Transaction::STATUS_INITIATED)
        {
            Transaction::updateTransaction($tran_id,Transaction::STATUS_CANCELED);
            Log::info('Transaction is Cancel ,  Transaction No :-'.$tran_id);
            $message = "Transaction is Cancel";
        }
        else if($order_detials->transaction_status== Transaction::STATUS_COMPLETED)
        {
            Log::info('Transaction is already Successful Transaction No :-'.$tran_id);
            $message = "Transaction is already Successful";
        }
        else
        {
            $message = "Transaction is Invalid";
        }

        return $message;
    }


    public function ipn(Request $request)
    {

        $tran_id = $request->input('tran_id');
        $order_detials = Transaction::getTransaction($tran_id)->first();

        #Received all the payement information from the gateway
        if($tran_id) #Check transation id is posted or not.
        {

            $order_details = Transaction::getTransaction($tran_id)->first();
            if($order_details->transaction_status == Transaction::STATUS_INITIATED) {
                $sslc = new SSLCommerz();
                if ($request->get('status') == 'FAILED' || $request->get('status') == 'CANCELLED ') {
                    Transaction::updateTransaction($tran_id,Transaction::STATUS_FAILED);
                    Log::info('Transaction Fail From IPN, Transaction :-'.$tran_id);
                    if ($request->ajax()) {
                        return response()->json();
                    }

                    echo "validation Fail";

                }else {
                    $validation = $sslc->orderValidate($tran_id, $order_details->amount, $order_details->currency, $request->all());
                    if ($validation == TRUE) {
                        Transaction::updateTransaction($tran_id,Transaction::STATUS_COMPLETED);
                        Log::info('Transaction is successfully Completed From IPN, Transaction :-'.$tran_id);
                         echo "Transaction is successfully Complete";
                    }
                }

            }else if($order_details->transaction_status == Transaction::STATUS_COMPLETED) {
                Log::info('Transaction is already Successful From IPN , Transaction :-'.$tran_id);
                echo "Transaction is already successfully Complete";
            }else {
                echo "Invalid Transaction";
            }
        }
        else
        {
            Log::info('Transaction is not present From IPN , Transaction :-'.$tran_id);
            echo "Inavalid Data";
        }
    }


}
