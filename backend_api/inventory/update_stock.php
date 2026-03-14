<?php
require_once "../api_helper.php";

$user = verifyJWT();

$variant_id = $_POST['variant_id'] ?? null;
$quantity   = $_POST['quantity'] ?? null;

if(!$variant_id || !isset($quantity)) json_response("error","البيانات ناقصة");

updateData("inventory",["quantity"=>$quantity],"product_variant_id = ? AND store_id = ".$user['store_id']);

json_response("success","تم تحديث المخزون");
?>
