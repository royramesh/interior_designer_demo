<?php
require '../backend/db_connect.php'; // Adjust the path as needed
require '../backend/check_login.php'; // Ensure the user is logged in

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Fetch the existing details of the team member
    $sql = "SELECT * FROM team_members WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
        } else {
            echo "Team member not found.";
            exit;
        }
        $stmt->close();
    } else {
        echo "Error preparing SQL statement: " . $conn->error;
        exit;
    }
} else {
    echo "No ID provided.";
    exit;
}

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
            // Update record with the new photo path
            $photoPath = $dest_path;
        } else {
            echo "There was an error moving the uploaded file.";
            exit;
        }
    } else {
        // If no new photo is uploaded, use the existing photo path
        $photoPath = $row['photo_path'];
    }

    // Prepare SQL query to update the record in the database
    $sql = "UPDATE team_members SET name = ?, photo_path = ?, email = ?, contact_number = ?, position = ?, date_of_birth = ?, date_of_join = ? WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('sssssssi', $name, $photoPath, $email, $contactNumber, $position, $dateOfBirth, $dateOfJoin, $id);
        
        if ($stmt->execute()) {
            echo "Team member updated successfully.";
            header("Location: ad_team.php");
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
<?php include('includes/header.php'); ?>
<div class="container">
  <div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold mb-3">Edit Team Member</h3>
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
          <a href="#">Edit Team Member</a>
        </li>
      </ul>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Edit Team Member Details</div>
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
                      value="<?php echo htmlspecialchars($row['name']); ?>"
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
                    />
                    <small class="form-text text-muted">
                      Upload a new photo or leave it unchanged.
                    </small>
                    <?php if ($row['photo_path']): ?>
                      <img src="<?php echo htmlspecialchars($row['photo_path']); ?>" alt="Current Photo" style="width: 100px; height: auto;">
                    <?php endif; ?>
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input
                      type="email"
                      class="form-control"
                      id="email"
                      name="email"
                      value="<?php echo htmlspecialchars($row['email']); ?>"
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
                      value="<?php echo htmlspecialchars($row['contact_number']); ?>"
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
                      value="<?php echo htmlspecialchars($row['position']); ?>"
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
                      value="<?php echo htmlspecialchars($row['date_of_birth']); ?>"
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
                      value="<?php echo htmlspecialchars($row['date_of_join']); ?>"
                      required
                    />
                  </div>
                </div>
              </div>
              <div class="card-action">
                <button type="submit" class="btn btn-success">Update</button>
                <a href="team_member_list.php" class="btn btn-secondary">Cancel</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include('includes/footer.php'); ?>
