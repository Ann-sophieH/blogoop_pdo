<?php
include("includes/header.php");

if (!$session->is_signed_in()) {//testen of er een comment ingelogd is (is er een session)
    redirect('login2.php');
}

$comments = Comment::find_all();

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
                <h4 class="card-title">All Contacts</h4>




            </div>


                    <table id="example" class="display" style="width:100%"
                           role="grid" aria-describedby="file_export_info">
                        <thead>
                        <tr role="row">
                            <th scope="col">#</th>
                            <th scope="col">Author</th>
                            <th scope="col">Body</th>
                            <th scope="col">Actions</th>
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


<?php

include("includes/footer.php");
?>
