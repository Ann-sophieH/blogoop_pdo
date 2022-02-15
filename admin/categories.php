<?php
include("includes/header.php");
if (!$session->is_signed_in()) {//testen of er een categorie ingelogd is (is er een session)
    redirect('login2.php');
}
$categories = Category::find_all();
$newCategory = new Category();
if (isset($_POST['addCategory'])) {
    $newCategory->name = trim($_POST['category']);
    $session->message("The Category {$newCategory->name} has been added");
    $newCategory->save();
    redirect('categories.php');
}
include("includes/sidebar.php");
include("includes/content-top.php");
?>
<div class="row">
    <div class="col-12">
        <?php if ($session->message): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $session->message; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <h1>All Categories</h1>

        <form action="categories.php" method="post" enctype="multipart/form-data">
            <div class="form-row mb-3">
                <div class="col-11">
                    <input name="category" type="text" class="form-control mr-1" placeholder="Category toevoegen...">
                </div>
                <div class="col">
                    <button name="addCategory" class="btn btn-outline-primary" type="submit">Add Category
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>
<div class="row">
    <div class="col-12">
        <table id="file_export" class="table table-bordered nowrap display dataTable no-footer"
               role="grid" aria-describedby="file_export_info">
            <thead>
            <tr role="row">
                <th scope="col">#</th>
                <th scope="col">Name</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($categories as $category): ?>
                <tr role="row">
                    <td><?php echo $category->id; ?></td>
                    <td><?php echo $category->name; ?></td>
                    <td><a href="delete_category.php?id=<?php echo $category->id; ?>" class="btn btn-danger"><i
                                    class="far fa-trash-alt"></i></a>
                        <a href="edit_category.php?id=<?php echo $category->id; ?>" class="btn btn-warning"><i
                                    class="far fa-edit"></i></a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<?php
include("includes/footer.php");
?>
