<?php
/*
  Document   : updatestudetails.php
  Created on : 01-Mar-2012
  Author     : Richard Williamson
 */
include('../../config.php');

$studentid = $_GET["studentid"];
$form = $_GET['form'];
$fsm = $_GET['fsm'];
$sen = $_GET['sen'];

$insertsql = "UPDATE students SET form = '$form', fsm = '$fsm', sen = '$sen' WHERE studentid = $studentid";

$response = mysql_query($insertsql);

if ($response){
    echo "<p>Update Successful!</p>";
}
else {
    echo "<p>Update Failed!</p>";
}
echo $insertsql;

?>