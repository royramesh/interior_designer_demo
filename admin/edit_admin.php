<?php
include('includes/header.php'); 

// Ensure the email variable is set
if (!isset($email)) {
    die("Email not provided.");
}

// Sanitize and validate the email
$email = filter_var($email, FILTER_SANITIZE_EMAIL);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email format.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newEmail = $_POST['email'];
    $password = $_POST['password'];

    // Input validation
    if (empty($newEmail)) {
        die("Email is required.");
    }
    $newEmail = filter_var($newEmail, FILTER_SANITIZE_EMAIL);
    if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Prepare SQL statement
    if (!empty($password)) {
        // Update with new plain text password
        $sql = "UPDATE admin SET email = ?, password = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $newEmail, $password, $email);
    } else {
        // Update without changing the password
        $sql = "UPDATE admin SET email = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $newEmail, $email);
    }

    if ($stmt->execute()) {
        // Successful update
        $stmt->close();
        $conn->close();
        header("Location: index.php"); // Ensure this path is correct
        exit();
    } else {
        echo "Database error: " . $stmt->error;
    }
}

// Retrieve the existing admin data
$sql = "SELECT * FROM admin WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $admin = $result->fetch_assoc();
} else {
    die("Admin not found.");
}
$stmt->close();

// Close the database connection
$conn->close();
?>
<div class="container">
  <div class="page-inner">
    <div class="page-header">
      <h3 class="fw-bold mb-3">Edit Admin Details</h3>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Update Admin Details</div>
          </div>
          <div class="card-body">
            <form action="" method="post">
              <input type="hidden" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>">
              <div class="form-group">
                <label for="email">Email</label>
                <input
                  type="email"
                  class="form-control"
                  id="email"
                  name="email"
                  value="<?php echo htmlspecialchars($admin['email']); ?>"
                  placeholder="Enter Email"
                  required
                />
              </div>
              <div class="form-group">
                <label for="password">Password (Leave blank if you don't want to change)</label>
                <input
                  type="password"
                  class="form-control"
                  id="password"
                  name="password"
                  placeholder="Enter New Password"
                />
              </div>
              <div class="card-action">
                <button type="submit" class="btn btn-success">Update</button>
                <a href="admin_list.php" class="btn btn-danger">Cancel</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include('includes/footer.php'); ?>
