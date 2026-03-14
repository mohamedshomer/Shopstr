<?php
require_once "../api_helper.php";

$user = verifyJWT();

$product_id = $_POST['product_id'] ?? null;
$size_id    = $_POST['size_id'] ?? null;
$color_id   = $_POST['color_id'] ?? null;
$price      = $_POST['price'] ?? null;

if(!$product_id || !$size_id || !$color_id) json_response("error","البيانات ناقصة");

insertData("product_variants",[
    "store_id"=>$user['store_id'],
    "product_id"=>$product_id,
    "size_id"=>$size_id,
    "color_id"=>$color_id,
    "price"=>$price,
    "created_at"=>date("Y-m-d H:i:s")
]);

json_response("success","تمت الإضافة");
?>
