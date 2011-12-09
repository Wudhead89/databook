<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit;
}

$year = $_GET["year"];
$setid = $_SESSION['setid'];

include('../mssql.php');

$sqlstring = "SELECT DISTINCT ClassGroupId FROM students WHERE CourseYear = $year AND SetId = '$setid' ORDER BY ClassGroupId";

$forms = sqlsrv_query($conn, $sqlstring);
echo "<select>\n";
while ($row = sqlsrv_fetch_array($forms, SQLSRV_FETCH_ASSOC)) {
    echo "<option>" . $row['ClassGroupId'] . "</option>\n";
}
echo "</select>\n";

sqlsrv_free_stmt($forms);

sqlsrv_close($conn);
?>
