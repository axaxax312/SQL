<?php
include 'db_connect.php'; // Kết nối đến cơ sở dữ liệu

// Lấy ArticleID từ tham số truyền vào
$articleID = isset($_GET['id']) ? $_GET['id'] : '';

// Xử lý khi người dùng xác nhận xóa bài viết
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $deleteSql = "DELETE FROM articles WHERE ArticleID = $articleID";
    if (mysqli_query($conn, $deleteSql)) {
        echo 'Xóa bài viết thành công.';
        // Redirect về trang danh sách bài viết sau khi xóa
        header('Location: manager_articles.php');
        exit;
    } else {
        echo 'Lỗi khi xóa bài viết: ' . mysqli_error($conn);
    }
}

// Truy vấn để lấy thông tin chi tiết của bài viết
$sql = "SELECT * FROM articles WHERE ArticleID = $articleID";
$result = mysqli_query($conn, $sql);
$article = mysqli_fetch_assoc($result);

if (!$article) {
    echo 'Bài viết không tồn tại.';
    exit;
}

// Form xác nhận xóa bài viết
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xóa bài viết</title>
    <link rel="stylesheet" href="styles.css"> <!-- CSS chung -->
</head>
<body>

<?php include 'includes/header.php'; ?> <!-- Header -->
<?php include 'includes/sidebar.php'; ?> <!-- Side Navigation Menu -->

<!-- Main Content Area -->
<div class="main-content">
    <!-- Nội dung chính của trang xóa bài viết -->
    <div class="manage">
        <h2>Xóa bài viết</h2>
        <p>Bạn có chắc chắn muốn xóa bài viết "<strong><?php echo $article['Title']; ?></strong>"?</p>
        <form action="" method="POST">
            <button type="submit">Xác nhận xóa</button>
            <a href="manager_articles.php">Hủy</a>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?> <!-- Footer -->

</body>
</html>

<?php
mysqli_close($conn); // Đóng kết nối
?>