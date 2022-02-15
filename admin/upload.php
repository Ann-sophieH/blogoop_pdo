<?php
include("includes/header.php");
include("includes/sidebar.php");
include("includes/content-top.php");
?>
<?php
/**CODE VOOR HET FORMULIER**/
if(!$session->is_signed_in()){//testen of er een user ingelogd is (is er een session)
   redirect('login2.php');
}
/**vanaf hier code formulier*/

/**ophalen categories**/
$categories = Category::find_all();

$message ="";
$photo = new Photo();
if(isset($_POST['submit'])){
    global $database;
    $photo->title = $_POST['title'];
    $photo->alternate_text = $_POST['alternate_text'];
    $photo->description = $_POST['description'];
    $photo->set_file($_FILES['file']);

    if($photo->save()){
        $message = "Photo uploaded succesfully";
    }else{
        $message = join("<br>", $photo->errors);
    }
        $categoryArray = $_POST['myCategories'];
   // $photoId= $database->the_insert_id();
    Photo::attachCategories($photo->id, $categoryArray);

}
?>
<div class="row">
    <div class="col-12">

        <form class="shadow-lg bg-white rounded" action="upload.php" method="post" enctype="multipart/form-data">
            <div class="bg-primary rounded-top text-white-50 p-3">Upload Photo</div>
            <div class="p-3">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control">
                </div>
                <div class="form-group">
                    <label for="alternate_text">Alt</label>
                    <input type="text" name="alternate_text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="description">Categories Choose... (CTRL+click)</label>
                    <select name="myCategories[]" class="custom-select" id="category" multiple>
                        <?php foreach($categories as $category): ?>
                            <option value="<?php echo $category->id; ?>"><?php echo $category->name;
                                ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">

                    <input type="file" name="file" id="inputGroupFile02">


                </div>

                <input type="submit" name="submit" value="upload" class="btn btn-primary">
            </div>

        </form>
    </div>
</div>
<?php
include("includes/footer.php");
?>
