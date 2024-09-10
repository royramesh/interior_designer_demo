<?php include('includes/header.php'); ?>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and process form inputs
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
            // Prepare SQL query to insert form data into the database
            $sql = "INSERT INTO gallery (title, image_path, description) VALUES (?, ?, ?)";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param('sss', $title, $dest_path, $description);
                
                if ($stmt->execute()) {
                    echo "The image was added to the gallery successfully.";
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
        echo "No file was uploaded or there was an upload error.";
    }
}

// Close the database connection
$conn->close();
?>
<div class="container">
  <div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold mb-3">Add Gallery Item</h3>
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
          <a href="#">Add Gallery Item</a>
        </li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Upload Gallery Item Details</div>
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
                      placeholder="Enter Image Title"
                      required
                    />
                  </div>
                  <div class="form-group">
                    <label for="image">Gallery Image</label>
                    <input
                      type="file"
                      class="form-control"
                      id="image"
                      name="image"
                      accept="image/*"
                      required
                    />
                    <small class="form-text text-muted">
                      Upload an image for the gallery.
                    </small>
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
                    ></textarea>
                  </div>
                </div>
              </div>
              <div class="card-action">
                <button type="submit" class="btn btn-success">Submit</button>
                <button type="reset" class="btn btn-danger">Reset</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include('includes/footer.php'); ?>
