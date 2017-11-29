<?php
/**
 * Created by PhpStorm.
 * User: king
 * Date: 20/11/2017
 * Time: 23:54
 */

$con = mysqli_connect("localhost","root","root","online_farmer");
// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

?>
