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

// Xác thực đăng nhập
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT UserID, Username, PasswordHash, Role FROM Users WHERE Username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["PasswordHash"])) {
            // Lưu thông tin vào session
            $_SESSION["UserID"] = $row["UserID"];
            $_SESSION["Username"] = $row["Username"];
            $_SESSION["Role"] = $row["Role"];

            // Redirect đến trang phù hợp sau khi đăng nhập thành công
            if ($_SESSION["Role"] == "admin") {
                header("Location: index.php");
            } else {
                echo "You are not Admin";
            }
            exit();
        } else {
            echo "Invalid password";
        }
    } else {
        echo "User not found";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <?php
    if (isset($error_message)) {
        echo "<p style='color:red;'>" . $error_message . "</p>";
    }
    ?>
    <form action="login.php" method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Login">
    </form>
    <a href="register.php">Register</a>
</body>
</html>