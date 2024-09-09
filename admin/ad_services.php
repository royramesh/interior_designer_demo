<?php
require '../backend/db_connect.php'; 
require '../backend/check_login.php';
?>
<?php include('includes/header.php');  ?>
<?php
// Fetch service data from the database
$sql = "SELECT * FROM services";
$result = $conn->query($sql);
?>
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Services</h3>
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
                    <a href="#">Tables</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Services</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Service Management</h4>
                            <a href="add_service.php" style="position:absolute; right:0 !important;">
                                <button class="btn btn-primary btn-round ms-auto">
                                    <i class="fa fa-plus"></i>
                                    Add Service
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="add-row" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Paragraph 1</th>
                                        <th>Paragraph 2</th>
                                        <th style="width: 10%">Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Paragraph 1</th>
                                        <th>Paragraph 2</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    // Check if there are results
                                    if ($result->num_rows > 0) {
                                        // Output data of each row
                                        while($row = $result->fetch_assoc()) {
                                            echo '<tr>';
                                            echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                                            echo '<td><img src="' . htmlspecialchars($row['image_path']) . '" alt="' . htmlspecialchars($row['name']) . '" style="width: 100px; height: auto;"></td>';
                                            echo '<td>' . htmlspecialchars($row['para1']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['para2']) . '</td>';
                                            echo '<td>
                                                      <div class="form-button-action">
                                                          <a href="edit_service.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-link btn-primary btn-lg" data-bs-toggle="tooltip" title="Edit Service">
                                                              <i class="fa fa-edit"></i>
                                                          </a>
                                                          <a href="delete_service.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-link btn-danger" data-bs-toggle="tooltip" title="Remove Service" onclick="return confirm(\'Are you sure you want to delete this service?\');">
                                                              <i class="fa fa-times"></i>
                                                          </a>
                                                      </div>
                                                  </td>';
                                            echo '</tr>';
                                        }
                                    } else {
                                        echo '<tr><td colspan="6">No data available</td></tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
// Close connection
$conn->close();
?>
<?php include('includes/footer.php');  ?>
