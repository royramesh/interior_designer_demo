
<?php include('includes/header.php');  ?>
<?php
// Fetch team member data from the database
$sql = "SELECT * FROM team_members";
$result = $conn->query($sql);
?>
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Team Members</h3>
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
                    <a href="#">Team Members</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Team Member Management</h4>
                            <a href="add_team_member.php" style="position:absolute; right:0 !important;">
                                <button class="btn btn-primary btn-round ms-auto">
                                    <i class="fa fa-plus"></i>
                                    Add Team Member
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="add-row" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Photo</th>
                                        <th>Email</th>
                                        <th>Contact Number</th>
                                        <th>Position</th>
                                        <th>Date of Birth</th>
                                        <th>Date of Join</th>
                                        <th style="width: 10%">Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Photo</th>
                                        <th>Email</th>
                                        <th>Contact Number</th>
                                        <th>Position</th>
                                        <th>Date of Birth</th>
                                        <th>Date of Join</th>
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
                                            echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                                            echo '<td><img src="' . htmlspecialchars($row['photo_path']) . '" alt="' . htmlspecialchars($row['name']) . '" style="width: 100px; height: auto;"></td>';
                                            echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['contact_number']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['position']) . '</td>';
                                            echo '<td>' . htmlspecialchars(date('d-m-Y', strtotime($row['date_of_birth']))) . '</td>';
                                            echo '<td>' . htmlspecialchars(date('d-m-Y', strtotime($row['date_of_join']))) . '</td>';
                                            echo '<td>
                                                      <div class="form-button-action">
                                                          <a href="edit_team_member.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-link btn-primary btn-lg" data-bs-toggle="tooltip" title="Edit Team Member">
                                                              <i class="fa fa-edit"></i>
                                                          </a>
                                                          <a href="delete_team_member.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-link btn-danger" data-bs-toggle="tooltip" title="Remove Team Member" onclick="return confirm(\'Are you sure you want to delete this team member?\');">
                                                              <i class="fa fa-times"></i>
                                                          </a>
                                                      </div>
                                                  </td>';
                                            echo '</tr>';
                                        }
                                    } else {
                                        echo '<tr><td colspan="8">No data available</td></tr>';
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
