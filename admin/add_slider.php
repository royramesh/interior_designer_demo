<?php
require '../backend/db_connect.php'; // Adjust the path as needed
require '../backend/check_login.php'; // Ensure the user is logged in

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and process form inputs
    $sliderText = $_POST['sliderText'];
    $imageAltText = $_POST['imageAltText'];
    
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
            // Prepare SQL query to insert form data into the database
            $sql = "INSERT INTO slider (text, image_path, alt_text) VALUES (?, ?, ?)";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param('sss', $sliderText, $dest_path, $imageAltText);
                
                if ($stmt->execute()) {
                    echo "The file was uploaded and data was saved successfully.";
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
<?php include('includes/header.php'); ?>
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
          <a href="#">Slider Upload Form</a>
        </li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Upload Slider Text and Image</div>
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
                      required
                    />
                    <small class="form-text text-muted">
                      Upload an image file for the slider.
                    </small>
                  </div>
                  <div class="form-group">
                    <label for="imageAltText">Image Alt Text</label>
                    <input
                      type="text"
                      class="form-control"
                      id="imageAltText"
                      name="imageAltText"
                      placeholder="Enter Image Alt Text"
                      required
                    />
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
