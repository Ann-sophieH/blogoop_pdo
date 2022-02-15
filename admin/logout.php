<?php
    require_once("includes/header.php");
    $session->logout();
    redirect('login2.php');
?>