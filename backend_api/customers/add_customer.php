<?php
require_once "../api_helper.php";

$user = verifyJWT();

$name  = $_POST['name'] ?? null;
$email = $_POST['email'] ?? null;
$phone = $_POST['phone'] ?? null;

if(!$name) json_response("error","اسم العميل مطلوب");

insertData("customers",[
    "store_id"=>$user['store_id'],
    "name"=>$name,
    "email"=>$email,
    "phone"=>$phone,
    "created_at"=>date("Y-m-d H:i:s")
]);

json_response("success","تمت إضافة العميل");
?>
