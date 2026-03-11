<?php
header('Content-Type: application/json');

$host = "127.0.0.1";
$user = "root";
$password = "";
$db = "clothing_system";

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die(json_encode(["status"=>"error","message"=>"فشل الاتصال بقاعدة البيانات"]));
}

$name        = $_POST['name'] ?? '';
$category_id = $_POST['category_id'] ?? 1;
$size_id     = $_POST['size_id'] ?? '';
$color_id    = $_POST['color_id'] ?? '';
$price       = $_POST['price'] ?? 0;
$stock       = $_POST['stock'] ?? 0;

if(!$name || !$size_id || !$color_id){
    echo json_encode(["status"=>"error","message"=>"الرجاء إدخال الاسم والمقاس واللون"]);
    exit;
}

/* إضافة المنتج */
$stmt = $conn->prepare("INSERT INTO products (name, category_id) VALUES (?, ?)");
$stmt->bind_param("si", $name, $category_id);
$stmt->execute();

$product_id = $stmt->insert_id;
$stmt->close();

/* إضافة الموديل */
$stmt2 = $conn->prepare("
INSERT INTO product_variants
(product_id, size_id, color_id, retail_price)
VALUES (?, ?, ?, ?)
");

$stmt2->bind_param("iiid", $product_id, $size_id, $color_id, $price);
$stmt2->execute();

$variant_id = $stmt2->insert_id;
$stmt2->close();

/* إضافة المخزون */

$stmt3 = $conn->prepare("
INSERT INTO inventory
(variant_id, quantity)
VALUES (?, ?)
");

$stmt3->bind_param("ii", $variant_id, $stock);
$stmt3->execute();

$stmt3->close();

$conn->close();

echo json_encode([
"status"=>"success",
"message"=>"تم إضافة المنتج والموديل والمخزون بنجاح"
]);

exit;
