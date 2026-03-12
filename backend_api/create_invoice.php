<?php

header('Content-Type: application/json');
include "db.php";

$customer_id = $_POST['customer_id'] ?? 0;
$office_id   = $_POST['office_id'] ?? 1;

if(!$customer_id){
 echo json_encode([
  "status"=>"error",
  "message"=>"الرجاء إدخال customer_id"
 ]);
 exit;
}

/* جلب نوع العميل */

$q = $conn->query("
SELECT customer_type 
FROM customers 
WHERE id=$customer_id
");

$customer = $q->fetch_assoc();

if(!$customer){
 echo json_encode([
  "status"=>"error",
  "message"=>"العميل غير موجود"
 ]);
 exit;
}

$invoice_type = $customer['customer_type'];

/* إنشاء الفاتورة */

$stmt = $conn->prepare("
INSERT INTO invoices
(office_id,customer_id,invoice_type,total,discount)
VALUES (?,?,?,?,?)
");

$total = 0;
$discount = 0;

$stmt->bind_param(
"iisdd",
$office_id,
$customer_id,
$invoice_type,
$total,
$discount
);

$stmt->execute();

$invoice_id = $stmt->insert_id;

echo json_encode([
 "status"=>"success",
 "invoice_id"=>$invoice_id,
 "invoice_type"=>$invoice_type
]);

?>
