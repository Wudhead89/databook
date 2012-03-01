<?php
/*
  Document   : deletestudent.php
  Created on : 01-Mar-2012
  Author     : Richard Williamson
 */
include('../../config.php');

$studentid = $_GET["studentid"];

$deletesql = "DELETE from students WHERE studentid = '$studentid'";
$response = mysql_query($deletesql);

if ($response){
    echo "Student deleted from table 'students'<br />";
}
else {
    echo "Delete from 'students' FAILED!<br />";
}

$deletesql = "DELETE from results WHERE studentid = '$studentid'";
$response = mysql_query($deletesql);

if ($response){
    echo "Student deleted from table 'results'<br />";
}
else {
    echo "Delete from 'results' FAILED!<br />";
}


$deletesql = "DELETE from tchgroups WHERE studentid = '$studentid'";
$response = mysql_query($deletesql);

if ($response){
    echo "Student deleted from table 'tchgroups'<br />";
}
else {
    echo "Delete from 'tchgroups' FAILED!<br />";
}


?>
