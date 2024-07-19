<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="common.css">
    <link rel="stylesheet" href="views.css">
</head>
<body>
    <div class="content">
        <div class="article-table">
            <?php
            include 'db_connect.php';

            $sql = "SELECT ArticleID, Title, Category, PublicationDate, ImageUrl, ViewCount
                    FROM articles
                    ORDER BY ViewCount DESC
                    LIMIT 5"; // Lấy 5 bài viết có lượt xem cao nhất

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>ArticleID</th>";
                echo "<th>Title</th>";
                echo "<th>Category</th>";
                echo "<th>PublicationDate</th>";
                echo "<th>ImageUrl</th>";
                echo "<th>ViewCount</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['ArticleID'] . "</td>";
                    echo "<td>" . $row['Title'] . "</td>";
                    echo "<td>" . $row['Category'] . "</td>";
                    echo "<td>" . $row['PublicationDate'] . "</td>";
                    echo "<td><img src='" . $row['ImageUrl'] . "' alt='Image' width='50'></td>";
                    echo "<td>" . $row['ViewCount'] . "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "Không có bài viết nào.";
            }
            ?>
        </div>
    </div>
</body>
</html>