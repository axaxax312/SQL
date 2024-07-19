<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "news_platform";

// Tạo kết nối đến MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Câu lệnh truy vấn SQL để lấy danh sách các category
$sql = "SELECT * FROM category ORDER BY CategoryID ASC" ;

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $categories = array();

    // Lặp qua các dòng kết quả và đưa vào mảng categories
    while ($row = $result->fetch_assoc()) {
        $category = array(
            'CategoryID' => $row['CategoryID'],
            'CategoryName' => $row['CategoryName']
        );
        $categories[] = $category; // Thêm category vào mảng
    }

    // Trả về JSON response
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode($categories, JSON_UNESCAPED_UNICODE);
} else {
    // Nếu không có kết quả trả về
    echo "0 results";
}

$conn->close();
?>