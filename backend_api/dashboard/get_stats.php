<?php

require_once "../api_helper.php";

$user = verifyJWT();

$store_id = $user['store_id'];

$products = getCount("products", "store_id = ?", [$store_id]);
$categories = getCount("categories", "store_id = ?", [$store_id]);
$customers = getCount("customers", "store_id = ?", [$store_id]);

$data = [
    "products" => $products,
    "categories" => $categories,
    "customers" => $customers
];

json_response("success","OK",$data);

?>
