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
// Kiểm tra xem request method có phải là GET không
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Kiểm tra xem userId đã được truyền vào hay chưa
    if (isset($_GET['userId'])) {
        // Lấy userId từ query string và chuyển đổi thành integer
        $userId = intval($_GET['userId']);

        // Câu truy vấn SQL để lấy danh sách các bài báo đã lưu của userId
        $sql = "SELECT articles.ArticleID, articles.Title, articles.Content, articles.Category, articles.PublicationDate, articles.Tags, articles.ImageUrl, articles.ViewCount
                FROM articles
                INNER JOIN readinghistory ON articles.ArticleID = readinghistory.ArticleID
                WHERE readinghistory.UserID = $userId
                ORDER BY readinghistory.HistoryID DESC"; // Sắp xếp theo HistoryID để lấy các bài báo lưu gần đây nhất đầu tiên

        // Thực thi truy vấn
        $result = mysqli_query($conn, $sql);

        // Mảng để lưu các bài báo đã lưu
        $savedArticles = array();

        // Kiểm tra số dòng trả về từ truy vấn
        if (mysqli_num_rows($result) > 0) {
            // Duyệt qua từng dòng kết quả và thêm vào mảng $savedArticles
            while ($row = mysqli_fetch_assoc($result)) {
                // Đổi tên key theo yêu cầu của bạn
                $article = [
                    "articleId" => $row["ArticleID"],
                    "title" => $row["Title"],
                    "content" => $row["Content"],
                    "category" => $row["Category"],
                    "publicationDate" => $row["PublicationDate"],
                    "tags" => $row["Tags"],
                    "imageUrl" => $row["ImageUrl"],
                    "viewCount" => $row["ViewCount"]
                ];
                $savedArticles[] = $article;
            }
        }

        // Trả về kết quả dưới dạng JSON
        header('Content-Type: application/json');
        echo json_encode($savedArticles);

    } else {
        // Nếu userId không được truyền vào
        http_response_code(400); // Bad request
        echo json_encode(array("message" => "Missing userId parameter."));
    }

} else {
    // Nếu không phải method GET
    http_response_code(405); // Method Not Allowed
    echo json_encode(array("message" => "Method not allowed."));
}

// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>