<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý bài viết</title>
    <link rel="stylesheet" href="styles.css"> <!-- CSS chung -->
    <link rel="stylesheet" href="css/manager.css"> <!-- CSS riêng cho phần manage -->
</head>
<body>

<?php include 'includes/header.php'; ?> <!-- Header -->
<?php include 'includes/sidebar.php'; ?> <!-- Side Navigation Menu -->

<!-- Main Content Area -->
<div class="main-content">
    <!-- Nội dung chính của trang quản lý -->
    <div class="manage">
        <h2>Danh sách bài viết</h2>
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
        <!-- Hiển thị danh sách bài viết -->
        <?php
        include 'db_connect.php'; // Kết nối đến cơ sở dữ liệu

        // Xử lý tìm kiếm và lọc
        $whereClause = '';
        $search_title = isset($_GET['search_title']) ? $_GET['search_title'] : '';
        $category = isset($_GET['category']) ? $_GET['category'] : '';
        $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
        $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

        // Xây dựng điều kiện WHERE cho câu truy vấn
        if (!empty($search_title)) {
            $whereClause .= " AND Title LIKE '%$search_title%'";
        }

        if (!empty($category)) {
            $whereClause .= " AND Category = '$category'";
        }

        if (!empty($start_date) && !empty($end_date)) {
            $whereClause .= " AND PublicationDate BETWEEN '$start_date' AND '$end_date'";
        }

        // Truy vấn lấy danh sách bài viết từ bảng articles với điều kiện WHERE
        $sql = "SELECT * FROM articles WHERE 1=1 $whereClause";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo '<table>';
            echo '<tr><th>ArticleID</th><th>Title</th><th>Category</th><th>Publication Date</th><th>Actions</th></tr>';
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['ArticleID'] . '</td>';
                echo '<td>' . $row['Title'] . '</td>';
                echo '<td>' . $row['Category'] . '</td>';
                echo '<td>' . $row['PublicationDate'] . '</td>';
                echo '<td class="action-links">';
                echo '<a href="edit_article.php?id=' . $row['ArticleID'] . '">Edit</a> | ';
                echo '<a href="delete_article.php?id=' . $row['ArticleID'] . '">Delete</a>';
                echo '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo 'Không tìm thấy bài viết.';
        }

        mysqli_close($conn); // Đóng kết nối
        ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?> <!-- Footer -->

</body>
</html>