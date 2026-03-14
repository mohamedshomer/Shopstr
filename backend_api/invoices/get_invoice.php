<?php
require_once "../api_helper.php";

$user = verifyJWT();

$id = $_GET['id'] ?? null;
if(!$id) json_response("error","ID مطلوب");

$invoice = getOne("invoices","id = ? AND store_id = ?",[$id,$user['store_id']],false);
$items   = getAllData("invoice_items","invoice_id = ?",[$id],false);

json_response("success","OK",["invoice"=>$invoice,"items"=>$items]);
?>
