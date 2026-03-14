<?php
require_once "../api_helper.php";

$user = verifyJWT();

$name        = $_POST['name'] ?? null;
$category_id = $_POST['category_id'] ?? null;
$description = $_POST['description'] ?? null;
$image       = $_FILES['image'] ?? null;

if(!$name || !$category_id) json_response("error","البيانات ناقصة");

// رفع الصورة
$image_name = $image ? imageUpload("../uploads/products",$image['name']) : null;

insertData("products",[
    "store_id"=>$user['store_id'],
    "category_id"=>$category_id,
    "name"=>$name,
    "description"=>$description,
    "image"=>$image_name,
    "created_at"=>date("Y-m-d H:i:s")
]);

json_response("success","تمت الإضافة");
?>
