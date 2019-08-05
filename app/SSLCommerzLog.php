<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SSLCommerzLog extends Model
{
    //
    protected $fillable = ['user_id','trans_id','status','message','session_key'];



    public static function storeSSLCommerzLog($user_id,$trans_id,$status,$message,$session_key){
        return SSLCommerzLog::create([
             'user_id' => $user_id,
             'trans_id' =>$trans_id,
             'status' => $status,
             'message' =>$message,
             'session_key' =>$session_key
         ]);
     }

     public function getSSLCommerzLog($trans_id){
         return SSLCommerzLog::where('trans_id',$trans_id)->first();
     }

     public static function updateSSLCommerzLog($trans_id,$status,$message,$session_key)
     {
         $SSLCommerzLog = SSLCommerzLog::where('trans_id',$trans_id)->first();
         $SSLCommerzLog->status = $status;
         $SSLCommerzLog->message = $message;
         $SSLCommerzLog->session_key = $session_key;
         $SSLCommerzLog->save();
 
     }

}
