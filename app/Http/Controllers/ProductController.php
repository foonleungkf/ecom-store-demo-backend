<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Storage;

class ProductController extends Controller
{
    public function insert_product_type(){

    	$curr_date = date('Y-m-d H:i:s');

    	//get payload request from client side
        $data = json_decode(file_get_contents("php://input"), true);

    	if (!isset($data['type_name'])) {
    		return response()->json(['response_code'=>'400', 'state' => 'Missing Params : {type_name}. Insert Failed.', 'datetime' => $curr_date]);
    	} 

        // $id = $data['id'];
        $id = time();
        $type_name = $data['type_name'];
        $type_desc = $data['type_desc'];
        $active = $data['active'];
    	
    	$mysql = DB::insert("INSERT INTO ecom_product_type(id, type_name, type_desc, active, created_date, updated_date) VALUES (?, ?, ?, ?, ?, ?)", [$id, $type_name, $type_desc, $active, $curr_date, $curr_date]);

    	if ($mysql) {
    		return response()->json(['response_code'=>'200', 'state' => 'Insert Product Type Succ', 'datetime' => $curr_date]);
    	} else {
    		return response()->json(['response_code'=>'400', 'state' => 'Insert Failed', 'datetime' => $curr_date]);
    	}
    }

    public function update_product_type(Request $request){

    	$curr_date = date('Y-m-d H:i:s');

        //get payload request from client side
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data["id"]) or !isset($data["type_name"])){
            return response()->json(['response_code'=>'400', 'state' => 'Missing Params : {id | name}. Updated Failed.', 'datetime' => $curr_date]);
        }   

        $id = $data["id"];
        $type_name = $data['type_name'];
        $type_desc = $data['type_desc'];
        $active = $data['active'];


    	$mysql = DB::update("UPDATE ecom_product_type SET type_name = ? , type_desc = ?, active = ?, updated_date = ? WHERE id = ?", [$type_name, $type_desc, $active, $curr_date, $id]);

    	if ($mysql or $mysql == 0) {
    		return response()->json(['response_code'=>'200', 'state'=>'Update Product type Info Succ', 'datetime' => $curr_date]);
    	} else {
    		return response()->json(['response_code'=>'400', 'state'=>'Update Product type Info Failed', 'datetime' => $curr_date]);
    	}
    }

    public function get_product_type_list(){
    	$curr_date = date('Y-m-d H:i:s');

    	$mysql = DB::select('SELECT * FROM ecom_product_type');

    	if ($mysql) {
    		return response()->json(['response_code'=>'200', 'state'=>'Get Product Type List Succ', 'data' =>
				$mysql, 'datetime' => $curr_date]);
    	} else {
    		return response()->json(['response_code'=>'400', 'state'=>'Get Product Type List Failed', 'data' => 
    			"", 'datetime' => $curr_date]);
    	}
    }

    public function get_product_type_by_id(){
    	$id = $_GET['id'];
    	$curr_date = date('Y-m-d H:i:s');

    	$mysql = DB::select('SELECT * FROM ecom_product_type WHERE id = ?', [$id]);

    	if ($mysql) {
    		return response()->json(['response_code'=>'200', 'state'=>'Get Product Type Succ', 'data' => $mysql, 'datetime' => $curr_date]);
    	} else {
    		return response()->json(['response_code'=>'400', 'state'=>'Get Product Type Failed', 'data' => "", 'datetime' => $curr_date]);
    	}
    }

    public function delete_product_type_by_id() {
    	$data = json_decode(file_get_contents("php://input"), true);

    	$id = $data['id'];
    	$curr_date = date('Y-m-d H:i:s');

        if (!isset($data['id'])) {
    		return response()->json(['response_code'=>'400', 'state' => 'Missing Params : {id}. Insert Failed.', 'datetime' => $curr_date]);
    	} 

    	$mysql = DB::delete("DELETE FROM ecom_product_type WHERE id = ?" ,[$id]);

	    if ($mysql) {
	    	return response()->json(['response_code'=>'200', 'state'=>'Delete Product Type Succ', 'data' => $mysql, 'datetime' => $curr_date]);
	   	} else {
	    	return response()->json(['response_code'=>'400', 'state'=>'Delete Product Type Failed', 'data' => "", 'datetime' => $curr_date]);
	    }
    }

    public function insert_product(){

    	$curr_date = date('Y-m-d H:i:s');

        $data = json_decode(file_get_contents("php://input"), true);

    	if (!isset($data['name']) or !isset($data['price'])) {
    		return response()->json(['response_code'=>'400', 'state' => 'Missing Params : {name | price}. Insert Failed.', 'datetime' => $curr_date]);
    	} 

        $id = time();
        $name = $data['name'];
        $price = $data['price'];
        $qty = $data['qty'];
        $weight = $data['weight'];
        $product_desc = $data['product_desc'];
        $product_standard = $data['product_standard'];
        $product_type = $data['product_type'];
        $active = $data['active'];
    	
    	$mysql = DB::insert("INSERT INTO ecom_product_item(id, name, price, qty, weight, product_desc, product_standard, product_type, active, created_date, updated_date) VALUES (?,?,?,?,?,?,?,?,?,?,?)", [$id, $name, $price, $qty, $weight, $product_desc, $product_standard, $product_type, $active, $curr_date, $curr_date]);

    	if ($mysql) {
    		return response()->json(['response_code'=>'200', 'state' => 'Insert Product Succ', 'datetime' => $curr_date]);
    	} else {
    		return response()->json(['response_code'=>'400', 'state' => 'Insert Failed', 'datetime' => $curr_date]);
    	}
    }

    public function update_product(Request $request){

    	$curr_date = date('Y-m-d H:i:s');

        //get payload request from client side
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data["id"]) or !isset($data["name"]) or !isset($data['price'])){
            return response()->json(['response_code'=>'400', 'state' => 'Missing Params : {id | name | price}. Updated Failed.', 'datetime' => $curr_date]);
        }   

        $id = $data["id"];
        $name = $data['name'];
        $price = $data['price'];
        $qty = $data['qty'];
        $weight = $data['weight'];
        $product_desc = $data['product_desc'];
        $product_standard = $data['product_standard'];
        $product_type = $data['product_type'];
        $active = $data['active'];

    	$mysql = DB::update("UPDATE ecom_product_item SET name = ? , price = ?, qty = ?, weight = ?, product_desc = ?, product_standard = ?, product_type = ?, active = ? WHERE id = ?", [$name, $price, $qty, $weight, $product_desc, $product_standard, $product_type, $active, $id]);

    	if ($mysql or $mysql == 0) {
    		return response()->json(['response_code'=>'200', 'state'=>'Update Product Info Succ', 'datetime' => $curr_date]);
    	} else {
    		return response()->json(['response_code'=>'400', 'state'=>'Update Product Info Failed', 'datetime' => $curr_date]);
    	}
    }

    public function get_product_by_type(){
    	$curr_date = date('Y-m-d H:i:s');
    	$product_type = $_GET['product_type'];

    	$mysql = DB::select('SELECT * FROM ecom_product_item WHERE product_type = ?', [$product_type]);

    	if ($mysql) {
    		return response()->json(['response_code'=>'200', 'state'=>'Get Product Succ', 'data' =>
				$mysql, 'datetime' => $curr_date]);
    	} else {
    		return response()->json(['response_code'=>'400', 'state'=>'Get Product Failed', 'data' => 
    			"", 'datetime' => $curr_date]);
    	}
    }

    public function get_product_by_id(){
    	$curr_date = date('Y-m-d H:i:s');
    	$id = $_GET['id'];

    	$mysql = DB::select('SELECT * FROM ecom_product_item WHERE id = ?', [$id]);

    	if ($mysql) {
    		return response()->json(['response_code'=>'200', 'state'=>'Get Product Succ', 'data' =>
				$mysql, 'datetime' => $curr_date]);
    	} else {
    		return response()->json(['response_code'=>'400', 'state'=>'Get Product Failed', 'data' => 
    			"", 'datetime' => $curr_date]);
    	}
    }

    public function get_product_count(){
        $curr_date = date('Y-m-d H:i:s');

        $mysql = DB::select('SELECT COUNT(*) as product_count FROM ecom_product_item');

        if ($mysql) {
            return response()->json(['response_code'=>'200', 'state'=>'Get Product Succ', 'data' =>
                $mysql, 'datetime' => $curr_date]);
        } else {
            return response()->json(['response_code'=>'400', 'state'=>'Get Product Failed', 'data' => 
                "", 'datetime' => $curr_date]);
        }
    }

    public function get_product_type_count(){
        $curr_date = date('Y-m-d H:i:s');

        $mysql = DB::select('SELECT COUNT(*) as product_type_count FROM ecom_product_type');

        if ($mysql) {
            return response()->json(['response_code'=>'200', 'state'=>'Get Product Succ', 'data' =>
                $mysql, 'datetime' => $curr_date]);
        } else {
            return response()->json(['response_code'=>'400', 'state'=>'Get Product Failed', 'data' => 
                "", 'datetime' => $curr_date]);
        }
    }

    public function delete_product_by_id_arary() {
        //get payload request from client side
        $data = json_decode(file_get_contents("php://input"), true);
    	
        $id = $data['id'];
    	$curr_date = date('Y-m-d H:i:s');

    	if (!isset($data['id'])) {
    		return response()->json(['response_code'=>'400', 'state' => 'Missing Params : {id}. Insert Failed.', 'datetime' => $curr_date]);
    	} 

    	$id_array = explode(',', $id);
    	$id_sql_string = "";

    	foreach ($id_array as $id) {
		    $id_sql_string = $id_sql_string . "id = " . $id . " OR ";
		}

		$sql = "DELETE FROM ecom_product_item WHERE " . $id_sql_string . " id = 0"; 

        $mysql = DB::delete($sql);

        
	    if ($mysql or $mysql == 0) {
	    	return response()->json(['response_code'=>'200', 'state'=>'Delete Product Type Succ', 'data' => $mysql, 'datetime' => $curr_date]);
	   	} else {
	    	return response()->json(['response_code'=>'400', 'state'=>'Delete Product Type Failed', 'data' => "", 'datetime' => $curr_date]);
	    }
    }

    public function upload_product_cover_image(Request $request){
        $curr_date = date('Y-m-d H:i:s');
        $client_side = "http://192.168.0.105:4200/modify-product-part?action=edit&id=" . $_POST['id'];


        if (!isset($_POST['id']) or $_FILES['cover_image']['error'] > 0) {
            return response()->json(['response_code'=>'400', 'state' => 'Missing Params : {id | cover_image}. Updated Failed.', 'datetime' => $curr_date]);
        }

        $file = $request->file('cover_image'); 

        // generate a new filename. getClientOriginalExtension() for the file extension
        $filename = 'product-photo-' . time() . '.' . $file->getClientOriginalExtension();

        // save to storage/app/photos as the new $filename
        $path = $file->storeAs('photos', $filename);

        $id = $_POST['id'];

        $mysql = DB::update('UPDATE ecom_product_item SET cover_image = ?, updated_date = ? WHERE id = ?', [$filename, $curr_date, $id]);

        //Show Icon/Logo from http://127.0.0.1:8000/storage/photos/xxx

        if ($mysql or $mysql == 0) {
            header("Location:$client_side");
            exit();
        } else {
            return response()->json(['response_code'=>'400', 'state'=>'Update Shop Info Failed', 'datetime' => $curr_date]);
        }
    }

    public function get_top_5_orders_product(){
        $curr_date = date('Y-m-d H:i:s');

        $mysql = DB::select('SELECT product_id, name as label, SUM(amount) as value FROM ecom_order_item LEFT JOIN ecom_product_item ON ecom_order_item.product_id = ecom_product_item.id GROUP BY product_id ORDER BY value DESC LIMIT 5');

        if ($mysql) {
            return response()->json(['response_code'=>'200', 'state'=>'Get Top 5 Products Item Succ', 'data' =>
                $mysql, 'datetime' => $curr_date]);
        } else {
            return response()->json(['response_code'=>'400', 'state'=>'Get Top 5 Products Item Failed', 'data' => 
                "", 'datetime' => $curr_date]);
        }
    }

    public function update_photo_albums(Request $request){
        $curr_date = date('Y-m-d H:i:s');
        $client_side = "http://192.168.0.105:4200/modify-product-part?action=edit&id=" . $_POST['id'];

        $id = $_POST['id'];
        $album_no = $_POST['album_no'];

        $sql = "";

        if($album_no == "1") {
            $file = $request->file('product_image_1'); 
            // generate a new filename. getClientOriginalExtension() for the file extension
            $filename = 'product-photo-' . time() . '.' . $file->getClientOriginalExtension();
            // save to storage/app/photos as the new $filename
            $path = $file->storeAs('photos', $filename);
            $sql = "UPDATE ecom_product_item SET product_image_1 = '$filename', updated_date = '$curr_date' WHERE id = $id";
            $mysql = DB::update($sql);

            if ($mysql or $mysql == 0) {
                header("Location:$client_side");
                exit();
            } else {
                return response()->json(['response_code'=>'400', 'state'=>'Update Product Failed', 'datetime' => $curr_date]);
            }
        }

        if($album_no == "2") {
            $file = $request->file('product_image_2'); 
            // generate a new filename. getClientOriginalExtension() for the file extension
            $filename = 'product-photo-' . time() . '.' . $file->getClientOriginalExtension();
            // save to storage/app/photos as the new $filename
            $path = $file->storeAs('photos', $filename);
            $sql = "UPDATE ecom_product_item SET product_image_2 = '$filename', updated_date = '$curr_date' WHERE id = $id";
            $mysql = DB::update($sql);

            if ($mysql or $mysql == 0) {
                header("Location:$client_side");
                exit();
            } else {
                return response()->json(['response_code'=>'400', 'state'=>'Update Product Failed', 'datetime' => $curr_date]);
            }
        }

        if($album_no == "3") {
            $file = $request->file('product_image_3'); 
            // generate a new filename. getClientOriginalExtension() for the file extension
            $filename = 'product-photo-' . time() . '.' . $file->getClientOriginalExtension();
            // save to storage/app/photos as the new $filename
            $path = $file->storeAs('photos', $filename);
            $sql = "UPDATE ecom_product_item SET product_image_3 = '$filename', updated_date = '$curr_date' WHERE id = $id";
            $mysql = DB::update($sql);

            if ($mysql or $mysql == 0) {
                header("Location:$client_side");
                exit();
            } else {
                return response()->json(['response_code'=>'400', 'state'=>'Update Product Failed', 'datetime' => $curr_date]);
            }
        }
    }
}
