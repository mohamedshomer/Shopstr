<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

include "db.php";

$sql = "
SELECT
products.id,
products.name AS product_name,
categories.name AS category,
sizes.name AS size,
colors.name AS color,
product_variants.retail_price AS price,
inventory.quantity AS stock

FROM product_variants

LEFT JOIN products
ON products.id = product_variants.product_id

LEFT JOIN categories
ON categories.id = products.category_id

LEFT JOIN sizes
ON sizes.id = product_variants.size_id

LEFT JOIN colors
ON colors.id = product_variants.color_id

LEFT JOIN inventory
ON inventory.variant_id = product_variants.id
";

$result = $conn->query($sql);

$products = [];

while($row = $result->fetch_assoc()){
    $products[] = $row;
}

echo json_encode([
"status"=>"success",
"products"=>$products
]);

?>
