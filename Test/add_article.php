<?php
// Bước 1: Kết nối đến cơ sở dữ liệu
include 'db_connect.php';

// Bước 2: Kiểm tra và lấy dữ liệu từ form gửi đi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $publicationDate = $_POST['publication_date'];
    $tags = $_POST['tags'];
    $imageUrl = $_POST['image_url'];

    // Bước 3: Validate dữ liệu (nếu cần thiết)

    // Bước 4: Chuẩn bị câu lệnh SQL để thêm dữ liệu vào bảng articles
    $sql = "INSERT INTO articles (Title, Content, Category, PublicationDate, Tags, ImageUrl) 
            VALUES ('$title', '$content', '$category', '$publicationDate', '$tags', '$imageUrl')";

    // Bước 5: Thực thi câu lệnh SQL và kiểm tra kết quả
    if (mysqli_query($conn, $sql)) {
        // Nếu thêm bài viết thành công, thông báo thành công và chuyển về trang quản lý bài viết
        echo "Thêm bài viết thành công!";
        // Ví dụ chuyển hướng về trang quản lý sau 2 giây
        header("refresh:2; url=manager_articles.php");
    } else {
        // Nếu có lỗi, thông báo lỗi và hiển thị chi tiết lỗi
        echo "Lỗi: " . mysqli_error($conn);
    }
}

// Bước 6: Đóng kết nối cơ sở dữ liệu
mysqli_close($conn);
?>