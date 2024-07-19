<?php
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['userId']) && isset($_POST['base64Image'])) {
        $userId = $_POST['userId'];
        $base64Image = $_POST['base64Image'];

        // Decode base64 string to image
        $imageData = base64_decode($base64Image);
        $fileName = 'avatar_' . $userId . '.jpg';
        $filePath = 'avatars/' . $fileName;

        if (file_put_contents($filePath, $imageData)) {
            $avatarUrl = 'http://yourserver.com/' . $filePath;

            $query = "UPDATE users SET AvatarUrl = ? WHERE UserID = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("si", $avatarUrl, $userId);
            if ($stmt->execute()) {
                echo json_encode(['message' => 'Avatar updated successfully']);
            } else {
                echo json_encode(['error' => 'Failed to update avatar in database']);
            }

            $stmt->close();
        } else {
            echo json_encode(['error' => 'Failed to save image']);
        }
    } else {
        echo json_encode(['error' => 'Invalid parameters']);
    }
}

$conn->close();
?>