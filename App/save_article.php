<?php
// Kết nối tới database
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "news_platform";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kiểm tra nếu có đủ dữ liệu cần thiết
if (isset($_POST['user_id']) && isset($_POST['article_id'])) {
    $userId = $_POST['user_id'];
    $articleId = $_POST['article_id'];

    // Chuẩn bị câu lệnh SQL để lưu vào lịch sử đọc
    $sql = "INSERT INTO readinghistory (UserID, ArticleID) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $userId, $articleId);

    // Khởi tạo mảng response
    $response = array();

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "Article saved successfully";
    } else {
        $response['success'] = false;
        $response['message'] = "Failed to save article: " . $stmt->error;
    }

    $stmt->close();
} else {
    $response['success'] = false;
    $response['message'] = "Invalid input";
}

// Đóng kết nối cơ sở dữ liệu
$conn->close();

// Trả về kết quả dưới dạng JSON
echo json_encode($response);
?>