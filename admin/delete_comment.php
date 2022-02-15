<?php include("includes/header.php"); ?>
<?php
if(!$session->is_signed_in()){//testen of er een user ingelogd is (is er een session)
    redirect('login2.php');
}
if(empty($_GET['id'])){
    redirect('comments.php');
}
$comment = Comment::find_by_id($_GET['id']);
if($comment){
    $comment->delete();
    redirect("comments_photo.php?id={$comment->photo_id}");
}else{
    redirect("comments_photo.php?id={$comment->photo_id}");
}

?>
<?php
include("includes/sidebar.php");
include("includes/content-top.php");?>
<h1>DELETE Comment</h1>
<?php include("includes/footer.php"); ?>
