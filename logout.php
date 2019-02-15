<?php session_start();; ?>

<?php

if($_SESSION['user']){
    
    unset($_SESSION);
    session_destroy();
    //die();
}

header("Location: login.php");




