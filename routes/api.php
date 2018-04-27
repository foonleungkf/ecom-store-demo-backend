<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Shop Setting API
Route::post('/cms/shop/insert_shop', 'ShopSettingController@insert');
Route::post('/cms/shop/update_shop', 'ShopSettingController@update');
Route::get('/cms/shop/get_shop', 'ShopSettingController@get');
Route::post('/cms/shop/upload_logo', 'ShopSettingController@uploadShopLogo');
Route::get('/cms/shop/get_logo', 'ShopSettingController@getShopLogo');

//Product Type API
Route::post('/cms/product/insert_product_type', 'ProductController@insert_product_type');
Route::post('/cms/product/update_product_type', 'ProductController@update_product_type');
Route::get('/cms/product/get_product_type_list', 'ProductController@get_product_type_list');
Route::get('/cms/product/get_product_type_by_id', 'ProductController@get_product_type_by_id');
Route::post('/cms/product/delete_product_type_by_id', 'ProductController@delete_product_type_by_id');
Route::get('/cms/product/get_product_type_count', 'ProductController@get_product_type_count');

//Product API
Route::post('/cms/product/insert_product', 'ProductController@insert_product');
Route::post('/cms/product/update_product', 'ProductController@update_product');
Route::get('/cms/product/get_product_by_type', 'ProductController@get_product_by_type');
Route::get('/cms/product/get_product_by_id', 'ProductController@get_product_by_id');
Route::post('/cms/product/delete_product_by_id_arary', 'ProductController@delete_product_by_id_arary');
Route::post('/cms/product/upload_product_cover', 'ProductController@upload_product_cover_image');
Route::post('/cms/product/upload_product_albums', 'ProductController@update_photo_albums');
Route::get('/cms/product/get_product_count', 'ProductController@get_product_count');
Route::get('/cms/product/get_top_5_orders_product', 'ProductController@get_top_5_orders_product');

//Order API
Route::post('/cms/order/insert_order', 'OrderController@insert_order');
Route::post('/cms/order/insert_order_item', 'OrderController@insert_order_item');
Route::post('/cms/order/delete_order_list_by_id', 'OrderController@delete_order_list_by_id');
Route::get('/cms/order/get_order_list', 'OrderController@get_order_list');
Route::get('/cms/order/get_order_list_by_id', 'OrderController@get_order_list_by_id');
Route::get('/cms/order/get_order_item_by_id', 'OrderController@get_order_item_by_id');
Route::post('/cms/order/update_order_status', 'OrderController@update_order_status');
Route::post('/cms/order/update_payment_status', 'OrderController@update_payment_status');
Route::post('/cms/order/update_delivery_status', 'OrderController@update_delivery_status');
Route::get('/cms/order/get_order_count', 'OrderController@get_order_count');


//Member API
Route::post('/cms/member/insert_member', 'MemberController@insert_member');
Route::get('/cms/member/get_cus_member_by_id', 'MemberController@get_cus_member_by_id');
Route::get('/cms/member/get_cus_member_list', 'MemberController@get_cus_member_list');
Route::post('/cms/member/update_member', 'MemberController@update_member');
Route::post('/cms/member/delete_member_by_id', 'MemberController@delete_member_by_id');
Route::get('/cms/member/get_cus_member_count', 'MemberController@get_cus_member_count');

//Payment API
Route::post('/cms/payment/insert_payment', 'PaymentController@insert_payment');
Route::get('/cms/payment/get_payment_list', 'PaymentController@get_payment_list');



