<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "Test1";

$conn = new mysqli($host, $username, $password, $database);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
