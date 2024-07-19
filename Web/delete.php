<?php
include 'db_connect.php';

$id = $_GET['id'];
$sql = "DELETE FROM articles WHERE ArticleID = $id";
if ($conn->query($sql) === TRUE) {
    header("Location: index.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>