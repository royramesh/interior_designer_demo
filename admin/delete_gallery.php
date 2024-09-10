<?php
require '../backend/db_connect.php'; // Adjust the path as needed
require '../backend/check_login.php'; // Ensure the user is logged in

// Get the ID of the gallery item to be deleted
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Fetch the current details of the gallery item
    $sql = "SELECT image_path FROM gallery WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $item = $result->fetch_assoc();
            $imagePath = $item['image_path'];
            
            // Delete the gallery item from the database
            $sql = "DELETE FROM gallery WHERE id = ?";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param('i', $id);
                
                if ($stmt->execute()) {
                    // Delete the image file from the server
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                    
                    echo "The gallery item was deleted successfully.";
                    header("Location: ad_gallery.php"); // Redirect to gallery overview page
                    exit();
                } else {
                    echo "Database error: " . $stmt->error;
                }
                
                // Close the statement
                $stmt->close();
            } else {
                echo "Error preparing SQL statement: " . $conn->error;
            }
        } else {
            echo "No gallery item found.";
            exit();
        }

        $stmt->close();
    } else {
        echo "Error preparing SQL statement: " . $conn->error;
        exit();
    }
} else {
    echo "No ID specified.";
    exit();
}

// Close the database connection
$conn->close();
?>
