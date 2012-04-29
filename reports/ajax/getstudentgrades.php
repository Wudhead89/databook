<?php
include('../../config.php');

$studentid = $_GET['studentid'];
$datasetid   = $_GET['datasetid'];

$sqlstring = "SELECT * FROM results_view WHERE datasetid = '$datasetid' AND studentid = '$studentid' ORDER BY subjectname";
$results = mysql_query($sqlstring);

echo "<h4>Student Grades</h4>";
echo "<table class=\"contenttable\">";
echo "<thead>";
echo "<tr>";
echo "<th>Subject Name</th>";
echo "<th>Grade</th>";
echo "</tr>";
echo "</thead>";

echo "<tbody>";
while ($row = mysql_fetch_assoc($results)) {
    echo "<tr>";
    echo "<th>" . $row['subjectname'] . "</th>";
    echo "<td>" . $row['grade'] . "</td>";
    echo "</tr>";
}
echo "</tbody>";
echo "</table>";
?>
