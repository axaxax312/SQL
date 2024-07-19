<?php
// Thông tin kết nối đến cơ sở dữ liệu
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "news_platform";

// Tạo kết nối đến cơ sở dữ liệu
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
}
?>