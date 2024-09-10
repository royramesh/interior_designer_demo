<?php
include('includes/header.php');
// Get the ID of the gallery item to be edited
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Fetch the current details of the gallery item
    $sql = "SELECT * FROM gallery WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $item = $result->fetch_assoc();
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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];

    // File upload processing
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $fileType = $_FILES['image']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        
        // New file name with a unique identifier
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        
        // Directory where the file will be stored
        $uploadFileDir = 'uploads/gallery/';
        $dest_path = $uploadFileDir . $newFileName;
        
        // Move the file from temporary directory to the target directory
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            // Update the image path in the database
            $sql = "UPDATE gallery SET title = ?, image_path = ?, description = ? WHERE id = ?";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param('sssi', $title, $dest_path, $description, $id);
                
                if ($stmt->execute()) {
                    echo "The gallery item was updated successfully.";
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
            echo "There was an error moving the uploaded file.";
        }
    } else {
        // If no new file is uploaded, just update the other details
        $sql = "UPDATE gallery SET title = ?, description = ? WHERE id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('ssi', $title, $description, $id);
            
            if ($stmt->execute()) {
                echo "The gallery item was updated successfully.";
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
    }
}

// Close the database connection
$conn->close();
?>


<div class="container">
  <div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold mb-3">Edit Gallery Item</h3>
      <ul class="breadcrumbs mb-3">
        <li class="nav-home">
          <a href="#">
            <i class="icon-home"></i>
          </a>
        </li>
        <li class="separator">
          <i class="icon-arrow-right"></i>
        </li>
        <li class="nav-item">
          <a href="#">Forms</a>
        </li>
        <li class="separator">
          <i class="icon-arrow-right"></i>
        </li>
        <li class="nav-item">
          <a href="#">Edit Gallery Item</a>
        </li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Edit Gallery Item Details</div>
          </div>
          <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-6 col-lg-4">
                  <div class="form-group">
                    <label for="title">Image Title</label>
                    <input
                      type="text"
                      class="form-control"
                      id="title"
                      name="title"
                      value="<?php echo htmlspecialchars($item['title']); ?>"
                      placeholder="Enter Image Title"
                      required
                    />
                  </div>
                  <div class="form-group">
                    <label for="image">Gallery Image (leave empty to keep current image)</label>
                    <input
                      type="file"
                      class="form-control"
                      id="image"
                      name="image"
                      accept="image/*"
                    />
                    <small class="form-text text-muted">
                    </small>
                    <?php if ($item['image_path']): ?>
                      <img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" style="width: 100px; height: auto; margin-top: 10px;">
                    <?php endif; ?>
                  </div>
                  <div class="form-group">
                    <label for="description">Image Description</label>
                    <textarea
                      class="form-control"
                      id="description"
                      name="description"
                      rows="4"
                      placeholder="Enter Image Description"
                      required
                    ><?php echo htmlspecialchars($item['description']); ?></textarea>
                  </div>
                </div>
              </div>
              <div class="card-action">
                <button type="submit" class="btn btn-success">Update</button>
                <a href="gallery.php" class="btn btn-secondary">Cancel</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include('includes/footer.php'); ?>
