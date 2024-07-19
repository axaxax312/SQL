<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê và báo cáo</title>
    <link rel="stylesheet" href="styles.css"> <!-- CSS chung -->
    <link rel="stylesheet" href="css/statistics.css"> <!-- CSS riêng cho phần manage -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Thư viện Chart.js -->
</head>

<body>

<!-- Main Content Area -->
<div class="main-content">
    <!-- Nội dung chính của trang thống kê -->
    <div class="statistics">
        <h2>Thống kê và báo cáo</h2>
        <!-- Biểu đồ top 5 category của bài viết có lượt xem cao nhất -->
        <div class="chart">
            <h3>Top 5 Thư viện của bài viết có lượt xem cao nhất</h3>
            <canvas id="chartCategories" width="600" height="500"></canvas>
        </div>
        <!-- Biểu đồ top 5 bài viết có lượt xem cao nhất -->
        <div class="chart">
            <h3>Top 5 bài viết có lượt xem cao nhất</h3>
            <table>
                <tr>
                    <th>Article ID</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Category</th>
                    <th>Số lượt xem</th>
                    <th>Số lượt comment</th>
                    <th>Ngày đăng</th>
                </tr>
                <?php
                // Kết nối đến cơ sở dữ liệu
                include 'db_connect.php';

                // Lấy top 5 bài viết có lượt xem cao nhất và các thông tin liên quan
                $sql_top_views = "SELECT a.ArticleID, a.Title, a.ImageUrl, a.Category, a.ViewCount, COUNT(c.CommentID) AS CommentCount, a.PublicationDate 
                                FROM articles a LEFT JOIN comments c ON a.ArticleID = c.ArticleID 
                                GROUP BY a.ArticleID 
                                ORDER BY a.ViewCount DESC 
                                LIMIT 5";
                $result_top_views = mysqli_query($conn, $sql_top_views);

                // Hiển thị kết quả trong bảng
                while ($row = mysqli_fetch_assoc($result_top_views)) {
                    echo "<tr>";
                    echo "<td>" . $row['ArticleID'] . "</td>";
                    echo "<td>" . $row['Title'] . "</td>";
                    echo "<td><img src='" . $row['ImageUrl'] . "' alt='Image'></td>";
                    echo "<td>" . $row['Category'] . "</td>";
                    echo "<td>" . $row['ViewCount'] . "</td>";
                    echo "<td>" . $row['CommentCount'] . "</td>";
                    echo "<td>" . $row['PublicationDate'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>

        

        <!-- Biểu đồ top 5 bài viết có số lượng like cao nhất -->
        <div class="chart">
            <h3>Top 5 bài viết có số lượng like cao nhất</h3>
            <table>
                <tr>
                    <th>Article ID</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Category</th>
                    <th>Số lượng like</th>
                    <th>Số lượt comment</th>
                    <th>Ngày đăng</th>
                </tr>
                <?php
                // Lấy top 5 bài viết có số lượng like cao nhất và các thông tin liên quan
                $sql_top_likes = "SELECT a.ArticleID, a.Title, a.ImageUrl, a.Category, COUNT(l.LikeID) AS LikeCount, COUNT(c.CommentID) AS CommentCount, a.PublicationDate 
                                FROM articles a 
                                LEFT JOIN likes l ON a.ArticleID = l.ArticleID 
                                LEFT JOIN comments c ON a.ArticleID = c.ArticleID 
                                GROUP BY a.ArticleID 
                                ORDER BY LikeCount DESC 
                                LIMIT 5";
                $result_top_likes = mysqli_query($conn, $sql_top_likes);

                // Hiển thị kết quả trong bảng
                while ($row = mysqli_fetch_assoc($result_top_likes)) {
                    echo "<tr>";
                    echo "<td>" . $row['ArticleID'] . "</td>";
                    echo "<td>" . $row['Title'] . "</td>";
                    echo "<td><img src='" . $row['ImageUrl'] . "' alt='Image'></td>";
                    echo "<td>" . $row['Category'] . "</td>";
                    echo "<td>" . $row['LikeCount'] . "</td>";
                    echo "<td>" . $row['CommentCount'] . "</td>";
                    echo "<td>" . $row['PublicationDate'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </div>
</div>

<script>
    // Vẽ biểu đồ bằng Chart.js
    <?php
    // Lấy top 5 category của bài viết có lượt xem cao nhất
    $sql_top_categories = "SELECT Category, COUNT(*) AS ArticleCount FROM articles GROUP BY Category ORDER BY ArticleCount DESC LIMIT 5";
    $result_top_categories = mysqli_query($conn, $sql_top_categories);
    $chartLabels_categories = [];
    $chartData_categories = [];
    while ($row = mysqli_fetch_assoc($result_top_categories)) {
        $chartLabels_categories[] = $row['Category'];
        $chartData_categories[] = $row['ArticleCount'];
    }
    ?>

    var ctxCategories = document.getElementById('chartCategories').getContext('2d');
    var chartCategories = new Chart(ctxCategories, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($chartLabels_categories); ?>,
            datasets: [{
                label: 'Số lượng bài viết',
                data: <?php echo json_encode($chartData_categories); ?>,
                backgroundColor: 'rgba(153, 102, 255, 0.6)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

</body>
</html>