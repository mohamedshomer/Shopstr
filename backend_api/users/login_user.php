<?php
require_once "../api_helper.php";

$email    = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

if(!$email || !$password) json_response("error","البيانات ناقصة");

$user = getOne("users","email = ?",[$email],false);
if(!$user) json_response("error","المستخدم غير موجود");

if(!password_verify($password,$user['password'])) json_response("error","كلمة المرور خاطئة");

$token = createJWT(["store_id"=>$user['store_id'],"user_id"=>$user['id'],"email"=>$user['email']]);
json_response("success","تم تسجيل الدخول",["token"=>$token]);
?>
