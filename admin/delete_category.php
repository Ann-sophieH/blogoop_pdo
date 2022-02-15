<?php include("includes/header.php"); ?>
<?php
if(!$session->is_signed_in()){//testen of er een user ingelogd is (is er een session)
    redirect('login2.php');
}
if(empty($_GET['id'])){
    redirect('categories.php');
}
$category = Category::find_by_id($_GET['id']);
if($category){
    $category->delete();
    redirect('categories.php');
}else{
    redirect('categories.php');
}

?>
<?php
include("includes/sidebar.php");
include("includes/content-top.php");?>
<h1>DELETE CATEGORY</h1>
<?php include("includes/footer.php"); ?>
