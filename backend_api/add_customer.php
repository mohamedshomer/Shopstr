<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

include "db.php";

$name = $_POST['name'] ?? '';
$phone = $_POST['phone'] ?? '';
$address = $_POST['address'] ?? '';
$customer_type = $_POST['customer_type'] ?? 'retail';

if(!$name){
 echo json_encode([
  "status"=>"error",
  "message"=>"الرجاء إدخال اسم العميل"
 ]);
 exit;
}

$stmt = $conn->prepare("
INSERT INTO customers
(name, phone, address, customer_type)
VALUES (?, ?, ?, ?)
");

$stmt->bind_param("ssss", $name, $phone, $address, $customer_type);

if($stmt->execute()){

 echo json_encode([
  "status"=>"success",
  "message"=>"تم إضافة العميل بنجاح"
 ]);

}else{

 echo json_encode([
  "status"=>"error",
  "message"=>"فشل إضافة العميل"
 ]);

}

$stmt->close();
$conn->close();

?>
