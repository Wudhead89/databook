<?php

include('../config.php');

$studentid = $_GET['id'];
$sqlstring = "select studentid, surname, forename from students WHERE forename LIKE '$studentid%' ORDER BY forename LIMIT 15";

$students = mysql_query($sqlstring);

// prepare xml data
header('Content-type: text/xml');
echo "<students>";
while ($row = mysql_fetch_assoc($students)) {
    echo "<student>";
    echo "<studentid>" . $row['studentid'] . "</studentid>";
    echo "<studentname>" . $row['forename'] . " " . $row['surname'] . "</studentname>";
    echo "</student>";
}
echo "</students>";
?>
