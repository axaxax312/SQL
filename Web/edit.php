<?php
include 'db_connect.php';

$id = $_GET['id'];
$sql = "SELECT * FROM articles WHERE ArticleID = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $publication_date = $_POST['publication_date'];
    $tags = $_POST['tags'];
    $image_url = $_POST['image_url'];

    $sql = "UPDATE articles SET Title = '$title', Content = '$content', Category = '$category', PublicationDate = '$publication_date', Tags = '$tags', ImageUrl = '$image_url' WHERE ArticleID = $id";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa bài báo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Sửa bài báo</h1>
    <form method="POST" action="">
        <label for="title">Tiêu đề:</label>
        <input type="text" id="title" name="title" value="<?php echo $row['Title']; ?>" required><br>
        
        <label for="content">Nội dung:</label>
        <textarea id="content" name="content" required><?php echo $row['Content']; ?></textarea><br>
        
        <label for="category">Chuyên mục:</label>
        <input type="text" id="category" name="category" value="<?php echo $row['Category']; ?>" required><br>
        
        <label for="publication_date">Ngày đăng:</label>
        <input type="datetime-local" id="publication_date" name="publication_date" value="<?php echo $row['PublicationDate']; ?>"><br>
        
        <label for="tags">Tags:</label>
        <input type="text" id="tags" name="tags" value="<?php echo $row['Tags']; ?>"><br>
        
        <label for="image_url">URL ảnh:</label>
        <input type="text" id="image_url" name="image_url" value="<?php echo $row['ImageUrl']; ?>"><br>
        
        <button type="submit">Lưu</button>
    </form>
</body>
</html>