<?php
require_once "../api_helper.php";

$user = verifyJWT();

$from = $_GET['from'] ?? null;
$to   = $_GET['to'] ?? null;

$where = "store_id = ".$user['store_id'];
$values = [];

if($from && $to){
    $where .= " AND created_at BETWEEN ? AND ?";
    $values = [$from,$to];
}

$data = getAllData("invoices",$where,$values,false);
json_response("success","OK",$data);
?>
