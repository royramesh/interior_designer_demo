<?php
include('includes/header.php');

if (isset($_GET['id'])) {
    $sliderId = $_GET['id'];

    // Fetch existing data
    $sql = "SELECT * FROM slider WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('i', $sliderId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $slider = $result->fetch_assoc();
        } else {
            echo "No record found.";
            exit;
        }
        
        $stmt->close();
    } else {
        echo "Error preparing SQL statement: " . $conn->error;
        exit;
    }
} else {
    echo "No ID specified.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and process form inputs
    $sliderText = $_POST['sliderText'];
    $imageAltText = $_POST['imageAltText'];
    $fileName = $slider['image_path']; // Use existing file by default

    // File upload processing
    if (isset($_FILES['sliderImage']) && $_FILES['sliderImage']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['sliderImage']['tmp_name'];
        $fileName = $_FILES['sliderImage']['name'];
        $fileSize = $_FILES['sliderImage']['size'];
        $fileType = $_FILES['sliderImage']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        
        // New file name with a unique identifier
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        
        // Directory where the file will be stored
        $uploadFileDir = 'uploads/slider/';
        $dest_path = $uploadFileDir . $newFileName;
        
        // Move the file from temporary directory to the target directory
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $fileName = $dest_path; // Update with new file name
        } else {
            echo "There was an error moving the uploaded file.";
            exit;
        }
    }

    // Update SQL query
    $sql = "UPDATE slider SET text = ?, image_path = ?, alt_text = ? WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('sssi', $sliderText, $fileName, $imageAltText, $sliderId);
        
        if ($stmt->execute()) {
            echo "The data was updated successfully.";
            header("Location: index.php");
        } else {
            echo "Database error: " . $stmt->error;
        }
        
        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing SQL statement: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
<div class="container">
  <div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold mb-3">Forms</h3>
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
          <a href="#">Edit Slider</a>
        </li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Edit Slider Text and Image</div>
          </div>
          <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-6 col-lg-4">
                  <div class="form-group">
                    <label for="sliderText">Slider Text</label>
                    <input
                      type="text"
                      class="form-control"
                      id="sliderText"
                      name="sliderText"
                      value="<?php echo htmlspecialchars($slider['text']); ?>"
                      placeholder="Enter Slider Text"
                      required
                    />
                  </div>
                  <div class="form-group">
                    <label for="sliderImage">Slider Image</label>
                    <input
                      type="file"
                      class="form-control"
                      id="sliderImage"
                      name="sliderImage"
                      accept="image/*"
                    />
                    <small class="form-text text-muted">
                      Leave empty to keep the current image.
                    </small>
                    <?php if (!empty($slider['image_path'])): ?>
                      <div class="mt-2">
                        <label>Current Image:</label><br>
                        <img src="<?php echo htmlspecialchars($slider['image_path']); ?>" alt="Current Slider Image" style="max-width: 100%; height: auto;">
                      </div>
                    <?php endif; ?>
                  </div>
                  <div class="form-group">
                    <label for="imageAltText">Image Alt Text</label>
                    <input
                      type="text"
                      class="form-control"
                      id="imageAltText"
                      name="imageAltText"
                      value="<?php echo htmlspecialchars($slider['alt_text']); ?>"
                      placeholder="Enter Image Alt Text"
                      required
                    />
                  </div>
                </div>
              </div>
              <div class="card-action">
                <button type="submit" class="btn btn-success">Update</button>
                <a href="slider_list.php" class="btn btn-secondary">Cancel</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include('includes/footer.php'); ?>
