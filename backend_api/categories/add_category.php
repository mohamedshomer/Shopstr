<?php
require_once "../api_helper.php";

$user = verifyJWT();

$name = $_POST['name'] ?? null;
if(!$name) json_response("error","اسم التصنيف مطلوب");

insertData("categories",[
    "store_id"=>$user['store_id'],
    "name"=>$name,
    "created_at"=>date("Y-m-d H:i:s")
]);

json_response("success","تمت الإضافة");
?>
