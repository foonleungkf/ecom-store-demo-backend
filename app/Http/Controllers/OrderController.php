<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Storage;

class OrderController extends Controller
{
    public function insert_order(){

    	$curr_date = date('Y-m-d H:i:s');

    	//get payload request from client side
        $data = json_decode(file_get_contents("php://input"), true);

    	if (!isset($data['member_id'])) {
    		return response()->json(['response_code'=>'400', 'state' => 'Missing Params : {member_id}. Insert Failed.', 'datetime' => $curr_date]);
    	} 

        // $id = $data['id'];
        $id = time();
        $order_status = 1;
        $payment_status = 1;
        $devlivery_status = 1;
        $member_id = $data['member_id'];
    	
    	$mysql = DB::insert("INSERT INTO ecom_cus_order(id, order_status, payment_status, delivery_status, member_id, created_date, updated_date) VALUES (?, ?, ?, ?, ?, ?, ?)", [$id, $order_status, $payment_status, $devlivery_status, $member_id , $curr_date, $curr_date]);

    	if ($mysql) {
    		return response()->json(['response_code'=>'200', 'state' => 'Insert Order Succ', 'datetime' => $curr_date]);
    	} else {
    		return response()->json(['response_code'=>'400', 'state' => 'Insert Failed', 'datetime' => $curr_date]);
    	}
    }

    public function insert_order_item(){

    	$curr_date = date('Y-m-d H:i:s');

    	//get payload request from client side
        $data = json_decode(file_get_contents("php://input"), true);

    	if (!isset($data['order_list_id']) or !isset($data['product_id']) ) {
    		return response()->json(['response_code'=>'400', 'state' => 'Missing Params : {order_list_id | product_id}. Insert Failed.', 'datetime' => $curr_date]);
    	} 

        // $id = $data['id'];
        $id = time();
        $product_id = $data['product_id'];
        $order_list_id = $data['order_list_id'];
        $amount = $data['amount'];
    	
    	$mysql = DB::insert("INSERT INTO ecom_order_item(id, product_id, order_list_id, amount, created_date, updated_date) VALUES (?, ?, ?, ?, ?, ?)", [$id, $product_id, $order_list_id, $amount, $curr_date, $curr_date]);

    	if ($mysql) {
    		return response()->json(['response_code'=>'200', 'state' => 'Insert Order Item to List Succ', 'datetime' => $curr_date]);
    	} else {
    		return response()->json(['response_code'=>'400', 'state' => 'Insert Failed', 'datetime' => $curr_date]);
    	}
    }

    public function get_order_list(){
    	$curr_date = date('Y-m-d H:i:s');
    
    	$mysql = DB::select('SELECT ecom_cus_order.id, order_status, payment_status, delivery_status, ecom_cus_order.created_date, ecom_cus_member.name, ecom_cus_member.email FROM ecom_cus_order LEFT JOIN ecom_cus_member ON ecom_cus_order.member_id = ecom_cus_member.id');

    	if ($mysql) {
    		return response()->json(['response_code'=>'200', 'state'=>'Get Order List Succ', 'data' =>
				$mysql, 'datetime' => $curr_date]);
    	} else {
    		return response()->json(['response_code'=>'400', 'state'=>'Get Order List Failed', 'data' => 
    			"", 'datetime' => $curr_date]);
    	}
    }

    public function get_order_count(){
        $curr_date = date('Y-m-d H:i:s');
    
        $mysql = DB::select('SELECT COUNT(*) as order_count FROM ecom_cus_order');

        if ($mysql) {
            return response()->json(['response_code'=>'200', 'state'=>'Get Order Count Succ', 'data' =>
                $mysql, 'datetime' => $curr_date]);
        } else {
            return response()->json(['response_code'=>'400', 'state'=>'Get Order Count Failed', 'data' => 
                "", 'datetime' => $curr_date]);
        }
    }

    public function get_order_list_by_id(){
    	$curr_date = date('Y-m-d H:i:s');
    	$id = $_GET['order_list_id'];

    	$mysql = DB::select('SELECT ecom_cus_order.id, order_status, payment_status, delivery_status, ecom_cus_order.created_date, ecom_cus_member.name, ecom_cus_member.email , ecom_payment_method.name as payment_method, ecom_delivery_method.name as delivery_method FROM ecom_cus_order 
            LEFT JOIN ecom_cus_member ON ecom_cus_order.member_id = ecom_cus_member.id 
            LEFT JOIN ecom_payment_method ON ecom_cus_order.payment_method = ecom_payment_method.id 
            LEFT JOIN ecom_delivery_method ON ecom_cus_order.delivery_method = ecom_delivery_method.id where ecom_cus_order.id = ?', [$id]);

    	if ($mysql) {
    		return response()->json(['response_code'=>'200', 'state'=>'Get Order List Succ', 'data' =>
				$mysql, 'datetime' => $curr_date]);
    	} else {
    		return response()->json(['response_code'=>'400', 'state'=>'Get Order List Failed', 'data' => 
    			"", 'datetime' => $curr_date]);
    	}
    }

    public function get_order_item_by_id(){
    	$curr_date = date('Y-m-d H:i:s');
    	$id = $_GET['order_list_id'];

    	$mysql = DB::select('SELECT name, amount, price , (amount*price) as item_total FROM ecom_order_item LEFT JOIN ecom_product_item ON ecom_order_item.product_id = ecom_product_item.id WHERE ecom_order_item.order_list_id = ?', [$id]);

    	if ($mysql) {
    		return response()->json(['response_code'=>'200', 'state'=>'Get Order Item Succ', 'data' =>
				$mysql, 'datetime' => $curr_date]);
    	} else {
    		return response()->json(['response_code'=>'400', 'state'=>'Get Order Item Failed', 'data' => 
    			"", 'datetime' => $curr_date]);
    	}
    }

    public function delete_order_list_by_id(){
    	$curr_date = date('Y-m-d H:i:s');

    	//get payload request from client side
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['order_list_id']) ) {
    		return response()->json(['response_code'=>'400', 'state' => 'Missing Params : {order_list_id}. Insert Failed.', 'datetime' => $curr_date]);
    	} 

    	$sql = "DELETE FROM ecom_cus_order WHERE id = " . $data['order_list_id']; 
    	$mysql = DB::delete($sql);

    	if ($mysql or $mysql == 0) {
	    	return response()->json(['response_code'=>'200', 'state'=>'Delete Order Succ', 'data' => $mysql, 'datetime' => $curr_date]);
	   	} else {
	    	return response()->json(['response_code'=>'400', 'state'=>'Delete Order Failed', 'data' => "", 'datetime' => $curr_date]);
	    }
    }

    public function update_order_status(Request $request){

    	$curr_date = date('Y-m-d H:i:s');

        //get payload request from client side
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data["id"])){
            return response()->json(['response_code'=>'400', 'state' => 'Missing Params : {id}. Updated Failed.', 'datetime' => $curr_date]);
        }   

        $id = $data["id"];
        $status = $data["order_status"];

    	$mysql = DB::update("UPDATE ecom_cus_order SET order_status = ?, updated_date = ? WHERE id = ?", [$status, $curr_date, $id]);

    	if ($mysql or $mysql == 0) {
    		return response()->json(['response_code'=>'200', 'state'=>'Update Order Status Succ', 'datetime' => $curr_date]);
    	} else {
    		return response()->json(['response_code'=>'400', 'state'=>'Update Order Status Failed', 'datetime' => $curr_date]);
    	}
    }

    public function update_payment_status(Request $request){

    	$curr_date = date('Y-m-d H:i:s');

        //get payload request from client side
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data["id"])){
            return response()->json(['response_code'=>'400', 'state' => 'Missing Params : {id}. Updated Failed.', 'datetime' => $curr_date]);
        }   

        $id = $data["id"];
        $status = $data["payment_status"];

    	$mysql = DB::update("UPDATE ecom_cus_order SET payment_status = ?, updated_date = ? WHERE id = ?", [$status, $curr_date, $id]);

    	if ($mysql or $mysql == 0) {
    		return response()->json(['response_code'=>'200', 'state'=>'Update Payment Status Succ', 'datetime' => $curr_date]);
    	} else {
    		return response()->json(['response_code'=>'400', 'state'=>'Update Payment Status Failed', 'datetime' => $curr_date]);
    	}
    }

    public function update_delivery_status(Request $request){

    	$curr_date = date('Y-m-d H:i:s');

        //get payload request from client side
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data["id"])){
            return response()->json(['response_code'=>'400', 'state' => 'Missing Params : {id}. Updated Failed.', 'datetime' => $curr_date]);
        }   

        $id = $data["id"];
        $status = $data["delivery_status"];

    	$mysql = DB::update("UPDATE ecom_cus_order SET delivery_status = ?, updated_date = ? WHERE id = ?", [$status, $curr_date, $id]);

    	if ($mysql or $mysql == 0) {
    		return response()->json(['response_code'=>'200', 'state'=>'Update Delivery Status Succ', 'datetime' => $curr_date]);
    	} else {
    		return response()->json(['response_code'=>'400', 'state'=>'Update Delivery Status Failed', 'datetime' => $curr_date]);
    	}
    }

    




}
