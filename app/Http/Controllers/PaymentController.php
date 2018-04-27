<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Storage;


class PaymentController extends Controller
{
    public function insert_payment(){

    	$curr_date = date('Y-m-d H:i:s');

    	//get payload request from client side
        $data = json_decode(file_get_contents("php://input"), true);

    	if (!isset($data['payment_method']) or !isset($data['receipt_img']) or !isset($data['order_list_id'])) {
    		return response()->json(['response_code'=>'400', 'state' => 'Missing Params : {payment_method | receipt_img | order_list_id}. Insert Failed.', 'datetime' => $curr_date]);
    	} 

        $id = time();
        $payment_method = $data['payment_method'];
        $receipt_img = $data['receipt_img'];
        $order_list_id = $data['order_list_id'];
    	
    	$mysql = DB::insert("INSERT INTO ecom_cus_payment(id, payment_method, receipt_img, order_list_id, created_date, updated_date) VALUES (?, ?, ?, ?, ?, ?)", [$id, $payment_method, $receipt_img, $order_list_id, $curr_date, $curr_date]);

    	if ($mysql) {
    		return response()->json(['response_code'=>'200', 'state' => 'Insert Payment Succ', 'datetime' => $curr_date]);
    	} else {
    		return response()->json(['response_code'=>'400', 'state' => 'Insert Failed', 'datetime' => $curr_date]);
    	}
    }

    public function get_payment_list(){
    	$curr_date = date('Y-m-d H:i:s');
    
    	$mysql = DB::select('SELECT ecom_cus_payment.id, receipt_img, order_list_id, ecom_cus_payment.created_date, ecom_payment_method.name FROM ecom_cus_payment 
    		LEFT JOIN ecom_payment_method ON ecom_cus_payment.payment_method = ecom_payment_method.id');

    	if ($mysql) {
    		return response()->json(['response_code'=>'200', 'state'=>'Get Order List Succ', 'data' =>
				$mysql, 'datetime' => $curr_date]);
    	} else {
    		return response()->json(['response_code'=>'400', 'state'=>'Get Order List Failed', 'data' => 
    			"", 'datetime' => $curr_date]);
    	}
    }
}
