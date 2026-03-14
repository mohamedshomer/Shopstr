<?php
require_once "../api_helper.php";

$user = verifyJWT();

$id   = $_POST['id'] ?? null;
$name = $_POST['name'] ?? null;

if(!$id || !$name) json_response("error","البيانات ناقصة");

updateData("categories",["name"=>$name],"id = ? AND store_id = ".$user['store_id']);
json_response("success","تم التحديث");
?>
