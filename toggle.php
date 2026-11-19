<?php
$host = "sql311.infinityfree.com";
$user = "if0_43478772";
$pass = "YOUR_PASSWORD";
$db   = "if0_43478772_Task";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $conn->query("UPDATE users SET status = 1 - status WHERE id = $id");
    $res = $conn->query("SELECT status FROM users WHERE id = $id");
    if ($row = $res->fetch_assoc()) {
        echo $row['status'];
    }
}
?>
