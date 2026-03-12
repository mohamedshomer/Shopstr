<?php
header('Content-Type: application/json');
include "db.php";

$invoice_id = $_GET['invoice_id'] ?? 0;

if(!$invoice_id){
    echo json_encode(["status"=>"error","message"=>"الرجاء إدخال invoice_id"]);
    exit;
}

/* جلب بيانات الفاتورة */
$invoice_q = $conn->query("
SELECT i.id, i.customer_id, i.invoice_type, i.total, i.discount, i.created_at,
       c.name AS customer_name
FROM invoices i
LEFT JOIN customers c ON i.customer_id = c.id
WHERE i.id = $invoice_id
");
$invoice = $invoice_q->fetch_assoc();

if(!$invoice){
    echo json_encode(["status"=>"error","message"=>"الفاتورة غير موجودة"]);
    exit;
}

/* جلب المنتجات المرتبطة بالفاتورة */
$items_q = $conn->query("
SELECT iv.id AS variant_id, p.name AS product_name, s.name AS size, co.name AS color,
       ii.quantity, 
       CASE WHEN i.invoice_type='wholesale' THEN iv.wholesale_price
            ELSE iv.retail_price
       END AS price,
       (ii.quantity * CASE WHEN i.invoice_type='wholesale' THEN iv.wholesale_price
                           ELSE iv.retail_price END) AS subtotal
FROM invoice_items ii
INNER JOIN product_variants iv ON ii.variant_id = iv.id
INNER JOIN products p ON iv.product_id = p.id
LEFT JOIN sizes s ON iv.size_id = s.id
LEFT JOIN colors co ON iv.color_id = co.id
INNER JOIN invoices i ON ii.invoice_id = i.id
WHERE ii.invoice_id = $invoice_id
");

$items = [];
while($row = $items_q->fetch_assoc()){
    $items[] = $row;
}

echo json_encode([
    "status"=>"success",
    "invoice" => $invoice,
    "items" => $items
]);

$conn->close();
?>
