<?php
/*
  Document   : gettchgroups.php
  Created on : 14-Dec-2011
  Author     : Richard Williamson
 */

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit;
}

$lectid = $_GET["lectid"];
$setid = $_SESSION['setid'];

include('../mssql.php');

$sqlstring = "SELECT GroupId, GroupCode FROM teachinggroups WHERE SetId = '$setid' AND Lecturerid = '$lectid'";

$groups = sqlsrv_query($conn, $sqlstring);

echo "Please select a teaching group : ";
echo "<select onchange=\"getGroupData(this.value)\">\n";
echo "<option></option>";
while ($row = sqlsrv_fetch_array($groups, SQLSRV_FETCH_ASSOC)) {
    echo "<option value=\"" . $row['GroupId'] . "\">" . $row['GroupCode'] . "</option>\n";
}
echo "</select>\n";

sqlsrv_free_stmt($groups);

sqlsrv_close($conn);
?>
