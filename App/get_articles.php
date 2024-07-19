<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json; charset=UTF-8");

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

$searchQuery = "";
if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
}

// Truy vấn dữ liệu từ bảng Articles
$sql = "SELECT ArticleID, Title, Content, Category, PublicationDate, Tags, ImageUrl FROM Articles";
if (!empty($searchQuery)) {
    $searchQuery = $conn->real_escape_string($searchQuery);
    $sql .= " WHERE Title LIKE '%$searchQuery%' OR Content LIKE '%$searchQuery%'";
}

$result = $conn->query($sql);

$articles = [];

if ($result->num_rows > 0) {
    // Lấy dữ liệu từ mỗi hàng và đưa vào mảng $articles
    while ($row = $result->fetch_assoc()) {
        $articles[] = [
            "articleId" => $row["ArticleID"],
            "title" => $row["Title"],
            "content" => $row["Content"],
            "category" => $row["Category"],
            "publicationDate" => $row["PublicationDate"],
            "tags" => $row["Tags"],
            "imageUrl" => $row["ImageUrl"]
        ];
    }
    echo json_encode($articles, JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode([]);
}

// Đóng kết nối
$conn->close();
?>