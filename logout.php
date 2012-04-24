<?php
/* 
 * Document     : logout.php
 * Created on   : 05-May-2011
 * Author       : Richard Williamson
 * 
 * Description  : Simple user logout script, kills the session & redirects to userlogin.php
*/

// kill the session
session_start();
session_destroy();

// redirect to the login page
header("location:userlogin.php");

?>
