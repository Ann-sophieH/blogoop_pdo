<?php
include("includes/header.php");
if(!$session->is_signed_in()){//testen of er een user ingelogd is (is er een session)
    redirect('login2.php');
}//controle ingelogde user
if(empty($_GET['id'])){
    redirect('categories.php');
}// controle of er een id aanwezig is als parameter in de url van de pagina.
//indien leeg, niets doen en redirecten naar users.php

$category = Category::find_by_id($_GET['id']);//ophalen van de juiste user uit de database.
if(isset($_POST['update_category'])){
    if($category){
        $category->name= $_POST['category'];
        $category->save();
        redirect('categories.php');
    }
}


include("includes/sidebar.php");
include("includes/content-top.php");
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1>ADD USER</h1>
            <form action="edit_category.php?id=<?php echo $category->id; ?>" method="post"
                  enctype="multipart/form-data">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="username">Name:</label>
                                <input type="text" name="category" class="form-control" value="<?php echo
                                $category->name; ?>">
                            </div>
                            <input type="submit" name="update_category" value="Update Category" class="btn btn-primary">
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>


<?php

include("includes/footer.php");
?>
