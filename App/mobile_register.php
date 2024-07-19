<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = json_decode(file_get_contents('php://input'), true);
    $username = $input['username'];
    $email = $input['email'];
    $password = $input['password'];
    $fullName = $input['fullName'];
    $dateOfBirth = $input['dateOfBirth'];

// Chuyển đổi thành định dạng DATE (YYYY-MM-DD)
    $dateOfBirthFormatted = date('Y-m-d', strtotime($dateOfBirth));
    $address = $input['address'];

    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "news_platform";

    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

    if ($conn->connect_error) {
        die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
    }

    $conn->set_charset("utf8");

    // Kiểm tra xem username hoặc email đã tồn tại chưa
    $checkSql = "SELECT * FROM Users WHERE Username = ? OR Email = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("ss", $username, $email);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        echo json_encode(["success" => false, "message" => "Username or Email already exists"]);
    } else {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO Users (Username, Email, PasswordHash, Role, FullName, DateOfBirth, Address) VALUES (?, ?, ?, 'user', ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $username, $email, $passwordHash, $fullName, $dateOfBirth, $address);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Registration successful"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
        }

        $stmt->close();
    }

    $checkStmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "This is not a POST request"]);
}
?>