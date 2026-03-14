<?php

require_once "../api_helper.php";

$store_name = $_POST['store_name'] ?? null;
$slug = $_POST['slug'] ?? null;
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

if(!$store_name || !$slug){
    json_response("error","الرجاء إدخال اسم المتجر والslug");
    exit;
}

$store = getOne("stores","slug = ?",[$slug],false);

if($store){
    json_response("error","slug موجود مسبقا");
    exit;
}

insertData("stores",[
    "store_name"=>$store_name,
    "slug"=>$slug,
    "email"=>$email,
    "password"=>$password ? password_hash($password,PASSWORD_DEFAULT) : null
]);

json_response("success","تم إنشاء المتجر");

?>
