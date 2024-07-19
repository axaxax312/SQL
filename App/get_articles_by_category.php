<?php
// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "news_platform";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kiểm tra xem đã nhận được category từ phía client chưa
if (isset($_GET['category'])) {
    $category = $_GET['category'];

    // Xây dựng truy vấn SQL để lấy các bài viết theo danh mục
    $sql = "SELECT * FROM articles WHERE Category = ?";
    
    // Sử dụng prepared statement để tránh SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Dữ liệu được trả về dưới dạng mảng JSON
        $articles = array();
        while ($row = $result->fetch_assoc()) {
            $articles[] = [
                "articleId" => $row["ArticleID"],
                "title" => $row["Title"],
                "content" => $row["Content"],
                "category" => $row["Category"],
                "publicationDate" => $row["PublicationDate"],
                "tags" => $row["Tags"],
                "imageUrl" => $row["ImageUrl"],
                "viewCount" => $row["ViewCount"]
            ];
        }
        echo json_encode($articles);
    } else {
        // Không có bài viết nào trong danh mục này
        echo json_encode(array('message' => 'No articles found in this category.'));
    }

    // Đóng prepared statement
    $stmt->close();
} else {
    // Không có tham số category được truyền vào
    echo json_encode(array('message' => 'Category parameter is missing.'));
}

// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>