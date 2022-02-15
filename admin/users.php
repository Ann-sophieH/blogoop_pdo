<?php
include("includes/header.php");

if (!$session->is_signed_in()) {//testen of er een user ingelogd is (is er een session)
    redirect('login2.php');
}

$users = User::find_all();

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



                <div class="ml-auto">
                    <div class="btn-group">
                        <a href="add_user.php" class="
                            btn btn-primary
                            text-white
                            font-weight-medium
                            rounded-pill
                            px-4"><i class="fas fa-user-plus"></i>
                            Create New Contact
                        </a>
                    </div>
                </div>
            </div>


                    <table id="example" class="display" style="width:100%"
                           role="grid" aria-describedby="file_export_info">
                        <thead>
                        <tr role="row">
                            <th scope="col">#</th>
                            <th scope="col">Naam</th>
                            <th scope="col">Username</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Tel</th>
                            <th scope="col">Function</th>
                            <th scope="col">Started</th>
                            <th scope="col">Salary</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr role="row">
                                <td class="sorting_1">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                               id="customControlValidation2" required="">
                                        <label class="form-check-label" for="customControlValidation2"></label>
                                    </div>
                                </td>
                                <td>
                                    <img width="60" height="60" src="<?php echo $user->image_path_and_placeholder(); ?>" alt="user" class="rounded-circle img-fluid img-thumbnail">
                                    <span class="fw-normal"><?php echo $user->first_name . ' ' . $user->last_name; ?></span>
                                </td>
                                <td><?php echo $user->username; ?></td>
                                <td><a href="mailto:lorem@ipsum.be"></a>lorem@ipsum.be</td>
                                <td><a href="tel:123456789"></a>+123 456 789</td>
                                <td><span class="badge rounded-pill bg-success text-white">Developer</span>
                                </td>
                                <td>12-10-2014</td>
                                <td>$1200</td>
                                <td><a href="delete_user.php?id=<?php echo $user->id; ?>" class="btn btn-danger"><i class="far fa-trash-alt"></i></a>
                               <a href="edit_user.php?id=<?php echo $user->id; ?>" class="btn btn-warning"><i class="far fa-edit"></i></a></td>
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
