<?php
include("includes/header.php");
require_once("admin/includes/init.php");
if(empty($_GET['id'])){
    redirect("index.php");
}
$photo = Photo::find_by_id($_GET['id']); //http://localhost/blogoop/photo.php?id=2
//Haal een bestaande primary key op uit photos.

$comments= Comment::find_the_comment($photo->id);//FOREIGN KEY IN THE COMMENTS TABLE!!!!

$categories = Category::find_all();
$filteredCategories = Photo::attachedCategories($_GET['id']);

if(isset($_POST['submit'])){
   $author = trim($_POST['author']);
   $body = trim($_POST['body']);

   $new_comment = Comment::create_comment($photo->id, $author, $body);

   if($new_comment && $new_comment->save()){
       redirect("photo.php?id={$photo->id}");
   }else{
       $message = "There are some problems saving!";
   }

}else{
    $author="";
    $body= "";

}

?>
<!-- Page content-->
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-8">
            <!-- Post content-->
            <article>
                <!-- Post header-->
                <header class="mb-4">
                    <!-- Post title-->
                    <h1 class="fw-bolder mb-1">Welcome to Blog Post!</h1>
                    <!-- Post meta content-->
                    <div class="text-muted fst-italic mb-2">Posted on January 1, 2021 by Start Bootstrap</div>
                    <!-- Post categories -->
                    <?php foreach($filteredCategories as $filteredCategory): ?>
                     <a class="badge bg-secondary text-decoration-none link-light" href="#!">
                         <?php
                         echo $filteredCategory;
                         ?>
                     </a>
                    <?php endforeach;?>

                </header>
                <!-- Preview image figure-->
                <figure class="mb-4"><img class="img-fluid rounded" src="<?php echo 'admin'.DS.$photo->picture_path(); ?>" alt="..." /></figure>
                <!-- Post content-->
                <section class="mb-5">
                 <p><?php echo $photo->description; ?></p>
                </section>
            </article>
            <!-- Comments section-->
            <section class="mb-5">
                <div class="card bg-light">
                    <div class="card-body">
                        <!-- Comment form-->
                        <form method="post" class="mb-4">
                            <div class="mb-3">
                                <label for="author" class="form-label">Author</label>
                                <input type="text" class="form-control" name="author" placeholder="Author name please...">
                            </div>
                            <textarea name="body" class="form-control mb-3" rows="3" placeholder="Join the discussion and leave a comment!"></textarea>
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </form>

                        <!-- Single comment-->
                        <?php foreach($comments as $comment): ?>
                        <div class="d-flex">
                            <div class="flex-shrink-0"><img class="rounded-circle" src="https://dummyimage.com/50x50/ced4da/6c757d.jpg" alt="..." /></div>
                            <div class="ms-3">
                                <div class="fw-bold"><?php echo $comment->author; ?></div>
                                <p><?php echo $comment->body; ?></p>
                            </div>
                        </div>
                        <?php endforeach;?>
                    </div>
                </div>
            </section>
        </div>
        <!-- Side widgets-->
        <div class="col-lg-4">
            <!-- Search widget-->
            <div class="card mb-4">
                <div class="card-header">Search</div>
                <div class="card-body">
                    <div class="input-group">
                        <input class="form-control" type="text" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search" />
                        <button class="btn btn-primary" id="button-search" type="button">Go!</button>
                    </div>
                </div>
            </div>
            <!-- Categories widget-->
            <div class="card mb-4">
                <div class="card-header">Categories</div>
                <div class="card-body">
                   <!-- <div class="row">
                        <div class="col-sm-6">
                            <ul class="list-unstyled mb-0">
                                <li><a href="#!">Web Design</a></li>
                                <li><a href="#!">HTML</a></li>
                                <li><a href="#!">Freebies</a></li>
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <ul class="list-unstyled mb-0">
                                <li><a href="#!">JavaScript</a></li>
                                <li><a href="#!">CSS</a></li>
                                <li><a href="#!">Tutorials</a></li>
                            </ul>
                        </div>
                    </div>-->

                        <div class="col-12">
                            <ul class="list-unstyled mb-0">
                                <?php foreach($categories as $category): ?>
                                <li><a href="#"><?php echo $category->name; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                </div>
            </div>
            <!-- Side widget-->
            <div class="card mb-4">
                <div class="card-header">Side Widget</div>
                <div class="card-body">You can put anything you want inside of these side widgets. They are easy to use, and feature the Bootstrap 5 card component!</div>
            </div>
        </div>
    </div>
</div>
<?php include("includes/footer.php"); ?>
