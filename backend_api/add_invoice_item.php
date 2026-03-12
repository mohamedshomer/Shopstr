<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

header('Content-Type: application/json');
include "db.php";

$invoice_id = $_POST['invoice_id'] ?? 0;
$variant_id = $_POST['variant_id'] ?? 0;
$quantity   = $_POST['quantity'] ?? 1;

if(!$invoice_id || !$variant_id){
    echo json_encode(["status"=>"error","message"=>"بيانات غير مكتملة"]);
    exit;
}

/* التحقق من وجود الفاتورة */
$q = $conn->query("SELECT invoice_type FROM invoices WHERE id=$invoice_id");
$row = $q->fetch_assoc();
if(!$row){
    echo json_encode(["status"=>"error","message"=>"الفاتورة غير موجودة"]);
    exit;
}
$type = $row['invoice_type'];

/* جلب السعر من product_variants */
$p = $conn->query("SELECT retail_price, wholesale_price FROM product_variants WHERE id=$variant_id");
$product = $p->fetch_assoc();
if(!$product){
    echo json_encode(["status"=>"error","message"=>"الموديل غير موجود"]);
    exit;
}

/* اختيار السعر حسب نوع الفاتورة */
$price = ($type == "wholesale") ? $product['wholesale_price'] : $product['retail_price'];

/* حساب الإجمالي */
$total = $price * $quantity;

/* إضافة المنتج للفاتورة */
$stmt = $conn->prepare("INSERT INTO invoice_items (invoice_id, variant_id, quantity, price) VALUES (?,?,?,?)");
$stmt->bind_param("iiid",$invoice_id,$variant_id,$quantity,$price);
$stmt->execute();

/* خصم المخزون */
$conn->query("UPDATE inventory SET quantity = quantity - $quantity WHERE variant_id = $variant_id");

/* تحديث إجمالي الفاتورة */
$conn->query("UPDATE invoices SET total = total + $total WHERE id = $invoice_id");

echo json_encode(["status"=>"success","message"=>"تم إضافة المنتج للفاتورة"]);

$stmt->close();
$conn->close();
?>
