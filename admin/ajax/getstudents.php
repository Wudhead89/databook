<?php
/*
  Document   : getstudents.php
  Created on : 29-02-2012
  Author     : Richard Williamson
 */

$form = $_GET["form"];

include('../../config.php');

$sqlstring = "SELECT * FROM students WHERE form = '$form' ORDER BY surname, forename";

$students = mysql_query($sqlstring);

echo "<h4>Please select a student to edit</h4>";
echo "<p>";
while ($row = mysql_fetch_assoc($students)) {
    echo "<a href=\"editselectedstudent.php?studentid=" . $row['studentid'] . "\">" . $row['forename'] . " " . $row['surname'] .  "</a><br />";

}
echo "</p>";

?>
