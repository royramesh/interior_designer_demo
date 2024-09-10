<?php
include('includes/header.php'); 

// Check if the service ID is provided
if (!isset($_GET['id'])) {
    die("Service ID not provided.");
}

$id = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $para1 = $_POST['para1'];
    $para2 = $_POST['para2'];

    // File upload processing
    $dest_path = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $uploadFileDir = 'uploads/services/';
        $dest_path = $uploadFileDir . $newFileName;

        if (!move_uploaded_file($fileTmpPath, $dest_path)) {
            echo "There was an error moving the uploaded file.";
        }
    }

    if ($dest_path) {
        // Update with new image
        $sql = "UPDATE services SET name = ?, image_path = ?, para1 = ?, para2 = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssi', $name, $dest_path, $para1, $para2, $id);
    } else {
        // Update without changing the image
        $sql = "UPDATE services SET name = ?, para1 = ?, para2 = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssi', $name, $para1, $para2, $id);
    }

    if ($stmt->execute()) {
        echo "The service was updated successfully.";
        header("Location: ad_services.php"); // Redirect to the service list page
    } else {
        echo "Database error: " . $stmt->error;
    }
    $stmt->close();
}

// Retrieve the existing service data
$sql = "SELECT * FROM services WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $service = $result->fetch_assoc();
} else {
    die("Service not found.");
}
$stmt->close();

// Close the database connection
$conn->close();
?>
<div class="container">
  <div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold mb-3">Edit Service</h3>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Update Service Details</div>
          </div>
          <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
              <input type="hidden" name="id" value="<?php echo htmlspecialchars($service['id']); ?>">
              <div class="form-group">
                <label for="name">Service Name</label>
                <input
                  type="text"
                  class="form-control"
                  id="name"
                  name="name"
                  value="<?php echo htmlspecialchars($service['name']); ?>"
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
                />
                <?php if ($service['image_path']): ?>
                  <small class="form-text text-muted">
                    Current Image: <img src="<?php echo htmlspecialchars($service['image_path']); ?>" alt="Service Image" style="width:100px;">
                  </small>
                <?php endif; ?>
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
                ><?php echo htmlspecialchars($service['para1']); ?></textarea>
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
                ><?php echo htmlspecialchars($service['para2']); ?></textarea>
              </div>
              <div class="card-action">
                <button type="submit" class="btn btn-success">Update</button>
                <a href="ad_services.php" class="btn btn-danger">Cancel</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include('includes/footer.php'); ?>
