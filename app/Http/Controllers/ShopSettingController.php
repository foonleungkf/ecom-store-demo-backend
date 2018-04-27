<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Storage;

class ShopSettingController extends Controller
{   
    
    public function insert(){

    	$curr_date = date('Y-m-d H:i:s');

    	if (!isset($_POST['id']) or !isset($_POST['name']) or !isset($_POST['email']) or !isset($_POST['country']) or !isset($_POST['lang'])) {
    		return response()->json(['response_code'=>'400', 'state' => 'Missing Params : {id | name | email | country | lang}. Insert Failed.', 'datetime' => $curr_date]);
    	} 

        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $country = $_POST['country'];
        $lang = $_POST['lang'];
    	$active = "1"; // active == 1 if active
    	
    	$mysql = DB::insert("INSERT INTO ecom_shop_info(id, name,  email, country, lang, active, created_date, updated_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", [$id, $name, $email, $country, $lang, $active, $curr_date, $curr_date]);

    	if ($mysql) {
    		return response()->json(['response_code'=>'200', 'state' => 'Insert Shop Setting Succ', 'datetime' => $curr_date]);
    	} else {
    		return response()->json(['response_code'=>'400', 'state' => 'Insert Failed', 'datetime' => $curr_date]);
    	}
    }

    public function update(Request $request){

    	$curr_date = date('Y-m-d H:i:s');

        //get payload request from client side
        $data = json_decode(file_get_contents( "php://input"), true);

        if (!isset($data["id"])){
            return response()->json(['response_code'=>'400', 'state' => 'Missing Params : {id}. Updated Failed.', 'datetime' => $curr_date]);
        }   

        $id = $data["id"];
        $shop_desc = $data['shop_desc'];
        $name = $data['name'];
        $email = $data['email'];
        $lang = $data['lang'];
        $country = $data['country'];
        $currency = $data['currency'];
        $phone = $data['contact_phone'];
        $address = $data['contact_address'];
        $post_code = $data['post_code'];

    	$mysql = DB::update("UPDATE ecom_shop_info SET name = ? , shop_desc = ?, email = ?, country = ?, currency = ?, post_code = ?, lang = ?, contact_phone = ?, contact_address = ?, updated_date = ? WHERE id = ?", [$name, $shop_desc, $email, $country, $currency, $post_code, $lang,
    		 $phone, $address, $curr_date, $id]);

    	if ($mysql or $mysql == 0) {
    		return response()->json(['response_code'=>'200', 'state'=>'Update Shop Info Succ', 'datetime' => $curr_date]);
    	} else {
    		return response()->json(['response_code'=>'400', 'state'=>'Update Shop Info Failed', 'datetime' => $curr_date]);
    	}
    }

    public function get(){
    	$id = $_GET['id'];
    	$curr_date = date('Y-m-d H:i:s');

    	$mysql = DB::select('SELECT id, name, shop_desc, email, country, post_code, lang, contact_phone, contact_address, created_date, updated_date, currency, shop_logo FROM ecom_shop_info WHERE id = ?', [$id]);

    	if ($mysql) {
    		return response()->json(['response_code'=>'200', 'state'=>'Get Shop Info Succ', 'data' =>
				$mysql, 'datetime' => $curr_date]);
    	} else {
    		return response()->json(['response_code'=>'400', 'state'=>'Get Shop Info Failed', 'data' => 
    			"", 'datetime' => $curr_date]);
    	}
    }

    public function uploadShopLogo(Request $request){
        $curr_date = date('Y-m-d H:i:s');
        $client_side = "http://192.168.0.105:4200/setting-part";


        if (!isset($_POST['id']) or $_FILES['logo']['error'] > 0) {
            return response()->json(['response_code'=>'400', 'state' => 'Missing Params : {id | logo}. Updated Failed.', 'datetime' => $curr_date]);
        }

        $file = $request->file('logo'); 

        // generate a new filename. getClientOriginalExtension() for the file extension
        $filename = 'profile-photo-' . time() . '.' . $file->getClientOriginalExtension();

        // save to storage/app/photos as the new $filename
        $path = $file->storeAs('photos', $filename);

        $id = isset($_POST['id']);
        $mysql = DB::update('UPDATE ecom_shop_info SET shop_logo = ?, updated_date = ? WHERE id = ?', [$filename, $curr_date, $id]);

        //Show Icon/Logo from http://127.0.0.1:8000/storage/photos/xxx

        if ($mysql or $mysql == 0) {
            header("Location:$client_side");
            exit();
        } else {
            return response()->json(['response_code'=>'400', 'state'=>'Update Shop Info Failed', 'datetime' => $curr_date]);
        }
    }
}
