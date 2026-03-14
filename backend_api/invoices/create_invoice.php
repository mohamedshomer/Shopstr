<?php
require_once "../api_helper.php";

$user = verifyJWT();

$customer_id = $_POST['customer_id'] ?? null;
$items       = $_POST['items'] ?? null; // array of [variant_id, quantity, price]

if(!$customer_id || !$items) json_response("error","البيانات ناقصة");

// إنشاء الفاتورة
$invoice_id = insertRow("invoices",[
    "store_id"=>$user['store_id'],
    "customer_id"=>$customer_id,
    "created_at"=>date("Y-m-d H:i:s")
],false);

// إضافة العناصر
foreach($items as $item){
    insertData("invoice_items",[
        "invoice_id"=>$invoice_id,
        "product_variant_id"=>$item['variant_id'],
        "quantity"=>$item['quantity'],
        "price"=>$item['price']
    ],false);
}

json_response("success","تم إنشاء الفاتورة");
?>
