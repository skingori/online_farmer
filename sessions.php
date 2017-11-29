<?php
/**
 * Created by PhpStorm.
 * User: king
 * Date: 21/11/2017
 * Time: 00:19
 */
session_start();

// Check, if user is already login, then jump to secured page
if (isset($_SESSION['logname']) || $_SESSION['rank']) {
    switch($_SESSION['rank']) {
        case 1:
            header('location:admin/index.php');//redirect to client page
            break;
        case 2:
            header('location:user/index.php');//redirect to  page
            break;

        case 3:
            header('location:officer/index.php');//redirect to  page
            break;


    }
}elseif(!isset($_SESSION['logname']) || $_SESSION['rank']) {
    header('Location:index.php');
}
else
{

    header('Location:index.php');
}

?>
