<?php

header('Content-Type: application/json');

include "db.php";

$q = $conn->query("

SELECT

v.id variant_id,
p.name product,
s.name size,
c.name color,
v.retail_price,
v.wholesale_price,
i.quantity

FROM product_variants v

JOIN products p ON v.product_id=p.id

LEFT JOIN sizes s ON v.size_id=s.id
LEFT JOIN colors c ON v.color_id=c.id

LEFT JOIN inventory i ON v.id=i.variant_id

");

$products = [];

while($row = $q->fetch_assoc()){

$products[] = $row;

}

echo json_encode([
"status"=>"success",
"products"=>$products
]);

?>
