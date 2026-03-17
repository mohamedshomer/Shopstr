<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../api_helper.php";

$user = verifyJWT();
<<<<<<< HEAD

$data = getAllData("products","store_id = ?",[$user['store_id']],false);
=======

$data = getAllData("products","store_id = ?",[$user['store_id']],false);

>>>>>>> f916495 (Update get_products.php)
json_response("success","OK",$data);
?>
