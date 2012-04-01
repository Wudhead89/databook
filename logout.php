<?php
/* 
    Document   : logout.php
    Created on : 05-May-2011
    Author     : Richard Williamson
*/

// kill the session
session_start();
session_destroy();

// redirect to the index page
header("location:userlogin.php");

?>
