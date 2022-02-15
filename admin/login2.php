<?php
    require_once("includes/header.php");
    $the_message = "";
    $errorView="";

    if($session->is_signed_in()){
        redirect("index.php");
    }
    if(isset($_POST['submit'])){
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $user_found = User::verify_user($username,$password);
        if($user_found)
        {
            $session->login($user_found);
            redirect("index.php");
        }else
        {
            $the_message = "your password or username FAILED!";
        }
    }
    else{
        $username="";
        $password="";
    }
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 offset-lg-3">

                <?php
                if($the_message){
                    $errorView = "<div class='alert alert-danger' role='alert'>" . $the_message . "</div>";
                    echo $errorView;
                }
                ?>

            <form action="" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" value="<?php echo htmlentities($username); ?>">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" value="<?php echo htmlentities($password); ?>">
                </div>
                <div class="form-group">
                    <input type="submit" value="Submit" name="submit" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>
