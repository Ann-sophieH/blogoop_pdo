<?php
include("includes/header.php");
require_once("admin/includes/init.php");

$photos = Photo::find_all();


?>
<!-- Page content-->
<div class="row">
    <?php foreach($photos as $photo): ?>
    <div class="col-12 col-lg-3 mb-2">
        <div class="card h-100  img-thumbnail">

            <!-- Product image-->
            <img class="card-img-top img-fluid" src="<?php echo 'admin'.DS.$photo->picture_path(); ?>"
                 alt=".
            ..">
            <!-- Product details-->
            <div class="card-body p-4">
                <div class="text-center">
                    <!-- Product name-->
                    <h5 class="fw-bolder"><?php echo strtoupper($photo->title); ?></h5>
                    <!-- Product price-->
                    <span class="text-muted"><?php echo $photo->description; ?></span>

                </div>
            </div>
            <!-- Product actions-->
            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="<?php echo 'photo.php?id=' .
                        $photo->id ?>">Bekijken</a></div>
            </div>
            <?php
            $attachedCategories= $photo->attachedCategories($photo->id);?>
            <div class="d-flex justify-content-center">
            <?php
            foreach($attachedCategories as $category): ?>

                    <a class="badge bg-primary text-white mx-1 text-decoration-none"
                       href="#!">
                        <?php
                        echo $category;
                        ?>
                    </a>


            <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php include("includes/footer.php"); ?>

