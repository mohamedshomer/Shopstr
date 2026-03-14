<?php
require_once "../api_helper.php";

$user = verifyJWT();

$data = getAllData("categories","store_id = ?",[$user['store_id']],false);
json_response("success","OK",$data);
?>
