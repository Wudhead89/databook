<?php
/*
  Document   : updatestugrade.php
  Created on : 03-Mar-2012
  Author     : Richard Williamson
 */

include('../../config.php');

$resultid = $_GET['resultid'];
$scale = $_GET['scale'];
$newgrade = $_GET['newgrade'];

echo "resultid = " .$resultid . "<br />";
echo "scale = " . $scale . "<br />";
echo "newgrade = " . $newgrade . "<br />";

$result = mysql_query("SELECT gradeid FROM grades WHERE scale=\"" . $scale . "\" AND grade=\"" . $newgrade . "\"");
while ($row = mysql_fetch_array($result)) {
    $gradeid = $row['gradeid'];
}

echo "gradeid = " . $gradeid . "<br />";


$insertsql = "UPDATE results SET gradeid = '$gradeid' WHERE resultid = $resultid";

//$response = mysql_query($insertsql);
//if ($response){
//    echo "<p>Update Successful!</p>";
//}
//else {
//    echo "<p>Update Failed!</p>";
//}
echo $insertsql;

?>