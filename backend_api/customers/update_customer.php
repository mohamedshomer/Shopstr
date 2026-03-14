<?php
require_once "../api_helper.php";

$user = verifyJWT();

$id    = $_POST['id'] ?? null;
$name  = $_POST['name'] ?? null;
$email = $_POST['email'] ?? null;
$phone = $_POST['phone'] ?? null;

if(!$id || !$name) json_response("error","البيانات ناقصة");

updateData("customers",[
    "name"=>$name,
    "email"=>$email,
    "phone"=>$phone
],"id = ? AND store_id = ".$user['store_id']);

json_response("success","تم التحديث");
?>
