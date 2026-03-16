<?php
// ==========================================================
// Shopstr API Helper
// يحتوي على جميع دوال CRUD + Auth + Upload + Notifications
// ==========================================================

header('Content-Type: application/json');
date_default_timezone_set("Asia/Damascus");

// ------------------------
// قاعدة البيانات PDO
require_once "db.php";  // يجب أن يحتوي على $con = new PDO(...);

// JWT
require_once "auth/jwt_helper.php";

// ------------------------
// JSON Response Helper
function json_response($status, $message = "", $data = null) {
    $response = ["status" => $status, "message" => $message];
    if ($data !== null) $response["data"] = $data;
    echo json_encode($response);
}

// ------------------------
// JWT Authentication
function require_auth() {
    $headers = getallheaders();
    $token = $headers['Authorization'] ?? null;
    if (!$token) {
        json_response("error","Unauthorized: no token provided");
        exit;
    }
    $user_data = validateJWT($token);
    if (!$user_data) {
        json_response("error","Unauthorized: invalid token");
        exit;
    }
    return $user_data;  // object: user_id, role, store_id
}

// ------------------------
// CRUD FUNCTIONS

// GET ALL
function getAllData($table, $where = "", $values = [], $json = true) {
    global $con;
    $sql = "SELECT * FROM $table";
    if ($where != "") $sql .= " WHERE $where";
    $stmt = $con->prepare($sql);
    $stmt->execute($values);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($json) {
        if (count($data) > 0) json_response("success","OK",$data);
        else json_response("failure","لا توجد بيانات");
    } else return $data;
}

// GET SINGLE
function getOne($table, $where, $values = [], $json = true) {
    global $con;
    $stmt = $con->prepare("SELECT * FROM $table WHERE $where");
    $stmt->execute($values);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($json) {
        if ($data) json_response("success","OK",$data);
        else json_response("failure","لا توجد بيانات");
    } else return $data;
}

// INSERT
function insertData($table, $data, $json = true) {
    global $con;
    $fields = implode(",", array_keys($data));
    $placeholders = implode(",", array_map(fn($k)=>":$k", array_keys($data)));
    $stmt = $con->prepare("INSERT INTO $table ($fields) VALUES ($placeholders)");
    foreach($data as $k=>$v) $stmt->bindValue(":$k",$v);
    if ($stmt->execute()) {
        if ($json) json_response("success","تمت الإضافة", ["id"=>$con->lastInsertId()]);
        return $con->lastInsertId();
    } else {
        if ($json) json_response("error","حدث خطأ أثناء العملية");
        return false;
    }
}

// UPDATE
function updateData($table, $data, $where, $whereValues = [], $json = true) {
    global $con;
    $set = implode(", ", array_map(fn($k)=>"`$k`=:$k", array_keys($data)));
    $stmt = $con->prepare("UPDATE $table SET $set WHERE $where");
    foreach($data as $k=>$v) $stmt->bindValue(":$k",$v);
    if ($stmt->execute($whereValues)) {
        if ($json) json_response("success","تم التحديث");
        return $stmt->rowCount();
    } else {
        if ($json) json_response("error","حدث خطأ أثناء التحديث");
        return false;
    }
}

// DELETE
function deleteData($table, $where, $whereValues = [], $json = true) {
    global $con;
    $stmt = $con->prepare("DELETE FROM $table WHERE $where");
    if ($stmt->execute($whereValues)) {
        if ($json) json_response("success","تم الحذف");
        return $stmt->rowCount();
    } else {
        if ($json) json_response("error","حدث خطأ أثناء الحذف");
        return false;
    }
}
?>
