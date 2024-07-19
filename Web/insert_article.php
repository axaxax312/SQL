<?php
session_start();
if (!isset($_SESSION["UserID"])) {
    header("Location: login.php");
    exit();
}

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
    $title = $_POST["title"];
    $content = $_POST["content"];
    $category = $_POST["category"];
    $tags = $_POST["tags"];
    $publication_date = $_POST["publication_date"];
    $image_url = $_POST["image_url"];

    $sql = "INSERT INTO Articles (Title, Content, Category, Tags, PublicationDate, ImageUrl) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $title, $content, $category, $tags, $publication_date, $image_url);

    if ($stmt->execute()) {
        echo "New article created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $conn->close();
    header("Location: index.php");
    exit();
}
?>