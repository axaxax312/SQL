<?php
require 'db_connect.php';

if (isset($_GET['userId'])) {
    $userId = $_GET['userId'];

    $query = "SELECT UserID, Username, Email, FullName, Address, DateOfBirth, AvatarUrl FROM users WHERE UserID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo json_encode($user);
    } else {
        echo json_encode(['error' => 'User not found']);
    }

    $stmt->close();
}

$conn->close();
?>