<?php
include("includes/header.php");

if (!$session->is_signed_in()) {//testen of er een comment ingelogd is (is er een session)
    redirect('login2.php');
}

if(empty($_GET['id'])){
    redirect("photos.php");
}

$comments = Comment::find_the_comment($_GET['id']);


include("includes/sidebar.php");
include("includes/content-top.php");
?>


<div class="col-12 px-0">
    <div class="card">
        <div class="card-body">
            <?php if($session->message): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $session->message;?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            <div class="d-flex no-block align-items-center mb-4">
                <h4 class="card-title">POSTED COMMENTS FOR THIS POST</h4>




            </div>
            <div class="table">
                <div id="file_export_wrapper" class="container-fluid">
                    <div>
                        <button class="btn btn-primary mr-1" tabindex="0"
                                aria-controls="file_export"><span>Copy</span></button>
                        <button class="btn btn-primary mr-1" tabindex="0"
                                aria-controls="file_export"><span>CSV</span></button>
                        <button class="btn btn-primary mr-1" tabindex="0"
                                aria-controls="file_export"><span>Excel</span></button>
                        <button class="btn btn-primary mr-1" tabindex="0"
                                aria-controls="file_export"><span>PDF</span></button>
                        <button class="btn btn-primary mr-1" tabindex="0"
                                aria-controls="file_export"><span>Print</span></button>
                    </div>
                    <div id="file_export_filter"><label>Search:<input type="search"
                                                                      class="form-control mb-2 form-control-sm"
                                                                      placeholder=""
                                                                      aria-controls="file_export"></label>
                    </div>
                    <table id="file_export" class="table table-bordered nowrap display dataTable no-footer"
                           role="grid" aria-describedby="file_export_info">
                        <thead>
                        <tr role="row">
                            <th scope="col">#</th>
                            <th scope="col">Author</th>
                            <th scope="col">Body</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($comments as $comment): ?>
                            <tr role="row">

                                <td>
                                    <?php echo $comment->id; ?>
                                </td>
                                <td><?php echo $comment->author; ?></td>
                                <td><?php echo $comment->body; ?></td>
                                <td><a href="delete_comment.php?id=<?php echo $comment->id; ?>" class="btn btn-danger"><i class="far fa-trash-alt"></i></a>
                                   </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>


<?php

include("includes/footer.php");
?>
