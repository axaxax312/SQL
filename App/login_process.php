<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "news_platform";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Truy vấn để lấy mật khẩu đã băm từ cơ sở dữ liệu
    $sql = "SELECT UserID, PasswordHash FROM Users WHERE Username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["PasswordHash"])) {
            // Lưu trữ thông tin người dùng trong session
            $_SESSION["UserID"] = $row["UserID"];
            $_SESSION["Username"] = $username;
            header("Location: index.php");
            exit();
        } else {
            echo "Invalid password";
        }
    } else {
        echo "No user found with that username";
    }
    $conn->close();
}
?>