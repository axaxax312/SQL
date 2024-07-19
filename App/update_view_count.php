<?php
// Tạo một file log mới
$logFile = 'D:\New folder\htdocs\news_platform\error_log.txt';

// Ghi thông tin debug vào file log mới
file_put_contents($logFile, 'Received POST data: ' . print_r($_POST, true) . PHP_EOL, FILE_APPEND);
file_put_contents($logFile, 'Test log message' . PHP_EOL, FILE_APPEND);

// Tiếp tục xử lý như bình thường
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "news_platform";

// Create connection
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get articleId from POST data
$articleId = $_POST['articleId'];

// Prepare and execute SQL statement
$sql = "UPDATE articles SET ViewCount = ViewCount + 1 WHERE ArticleID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $articleId);

$response = array();

if ($stmt->execute()) {
    $response = array('success' => true, 'message' => 'View count updated');
} else {
    $response = array('success' => false, 'message' => 'Failed to update view count');
}

$stmt->close();
$conn->close();

// Ghi response vào file log
file_put_contents($logFile, 'Response: ' . json_encode($response) . PHP_EOL, FILE_APPEND);

// Trả về response cho client
echo json_encode($response);
?>