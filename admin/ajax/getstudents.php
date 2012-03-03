<?php
/*
  Document   : getstudents.php
  Created on : 29-Feb-2012
  Author     : Richard Williamson
 */

$form = $_GET["form"];

include('../../config.php');

$sqlstring = "SELECT * FROM students WHERE form = '$form' ORDER BY surname, forename";

$students = mysql_query($sqlstring);

while ($row = mysql_fetch_assoc($students)) {
    echo "<span class=\"editstudentline\">";
    echo $row['forename'] . " " . $row['surname'] . " ";
    echo "<img src=\"../images/icons/application_form_edit.png\" width=\"16\" height=\"16\" onclick=\"editStuGrades(" . $row['studentid'] . ")\" />";
    echo "<img src=\"../images/icons/bullet_go.png\" width=\"16\" height=\"16\" onclick=\"getStuDetails(" . $row['studentid'] . "," . $row['year'] . ")\" /><br />";
    echo "</span>\n";
}

?>
