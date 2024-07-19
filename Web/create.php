
<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $publication_date = $_POST['publication_date'];
    $tags = $_POST['tags'];
    $image_url = $_POST['image_url'];

    $sql = "INSERT INTO articles (Title, Content, Category, PublicationDate, Tags, ImageUrl) VALUES ('$title', '$content', '$category', '$publication_date', '$tags', '$image_url')";
    if ($conn->query($sql) === TRUE) {
        header("Location: index1.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm bài báo mới</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <div class="content">
        <h1>Thêm bài báo mới</h1>
        <form method="POST" action="">
            <label for="title">Tiêu đề:</label>
            <input type="text" id="title" name="title" required><br>
            
            <label for="content">Nội dung:</label>
            <textarea id="content" name="content" required></textarea><br>
            
            <label for="category">Chuyên mục:</label>
            <input type="text" id="category" name="category" required><br>
            
            <label for="publication_date">Ngày đăng:</label>
            <input type="datetime-local" id="publication_date" name="publication_date"><br>
            
            <label for="tags">Tags:</label>
            <input type="text" id="tags" name="tags"><br>
            
            <label for="image_url">URL ảnh:</label>
            <input type="text" id="image_url" name="image_url"><br>
            
            <button type="submit">Lưu</button>
        </form>
    </div>

    <!-- Các script và mã JavaScript có thể được thêm vào sau -->

</body>
</html>