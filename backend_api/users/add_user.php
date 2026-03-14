<?php
require_once "../api_helper.php";

$user = verifyJWT();

$name     = $_POST['name'] ?? null;
$email    = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

if(!$name || !$email || !$password) json_response("error","البيانات ناقصة");

insertData("users",[
    "store_id"=>$user['store_id'],
    "name"=>$name,
    "email"=>$email,
    "password"=>password_hash($password,PASSWORD_DEFAULT),
    "created_at"=>date("Y-m-d H:i:s")
]);

json_response("success","تمت إضافة المستخدم");
?>
