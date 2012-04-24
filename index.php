<?php
/*
 * Document     : index.php
 * Created on   : 05-May-2011
 * Author       : Richard Williamson
 * 
 * Description  : index page, simply redirects if user is logged in or not
 */
if (!isset($_SESSION)) {
    session_start();
}

// if the user is logged in goto home.php else go to the login page userlogin.php
if (isset($_SESSION['name'])) {
    header("location:home.php");
}
else {
    header("location:userlogin.php");
}
?>