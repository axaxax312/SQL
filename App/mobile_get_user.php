<?php

// Database connection
require_once 'db_connect.php';

// Check if userId is provided via GET
if (isset($_GET['userId'])) {
    $userId = $_GET['userId'];

    // Prepare query to get user details by userId (use prepared statement to prevent SQL injection)
    $query = "SELECT UserID, Username, Email, FullName, Address, DateOfBirth FROM users WHERE UserID = ?";
    
    // Initialize a prepared statement
    $stmt = $conn->prepare($query);

    // Bind parameters
    $stmt->bind_param("i", $userId);

    // Execute query
    if ($stmt->execute()) {
        // Bind result variables
        $stmt->bind_result($userId, $username, $email, $fullName, $address, $dateOfBirth);

        // Fetch user data
        if ($stmt->fetch()) {
            // User found, create user array
            $user = array(
                'userId' => $userId,
                'username' => $username,
                'email' => $email,
                'fullName' => $fullName,
                'address' => $address,
                'dateOfBirth' => $dateOfBirth
            );

            // Return user data as JSON response
            header('Content-Type: application/json');
            echo json_encode($user);
        } else {
            // User not found
            http_response_code(404);
            echo json_encode(array('message' => 'User not found.'));
        }
    } else {
        // Error in executing query
        http_response_code(500);
        echo json_encode(array('message' => 'Error fetching user data.'));
    }

    // Close statement
    $stmt->close();

} else {
    // UserId parameter not provided
    http_response_code(400);
    echo json_encode(array('message' => 'UserId parameter is required.'));
}

// Close database connection
$conn->close();

?>