<?php
require '../backend/db_connect.php'; // Adjust the path as needed
require '../backend/check_login.php'; // Ensure the user is logged in

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Fetch the current photo path for deletion
    $sql = "SELECT photo_path FROM team_members WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $photoPath = $row['photo_path'];
        } else {
            echo "Team member not found.";
            exit;
        }
        $stmt->close();
    } else {
        echo "Error preparing SQL statement: " . $conn->error;
        exit;
    }

    // Delete the record from the database
    $sql = "DELETE FROM team_members WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            // Delete the photo file if it exists
            if (file_exists($photoPath)) {
                unlink($photoPath);
            }
            echo "Team member deleted successfully.";
            header("Location: ad_team.php");
        } else {
            echo "Database error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing SQL statement: " . $conn->error;
    }
} else {
    echo "No ID provided.";
}

// Close the database connection
$conn->close();
?>
