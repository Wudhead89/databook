<?php
/*
  Document   : index.php
  Created on : 05-May-2011
  Author     : Richard Williamson
 */
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['name'])) {
    header("location:home.php");
}
else {
    header("location:userlogin.php");
}
?>