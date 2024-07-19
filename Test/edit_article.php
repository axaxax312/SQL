<?php
include 'db_connect.php'; // Kết nối đến cơ sở dữ liệu

// Lấy ArticleID từ tham số truyền vào
$articleID = isset($_GET['id']) ? $_GET['id'] : '';

// Truy vấn để lấy thông tin chi tiết của bài viết
$sql = "SELECT * FROM articles WHERE ArticleID = $articleID";
$result = mysqli_query($conn, $sql);
$article = mysqli_fetch_assoc($result);

if (!$article) {
    echo 'Bài viết không tồn tại.';
    exit;
}

// Xử lý khi người dùng submit form chỉnh sửa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newTitle = $_POST['title'];
    $newContent = $_POST['content'];
    $newCategory = $_POST['category'];
    $newImageUrl = $_POST['image_url'];
    $newTags = $_POST['tags'];
    $newPublicationDate = $_POST['publication_date'];

    // Cập nhật thông tin bài viết vào cơ sở dữ liệu
    $updateSql = "UPDATE articles SET Title = '$newTitle', Content = '$newContent', Category = '$newCategory', ImageUrl = '$newImageUrl', Tags = '$newTags', PublicationDate = '$newPublicationDate' WHERE ArticleID = $articleID";
    if (mysqli_query($conn, $updateSql)) {
        echo 'Cập nhật bài viết thành công.';
        // Redirect về trang danh sách bài viết sau khi cập nhật
        header('Location: manager_articles.php');
        exit;
    } else {
        echo 'Lỗi khi cập nhật bài viết: ' . mysqli_error($conn);
    }
}

// Đóng kết nối
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa bài viết</title>
    <link rel="stylesheet" href="css/edit_articles.css"> <!-- CSS chung -->

</head>
<body>

<?php include 'includes/header.php'; ?> <!-- Header -->
<?php include 'includes/sidebar.php'; ?> <!-- Side Navigation Menu -->

<!-- Main Content Area -->
<div class="main-content">
    <!-- Nội dung chính của trang chỉnh sửa bài viết -->
    <div class="manage">
        <h2>Chỉnh sửa bài viết</h2>
        <form action="" method="POST">
            <label for="title">Tiêu đề:</label><br>
            <input type="text" id="title" name="title" value="<?php echo $article['Title']; ?>"><br><br>
            <label for="content">Nội dung:</label><br>
            <textarea id="content" name="content" rows="10"><?php echo $article['Content']; ?></textarea><br><br>
            <label for="category">Danh mục:</label><br>
            <select id="category" name="category">
                <option value="Thể thao" <?php if ($article['Category'] === 'Thể thao') echo 'selected'; ?>>Thể thao</option>
                <option value="Kinh tế" <?php if ($article['Category'] === 'Kinh tế') echo 'selected'; ?>>Kinh tế</option>
                <option value="Công nghệ" <?php if ($article['Category'] === 'Công nghệ') echo 'selected'; ?>>Công nghệ</option>
            </select><br><br>
            <label for="image_url">Đường dẫn hình ảnh:</label><br>
            <input type="text" id="image_url" name="image_url" value="<?php echo $article['ImageUrl']; ?>"><br><br>
            <label for="tags">Tags:</label><br>
            <input type="text" id="tags" name="tags" value="<?php echo $article['Tags']; ?>"><br><br>
            <label for="publication_date">Ngày xuất bản:</label><br>
            <input type="date" id="publication_date" name="publication_date" value="<?php echo $article['PublicationDate']; ?>"><br><br>
            <button type="submit">Lưu thay đổi</button>
            <a href="manager_articles.php">Hủy</a>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?> <!-- Footer -->

</body>
</html>