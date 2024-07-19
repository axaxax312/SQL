<?php
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "news_platform";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$articleId = $_POST['articleId'];
$userId = $_POST['userId'];
$commentText = $_POST['commentText'];

$sql = "INSERT INTO comments (ArticleID, UserID, Content, Timestamp) VALUES (?, ?, ?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $articleId, $userId, $commentText);

$response = array();

if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['success'] = false;
    $response['message'] = $stmt->error;
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>