<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Thay đổi các thông số kết nối dưới đây
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "news_platform";
// Tạo kết nối
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

// Đặt mã hóa ký tự UTF-8 cho kết nối
$conn->set_charset("utf8");

// Hàm lấy danh sách thông báo
function getNotifications($conn) {
    $query = "SELECT * FROM notifications ORDER BY created_at DESC";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $notifications = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $notifications[] = $row;
        }
        http_response_code(200);
        echo json_encode($notifications);
    } else {
        http_response_code(404);
        echo json_encode(["message" => "No notifications found."]);
    }
}

// Xử lý phương thức GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    getNotifications($conn);
} else {
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed."]);
}

// Đóng kết nối
$conn->close();
?>