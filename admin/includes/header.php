<?php
require '../backend/db_connect.php'; 
require '../backend/check_login.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Admin Dashboard</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <!-- <link
      rel="icon"
      href="assets/img/kaiadmin/favicon.ico"
      type="image/x-icon"
    /> -->

    <!-- Fonts and icons -->
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["assets/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/plugins.min.css" />
    <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="assets/css/demo.css" />
  </head>
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="index" class="logo">
              <!-- <img
                src="assets/img/kaiadmin/logo_light.svg"
                alt="navbar brand"
                class="navbar-brand"
                height="20"
              /> -->
              <h3 class="text-white">Admin Dashboard</h3>
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <?php
// Determine the current page URL or filename
$current_page = basename($_SERVER['REQUEST_URI'], ".php");
?>
<div class="sidebar-wrapper scrollbar scrollbar-inner">
  <div class="sidebar-content">
    <ul class="nav nav-secondary">
      <li class="nav-item <?php echo $current_page === 'index' ? 'active' : ''; ?>">
        <a href="index">
          <i class="fas fa-home"></i>
          <p>Dashboard</p>
        </a>
      </li>
      <li class="nav-item <?php echo $current_page === 'ad_slider' ? 'active' : ''; ?>">
        <a href="ad_slider">
          <i class="fas fa-sliders-h"></i>
          <p>Slider</p>
        </a>
      </li>
      <li class="nav-item <?php echo $current_page === 'ad_team' ? 'active' : ''; ?>">
        <a href="ad_team">
          <i class="fas fa-users"></i>
          <p>Team</p>
        </a>
      </li>
      <li class="nav-item <?php echo $current_page === 'ad_services' ? 'active' : ''; ?>">
        <a href="ad_services">
          <i class="fas fa-concierge-bell"></i>
          <p>Services</p>
        </a>
      </li>
      <li class="nav-item <?php echo $current_page === 'ad_gallery' ? 'active' : ''; ?>">
        <a href="ad_gallery">
          <i class="fas fa-images"></i>
          <p>Gallery</p>
        </a>
      </li>
    </ul>
  </div>
</div>

      </div>
      <!-- End Sidebar -->

      <div class="main-panel">
        <div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
              <a href="index" class="logo">
                <!-- <img
                  src="assets/img/kaiadmin/logo_light.svg"
                  alt="navbar brand"
                  class="navbar-brand"
                  height="20"
                /> -->
                <h3 class="text-white">Admin Dashboard</h3>
              </a>
              <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                  <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                  <i class="gg-menu-left"></i>
                </button>
              </div>
              <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
              </button>
            </div>
            <!-- End Logo Header -->
          </div>
         <!-- Navbar Header -->
<nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
  <div class="container-fluid">
    <ul class="navbar-nav ms-md-auto align-items-center">
      <!-- User Dropdown -->
      <li class="nav-item topbar-user dropdown hidden-caret">
        <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
          <div class="avatar-sm">
            <img src="assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle" />
          </div>
          <span class="profile-username">
            <span class="op-7">Hi,</span>
            <span class="fw-bold"><?php $email = $_SESSION['email'];
    echo htmlspecialchars($email);?></span>
          </span>
        </a>
        <ul class="dropdown-menu dropdown-user animated fadeIn">
          <div class="dropdown-user-scroll scrollbar-outer">
            <li>
              <div class="user-box">
                <div class="avatar-lg">
                  <img src="assets/img/profile.jpg" alt="image profile" class="avatar-img rounded" />
                </div>
                <div class="u-text">
                  <h4><?php $userEmail = $_SESSION['email'];
    echo htmlspecialchars($userEmail);?></h4>
                  <!-- <p class="text-muted">hello@example.com</p> -->
                </div>
              </div>
            </li>
            <li>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="edit_admin">
                <i class="fas fa-user-edit"></i> Update Details
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="logout">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </li>
          </div>
        </ul>
      </li>
    </ul>
  </div>
</nav>
<!-- End Navbar -->

        </div>