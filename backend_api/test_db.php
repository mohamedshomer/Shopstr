<?php
$host = "127.0.0.1";
$user = "root";
$password = "";
$db = "clothing_system";

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}
echo "تم الاتصال بقاعدة البيانات بنجاح!";
?>
