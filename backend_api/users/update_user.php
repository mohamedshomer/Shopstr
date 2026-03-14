<?php
require_once "../api_helper.php";

$user = verifyJWT();

$id       = $_POST['id'] ?? null;
$name     = $_POST['name'] ?? null;
$email    = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

if(!$id || !$name) json_response("error","البيانات ناقصة");

$data = ["name"=>$name,"email"=>$email];
if($password) $data['password'] = password_hash($password,PASSWORD_DEFAULT);

updateData("users",$data,"id = ? AND store_id = ".$user['store_id']);

json_response("success","تم التحديث");
?>
