<?php
require '../backend/db_connect.php';
require '../backend/check_login.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $sql = "DELETE FROM slider WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    $stmt->close();
} else {
    echo "Invalid ID.";
}

$conn->close();
?>
