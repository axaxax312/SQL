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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>News Platform Manager</title>
</head>
<body>
    <h1>News Platform Manager</h1>
    <p>Welcome, <?php echo $_SESSION["Username"]; ?>!</p>
    <form action="insert_article.php" method="post">
        <input type="text" name="title" placeholder="Enter title">
        <textarea name="content" placeholder="Enter content"></textarea>
        <input type="text" name="category" placeholder="Enter category">
        <input type="text" name="tags" placeholder="Enter tags">
        <input type="datetime-local" name="publication_date" placeholder="Enter publication date">
        <input type="text" name="image_url" placeholder="Enter image URL">
        <input type="submit" value="Add Article">
    </form>
    <h2>Articles:</h2>
    <ul>
        <?php
        $sql = "SELECT ArticleID, Title FROM Articles";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<li>" . $row["Title"] . "</li>";
            }
        } else {
            echo "0 results";
        }
        $conn->close();
        ?>
    </ul>
    <a href="logout.php">Logout</a>
</body>
</html>