<?php
include("includes/header.php");
include("includes/sidebar.php");
include("includes/content-top.php");


$image_path = IMAGES_PATH.DS.'anonymous-1.jpg';
echo $image_path;
$image = new Imagick($image_path); // $image_path is the path to the image location
$imageprops = $image->getImageGeometry();
$width = $imageprops['width'];
$height = $imageprops['height'];
if($width > $height){
    $newHeight = 800;
    $newWidth = (600 / $height) * $width;
}else{
    $newWidth = 600;
    $newHeight = (800 / $width) * $height;
}

$image->resizeImage(800,600,imagick::FILTER_LANCZOS,1);
$image->writeImage(IMAGES_PATH.DS.'anonymousresized.jpg');



include("includes/footer.php");
?>
