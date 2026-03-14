<?php

include "db.php";

$invoice_id = $_GET['invoice_id'] ?? 0;

if(!$invoice_id){
 die("Invoice ID required");
}

/* بيانات الفاتورة */

$q = $conn->query("
SELECT i.*, c.name customer_name
FROM invoices i
LEFT JOIN customers c ON i.customer_id = c.id
WHERE i.id=$invoice_id
");

$invoice = $q->fetch_assoc();

if(!$invoice){
 die("Invoice not found");
}

/* منتجات الفاتورة */

$items = $conn->query("
SELECT 
p.name product,
s.name size,
co.name color,
ii.quantity,
ii.price,
(ii.quantity * ii.price) subtotal
FROM invoice_items ii
JOIN product_variants v ON ii.variant_id=v.id
JOIN products p ON v.product_id=p.id
LEFT JOIN sizes s ON v.size_id=s.id
LEFT JOIN colors co ON v.color_id=co.id
WHERE ii.invoice_id=$invoice_id
");

?>
<html>

<head>

<title>Invoice</title>

<style>

body{
font-family:Arial;
}

table{
border-collapse:collapse;
width:100%;
}

table,th,td{
border:1px solid black;
padding:8px;
text-align:center;
}

</style>

</head>

<body>

<h2>Clothing Store</h2>

<h3>Invoice #<?php echo $invoice['id']; ?></h3>

<p>
Customer : <?php echo $invoice['customer_name']; ?><br>
Date : <?php echo $invoice['created_at']; ?><br>
Type : <?php echo $invoice['invoice_type']; ?>
</p>

<table>

<tr>
<th>Product</th>
<th>Size</th>
<th>Color</th>
<th>Qty</th>
<th>Price</th>
<th>Total</th>
</tr>

<?php

while($row = $items->fetch_assoc()){

echo "<tr>";

echo "<td>".$row['product']."</td>";

echo "<td>".$row['size']."</td>";

echo "<td>".$row['color']."</td>";

echo "<td>".$row['quantity']."</td>";

echo "<td>".$row['price']."</td>";

echo "<td>".$row['subtotal']."</td>";

echo "</tr>";

}

?>

</table>

<h3>Total : <?php echo $invoice['total']; ?></h3>

</body>

</html>
