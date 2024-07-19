<?php
include 'db_connect.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ yêu cầu POST
    $articleID = $_POST['ArticleID'];
    $userID = $_POST['UserID'];

    // Kiểm tra xem người dùng đã like bài viết này chưa
    $checkQuery = "SELECT * FROM likes WHERE ArticleID = ? AND UserID = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ii", $articleID, $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Thêm like mới
        $insertQuery = "INSERT INTO likes (ArticleID, UserID) VALUES (?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ii", $articleID, $userID);

        if ($stmt->execute()) {
            $response['error'] = false;
            $response['message'] = 'Liked successfully';
        } else {
            $response['error'] = true;
            $response['message'] = 'Failed to like';
        }
    } else {
        $response['error'] = true;
        $response['message'] = 'Already liked';
    }

    $stmt->close();
} else {
    $response['error'] = true;
    $response['message'] = 'Invalid request';
}

echo json_encode($response);
$conn->close();
?>