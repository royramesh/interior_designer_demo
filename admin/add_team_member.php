<?php include('includes/header.php'); ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and process form inputs
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contactNumber = $_POST['contactNumber'];
    $position = $_POST['position'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $dateOfJoin = $_POST['dateOfJoin'];
    
    // File upload processing
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['photo']['tmp_name'];
        $fileName = $_FILES['photo']['name'];
        $fileSize = $_FILES['photo']['size'];
        $fileType = $_FILES['photo']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        
        // New file name with a unique identifier
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        
        // Directory where the file will be stored
        $uploadFileDir = 'uploads/team/';
        $dest_path = $uploadFileDir . $newFileName;
        
        // Move the file from temporary directory to the target directory
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            // Prepare SQL query to insert form data into the database
            $sql = "INSERT INTO team_members (name, photo_path, email, contact_number, position, date_of_birth, date_of_join) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param('sssssss', $name, $dest_path, $email, $contactNumber, $position, $dateOfBirth, $dateOfJoin);
                
                if ($stmt->execute()) {
                    echo "The team member was added successfully.";
                    header("Location: ad_team.php");
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
          <a href="#">Team Member Upload Form</a>
        </li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Upload Team Member Details</div>
          </div>
          <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-6 col-lg-4">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input
                      type="text"
                      class="form-control"
                      id="name"
                      name="name"
                      placeholder="Enter Name"
                      required
                    />
                  </div>
                  <div class="form-group">
                    <label for="photo">Photo</label>
                    <input
                      type="file"
                      class="form-control"
                      id="photo"
                      name="photo"
                      accept="image/*"
                      required
                    />
                    <small class="form-text text-muted">
                      Upload a photo of the team member.
                    </small>
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input
                      type="email"
                      class="form-control"
                      id="email"
                      name="email"
                      placeholder="Enter Email"
                      required
                    />
                  </div>
                  <div class="form-group">
                    <label for="contactNumber">Contact Number</label>
                    <input
                      type="text"
                      class="form-control"
                      id="contactNumber"
                      name="contactNumber"
                      placeholder="Enter Contact Number"
                      required
                    />
                  </div>
                  <div class="form-group">
                    <label for="position">Position</label>
                    <input
                      type="text"
                      class="form-control"
                      id="position"
                      name="position"
                      placeholder="Enter Position"
                      required
                    />
                  </div>
                  <div class="form-group">
                    <label for="dateOfBirth">Date of Birth</label>
                    <input
                      type="date"
                      class="form-control"
                      id="dateOfBirth"
                      name="dateOfBirth"
                      required
                    />
                  </div>
                  <div class="form-group">
                    <label for="dateOfJoin">Date of Join</label>
                    <input
                      type="date"
                      class="form-control"
                      id="dateOfJoin"
                      name="dateOfJoin"
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
