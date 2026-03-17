<?php
require_once "../api_helper.php";

$slug     = $_POST['slug'] ?? null;
$password = $_POST['password'] ?? null;

if(!$slug || !$password) json_response("error","الرجاء إدخال البيانات");

$store = getOne("stores","slug = ?",[$slug],false);
if(!$store) json_response("error","المتجر غير موجود");

if(!password_verify($password,$store['password'])) json_response("error","كلمة المرور خاطئة");

// إنشاء JWT
$token = generateJWT(["store_id"=>$store['id'],"slug"=>$store['slug']]);
json_response("success","تم تسجيل الدخول",["token"=>$token]);
?>
