<?php include('includes/header.php'); ?>
<?php require 'backend/db_connect.php'; ?>
    <main>
        <!--? Hero Start -->
        <div class="slider-area2">
            <div class="slider-height2 hero-overly d-flex align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="hero-cap hero-cap2 text-center pt-80">
                                <h2>Our Portfolio</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
        <!-- Hero End -->
        <!--? Gallery Area Start -->
        <div class="gallery-area pt-30 pb-40">
            <div class="container-fluid p-0 fix">
                <div class="row">
                <?php 
            $sql4 = "SELECT * FROM 	gallery";
            $result4 = $conn->query($sql4);
            while($row4 = $result4->fetch_assoc()) { ?>
                <div class="col-xl-6 col-lg-4 col-md-6">
                    <div class="single-gallery mb-30">
                        <div class="gallery-img" style="background-image: url(<?php echo 'admin/' . htmlspecialchars($row4['image_path'], ENT_QUOTES, 'UTF-8'); ?>);"></div>
                        <div class="thumb-content-box">
                            <div class="thumb-content">
                                <h3><span><?php echo htmlspecialchars($row4['title'], ENT_QUOTES, 'UTF-8'); ?></span><?php echo htmlspecialchars($row4['description'], ENT_QUOTES, 'UTF-8'); ?></h3>
                                <a href="work"><i class="fas fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }?>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="lode-more-btn text-center pt-60 pb-100">
                            <a href="#" class="btn">Load More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Gallery Area End -->
    </main>
    <?php include('includes/footer.php');  ?>