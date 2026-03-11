<?php
header('Content-Type: application/json');

$conn = new mysqli("127.0.0.1","root","","clothing_system");

if($conn->connect_error){
    die(json_encode(["status"=>"error","message"=>"DB Error"]));
}

$sql = "
SELECT 
products.name AS product,
sizes.name AS size,
colors.name AS color,
product_variants.retail_price AS price,
inventory.quantity AS stock
FROM product_variants
LEFT JOIN products ON products.id = product_variants.product_id
LEFT JOIN sizes ON sizes.id = product_variants.size_id
LEFT JOIN colors ON colors.id = product_variants.color_id
LEFT JOIN inventory ON inventory.variant_id = product_variants.id
";

$result = $conn->query($sql);

$data = [];

while($row = $result->fetch_assoc()){
    $data[] = $row;
}

echo json_encode([
"status"=>"success",
"products"=>$data
]);
