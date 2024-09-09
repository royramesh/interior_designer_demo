<?php
require '../backend/db_connect.php'; // Adjust the path as needed
require '../backend/check_login.php'; // Ensure the user is logged in

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and process form inputs
    $name = $_POST['name'];
    $para1 = $_POST['para1'];
    $para2 = $_POST['para2'];

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
        $uploadFileDir = 'uploads/services/';
        $dest_path = $uploadFileDir . $newFileName;
        
        // Move the file from temporary directory to the target directory
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            // Prepare SQL query to insert form data into the database
            $sql = "INSERT INTO services (name, image_path, para1, para2) VALUES (?, ?, ?, ?)";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param('ssss', $name, $dest_path, $para1, $para2);
                
                if ($stmt->execute()) {
                    echo "The service was added successfully.";
                    header("Location: ad_services.php");
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
      <h3 class="fw-bold mb-3">Add Service</h3>
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
          <a href="#">Add Service</a>
        </li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Upload Service Details</div>
          </div>
          <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-6 col-lg-4">
                  <div class="form-group">
                    <label for="name">Service Name</label>
                    <input
                      type="text"
                      class="form-control"
                      id="name"
                      name="name"
                      placeholder="Enter Service Name"
                      required
                    />
                  </div>
                  <div class="form-group">
                    <label for="image">Service Image</label>
                    <input
                      type="file"
                      class="form-control"
                      id="image"
                      name="image"
                      accept="image/*"
                      required
                    />
                    <small class="form-text text-muted">
                      Upload an image for the service.
                    </small>
                  </div>
                  <div class="form-group">
                    <label for="para1">Service Paragraph 1</label>
                    <textarea
                      class="form-control"
                      id="para1"
                      name="para1"
                      rows="4"
                      placeholder="Enter Service Paragraph 1"
                      required
                    ></textarea>
                  </div>
                  <div class="form-group">
                    <label for="para2">Service Paragraph 2</label>
                    <textarea
                      class="form-control"
                      id="para2"
                      name="para2"
                      rows="4"
                      placeholder="Enter Service Paragraph 2"
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
