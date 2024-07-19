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

// Kiểm tra xem đã nhận được userId từ phía client chưa
if (isset($_GET['userId'])) {
    $userId = $_GET['userId'];

    // Xây dựng truy vấn SQL để lấy thông tin người dùng theo userId
    $sql = "SELECT * FROM users WHERE UserID = $userId";

    // Thực hiện truy vấn
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Dữ liệu được trả về dưới dạng mảng JSON
        $row = $result->fetch_assoc();
        $user = [
            "userId" => $row['UserID'],
            "username" => $row['Username'],
            "email" => $row['Email'],
            "fullName" => $row['FullName'],
            "address" => $row['Address'],
            "dateOfBirth" => $row['DateOfBirth'],
            "avatarUrl" => $row['AvatarUrl']
        ];
        echo json_encode($user);
    } else {
        echo json_encode(["message" => "User not found"]);
    }
} else {
    echo json_encode(["message" => "UserId not provided"]);
}

$conn->close();
?>