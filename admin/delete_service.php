<?php
require '../backend/db_connect.php'; // Adjust the path as needed
require '../backend/check_login.php'; // Ensure the user is logged in

// Check if the service ID is provided
if (!isset($_GET['id'])) {
    die("Service ID not provided.");
}

$id = intval($_GET['id']);

// Prepare SQL query to delete the service
$sql = "DELETE FROM services WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    echo "The service was deleted successfully.";
    header("Location: ad_services.php"); // Redirect to the service list page
} else {
    echo "Database error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
