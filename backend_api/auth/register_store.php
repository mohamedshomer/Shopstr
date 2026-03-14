<?php
require_once "../api_helper.php";

// بيانات المتجر
$store_name = $_POST['store_name'] ?? null;
$slug       = $_POST['slug'] ?? null;
$email      = $_POST['email'] ?? null;
$password   = $_POST['password'] ?? null;

if (!$store_name || !$slug) {
    json_response("error","الرجاء إدخال اسم المتجر و slug");
}

// تحقق من وجود slug مسبقًا
$existing = getOne("stores", "slug = ?", [$slug], false);
if ($existing) json_response("error","هذا slug موجود مسبقًا");

// إدراج المتجر
insertData("stores",[
    "store_name"=>$store_name,
    "slug"=>$slug,
    "email"=>$email,
    "password"=>password_hash($password,PASSWORD_DEFAULT),
    "created_at"=>date("Y-m-d H:i:s")
]);

json_response("success","تم إنشاء المتجر");
?>
