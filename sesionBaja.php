<?php
    session_start();

    if ($_SESSION['id'] != ""){
        session_destroy();
        session_write_close();
        $_SESSION = array();
    }
    header("location: login.php");  
    die();
?>