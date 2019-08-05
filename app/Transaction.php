<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    protected $fillable = ['user_id','subscription_id','media_id','amount','currency','transaction_status','session_key','media_id'];

    const STATUS_INITIATED = 'Initiated';
    const STATUS_COMPLETED = 'Completed';
    const STATUS_FAILED = 'Failed';
    const STATUS_CANCELED = 'Canceled';


    
    public static function store($user_id,$subscription_id,$media_id,$amount,$currency,$Pending){

        return Transaction::create([
             'user_id' => $user_id,
             'subscription_id' =>$subscription_id,
             'media_id' => $media_id,
             'amount' =>$amount,
             'currency' =>$currency,
             'transaction_status' => $Pending
         ]);
     }


     
    public static function updateTransaction($id, $status)
    {
        $transaction = Transaction::where('id',$id)->first();
        $transaction->transaction_status = $status;
        $transaction->save();

    }


    public static function getTransaction($id){
        return Transaction::where('id', $id);
    }


    public static function updateSessionKey($id, $key){
        $transaction = Transaction::where('id',$id)->first();
        $transaction->session_key = $key;
        $transaction->save();
    }
     
}
