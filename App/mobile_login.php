<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ request POST
    $input = json_decode(file_get_contents('php://input'), true);
    $username = $input['username'];
    $password = $input['password'];

    // Thực hiện kết nối tới MySQL
    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "news_platform";

    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
    }

    // Truy vấn để lấy thông tin người dùng từ database
    $sql = "SELECT UserID, Username, PasswordHash, Role FROM Users WHERE Username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Đã tìm thấy người dùng, kiểm tra mật khẩu
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["PasswordHash"])) {
            // Mật khẩu đúng, trả về thông tin người dùng bao gồm UserID
            echo json_encode([
                "success" => true,
                "message" => "Login successful",
                "userId" => $row["UserID"], // Thêm UserID vào phản hồi
                "user" => [
                    "Username" => $row["Username"],
                    "Role" => $row["Role"]
                ]
            ]);
        } else {
            // Mật khẩu không đúng
            echo json_encode(["success" => false, "message" => "Invalid password"]);
        }
    } else {
        // Không tìm thấy người dùng với username đã nhập
        echo json_encode(["success" => false, "message" => "User not found"]);
    }

    // Đóng kết nối và các tài nguyên
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "This is not a POST request"]);
}
?>