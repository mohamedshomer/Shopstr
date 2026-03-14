
<?php
$host = "127.0.0.1";
$db   = "clothing_system";
$user = "root";
$pass = ""; // ضع كلمة المرور إذا موجودة

try {
    $con = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die(json_encode(["status"=>"error","message"=>$e->getMessage()]));
}
?>
