<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Storage;

class MemberController extends Controller
{
    public function insert_member(){

    	$curr_date = date('Y-m-d H:i:s');

    	//get payload request from client side
        $data = json_decode(file_get_contents("php://input"), true);

    	if (!isset($data['username']) or !isset($data['password']) or
    		!isset($data['name']) or !isset($data['gender']) or 
		    !isset($data['birth_date']) or !isset($data['email'])) {
    		return response()->json(['response_code'=>'400', 'state' => 'Missing Params : {username | password | name | gender | birth_date | email}. Insert Failed.', 'datetime' => $curr_date]);
    	} 

        // $id = $data['id'];
        $id = time();
        // $id = 2;
        $name = $data['name'];
        $username = $data['username'];
        $email = $data['email'];
        $password = $data['password'];
        $gender = $data['gender'];
        $birth_date = $data['birth_date'];
        $active = 1;
    	
    	$mysql = DB::insert("INSERT INTO ecom_cus_member(id, username, name, email, password, gender, birth_date, active, created_date, updated_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$id, $username, $name, $email, $password, $gender , $birth_date, $active, $curr_date, $curr_date]);

    	if ($mysql) {
    		return response()->json(['response_code'=>'200', 'state' => 'Insert Member Succ', 'datetime' => $curr_date]);
    	} else {
    		return response()->json(['response_code'=>'400', 'state' => 'Insert Failed', 'datetime' => $curr_date]);
    	}
    }

    public function update_member(Request $request){

    	$curr_date = date('Y-m-d H:i:s');

        //get payload request from client side
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['username']) or !isset($data['password']) or
    		!isset($data['name']) or !isset($data['gender']) or 
		    !isset($data['birth_date']) or !isset($data['email']) or !isset($data['active'])) {
    		return response()->json(['response_code'=>'400', 'state' => 'Missing Params : {username | password | name | gender | birth_date | email | active}. Insert Failed.', 'datetime' => $curr_date]);
    	} 	

    	$username = $data["username"];
    	$name = $data["name"];
    	$email = $data["email"];
    	$password = $data["password"];
    	$gender = $data["gender"];
    	$birth_date = $data["birth_date"];
    	$active = $data["active"];

    	$mysql = DB::update("UPDATE ecom_cus_member SET name = ?, email = ?, password = ?, gender = ?, birth_date = ?, active = ? WHERE username = ?", [$name, $email, $password, $gender, $birth_date, $active, $username]);

    	if ($mysql or $mysql == 0) {
    		return response()->json(['response_code'=>'200', 'state'=>'Update Member Succ', 'datetime' => $curr_date]);
    	} else {
    		return response()->json(['response_code'=>'400', 'state'=>'Update Member Failed', 'datetime' => $curr_date]);
    	}
    }

    public function get_cus_member_by_id(){
    	$curr_date = date('Y-m-d H:i:s');
    	$id = $_GET['member_id'];

    	$mysql = DB::select('SELECT * FROM ecom_cus_member WHERE id = ?', [$id]);

    	if ($mysql) {
    		return response()->json(['response_code'=>'200', 'state'=>'Get Member Succ', 'data' =>
				$mysql, 'datetime' => $curr_date]);
    	} else {
    		return response()->json(['response_code'=>'400', 'state'=>'Get Member Failed', 'data' => 
    			"", 'datetime' => $curr_date]);
    	}
    }

    public function get_cus_member_list(){
    	$curr_date = date('Y-m-d H:i:s');

    	$mysql = DB::select('SELECT * FROM ecom_cus_member');

    	if ($mysql) {
    		return response()->json(['response_code'=>'200', 'state'=>'Get Member Succ', 'data' =>
				$mysql, 'datetime' => $curr_date]);
    	} else {
    		return response()->json(['response_code'=>'400', 'state'=>'Get Member Failed', 'data' => 
    			"", 'datetime' => $curr_date]);
    	}
    }

    public function get_cus_member_count(){
        $curr_date = date('Y-m-d H:i:s');

        $mysql = DB::select('SELECT COUNT(*) as member_count FROM ecom_cus_member');

        if ($mysql) {
            return response()->json(['response_code'=>'200', 'state'=>'Get Member Succ', 'data' =>
                $mysql, 'datetime' => $curr_date]);
        } else {
            return response()->json(['response_code'=>'400', 'state'=>'Get Member Failed', 'data' => 
                "", 'datetime' => $curr_date]);
        }
    }

    public function delete_member_by_id(){
    	$curr_date = date('Y-m-d H:i:s');

    	//get payload request from client side
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['member_id']) ) {
    		return response()->json(['response_code'=>'400', 'state' => 'Missing Params : {member_id}. Insert Failed.', 'datetime' => $curr_date]);
    	} 

    	$sql = "DELETE FROM ecom_cus_member WHERE id = " . $data['member_id']; 
    	$mysql = DB::delete($sql);

    	if ($mysql or $mysql == 0) {
	    	return response()->json(['response_code'=>'200', 'state'=>'Delete Member Succ', 'data' => $mysql, 'datetime' => $curr_date]);
	   	} else {
	    	return response()->json(['response_code'=>'400', 'state'=>'Delete Member Failed', 'data' => "", 'datetime' => $curr_date]);
	    }
    }
}
