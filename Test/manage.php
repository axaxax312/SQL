<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý bài viết</title>
    <link rel="stylesheet" href="styles.css"> <!-- CSS chung -->
    <link rel="stylesheet" href="css/manage.css"> <!-- CSS riêng cho phần manage -->
    <style>
        /* CSS để ẩn form khi chưa nhấn nút */
        .add-article-form {
            display: none;
        }
    </style>
</head>
<body>

<?php include 'includes/header.php'; ?> <!-- Header -->
<?php include 'includes/sidebar.php'; ?> <!-- Side Navigation Menu -->

<!-- Main Content Area -->
<div class="main-content">
    <!-- Nội dung chính của trang quản lý -->
    <div class="manage">
        <h2>Tìm kiếm bài viết</h2>
        <!-- Đặt form tìm kiếm ở đây -->
        <form action="manager_articles.php" method="GET">
            <input type="text" name="search_title" placeholder="Tìm kiếm theo tiêu đề">
            <select name="category">
                <option value="">Chọn danh mục</option>
                <?php
                // Kết nối đến cơ sở dữ liệu
                include 'db_connect.php';

                // Truy vấn lấy danh mục từ bảng articles (lấy các giá trị duy nhất)
                $query = "SELECT DISTINCT Category FROM articles";
                $result = mysqli_query($conn, $query);

                // Duyệt qua kết quả và hiển thị các option
                while ($row = mysqli_fetch_assoc($result)) {
                    $categoryName = $row['Category'];
                    echo "<option value='$categoryName'>$categoryName</option>";
                }

                // Đóng kết nối
                mysqli_close($conn);
                ?>
            </select>
            <input type="date" name="start_date">
            <input type="date" name="end_date">
            <button type="submit">Tìm kiếm</button>
        </form>

        <!-- Nút và form thêm bài viết mới -->
        <button onclick="toggleAddArticleForm()">Thêm bài viết</button>
        <div class="add-article-form" id="addArticleForm">
            <h2>Thêm bài viết mới</h2>
            <form action="add_article.php" method="POST">
                <label for="title">Tiêu đề:</label><br>
                <input type="text" id="title" name="title" required><br><br>
                <label for="content">Nội dung:</label><br>
                <textarea id="content" name="content" rows="10" required></textarea><br><br>
                <label for="category">Danh mục:</label><br>
                <input type="text" name="category" placeholder="Danh mục" required><br><br>
                <label for="image_url">Đường dẫn hình ảnh:</label><br>
                <input type="text" id="image_url" name="image_url"><br><br>
                <label for="tags">Tags:</label><br>
                <input type="text" id="tags" name="tags"><br><br>
                <label for="publication_date">Ngày xuất bản:</label><br>
                <input type="date" id="publication_date" name="publication_date"><br><br>
                <button type="submit">Thêm bài viết</button>
            </form>
        </div>
        <!-- Phần thống kê và báo cáo -->
     <?php include 'statistics.php'; ?>
    </div>
     
</div>

<?php include 'includes/footer.php'; ?> <!-- Footer -->

<!-- Script JavaScript để xử lý hiển thị form -->
<script>
    function toggleAddArticleForm() {
        var addArticleForm = document.getElementById("addArticleForm");
        if (addArticleForm.style.display === "none") {
            addArticleForm.style.display = "block";
        } else {
            addArticleForm.style.display = "none";
        }
    }
</script>

</body>
</html>