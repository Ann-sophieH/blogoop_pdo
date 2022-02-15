<?php
include("includes/header.php");

if(!$session->is_signed_in()){//testen of er een user ingelogd is (is er een session)
    redirect('login2.php');
}
$user = new User();
if(isset($_POST['add_user'])){
    $user->username = trim($_POST['username']);
    $user->first_name = $_POST['first_name'];
    $user->password = $_POST['password'];
    $user->last_name = $_POST['last_name'];
    $user->set_file($_FILES['user_image']);
    $session->message("The User {$user->username} has been added");
    $user->save_user_and_image();
    redirect('users.php');
}
include("includes/sidebar.php");
include("includes/content-top.php");
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1>ADD USER</h1>
            <form action="add_user.php" method="post" enctype="multipart/form-data">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" name="first_name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" name="last_name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="user_image">File</label>
                                <input type="file" name="user_image" class="form-control">
                            </div>
                            <input type="submit" name="add_user" value="Add User" class="btn btn-primary">
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>


<?php

include("includes/footer.php");
?>
