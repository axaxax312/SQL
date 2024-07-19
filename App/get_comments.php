<?php
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "news_platform";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

if ($conn->connect_error) {
    die(json_encode(array("error" => "Connection failed: " . $conn->connect_error)));
}

$articleId = isset($_GET['articleId']) ? $_GET['articleId'] : null;

if ($articleId === null) {
    die(json_encode(array("error" => "Article ID is required")));
}

$sql = "
    SELECT 
        comments.CommentID, 
        comments.ArticleID, 
        comments.UserID, 
        comments.Content, 
        comments.Timestamp, 
        users.Username 
    FROM 
        comments 
    JOIN 
        users 
    ON 
        comments.UserID = users.UserID 
    WHERE 
        comments.ArticleID = ?
";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die(json_encode(array("error" => "SQL prepare failed: " . $conn->error)));
}

$stmt->bind_param("i", $articleId);
$stmt->execute();

$result = $stmt->get_result();
$comments = array();

while ($row = $result->fetch_assoc()) {
    $comments[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode($comments);
?>