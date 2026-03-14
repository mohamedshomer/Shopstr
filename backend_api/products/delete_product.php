<?php
require_once "../api_helper.php";

$user = verifyJWT();

$id = $_POST['id'] ?? null;
if(!$id) json_response("error","ID مطلوب");

deleteData("products","id = ? AND store_id = ".$user['store_id']);
json_response("success","تم الحذف");
?>
