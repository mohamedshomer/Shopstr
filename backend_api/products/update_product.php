<?php
require_once "../api_helper.php";

$user = verifyJWT();

$id          = $_POST['id'] ?? null;
$name        = $_POST['name'] ?? null;
$category_id = $_POST['category_id'] ?? null;
$description = $_POST['description'] ?? null;

if(!$id || !$name) json_response("error","البيانات ناقصة");

updateData("products",[
    "name"=>$name,
    "category_id"=>$category_id,
    "description"=>$description
],"id = ? AND store_id = ".$user['store_id']);

json_response("success","تم التحديث");
?>
