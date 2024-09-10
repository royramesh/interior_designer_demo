
<?php include('includes/header.php');  ?>

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Dashboard</h3>
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
                    <a href="#">Dashboard</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Management Options</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap justify-content-center">
                            <a href="ad_slider" class="btn btn-primary btn-lg m-2">
                                <i class="fas fa-sliders-h"></i> Slider Management
                            </a>
                            <a href="ad_team" class="btn btn-primary btn-lg m-2">
                                <i class="fas fa-users"></i> Team Management
                            </a>
                            <a href="ad_services" class="btn btn-primary btn-lg m-2">
                                <i class="fas fa-concierge-bell"></i> Services Management
                            </a>
                            <a href="ad_gallery" class="btn btn-primary btn-lg m-2">
                                <i class="fas fa-images"></i> Gallery Management
                            </a>
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