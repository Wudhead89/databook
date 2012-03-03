<?php
/*
  Document   : editstugrades.php
  Created on : 03-Mar-2012
  Author     : Richard Williamson
 */
include('../../config.php');
include('../../reports/functions.php');

$studentid = $_GET["studentid"];
$grades = array("A*", "A", "B", "C", "D", "E", "F", "G", "U");

echo "<h4>Student Name: " . getStudentName($studentid) . "</h4>";

$sqlstring = "SELECT * FROM results_view WHERE studentid = $studentid ORDER BY datasetname, subjectname";
$results = mysql_query($sqlstring);

echo "<table class=\"contenttable\">\n";
echo "<tr>";
echo "<td>Dataset Name</td>";
echo "<td>Subject</td>";
echo "<td>Grade</td>";
echo "</tr>";

while ($result = mysql_fetch_assoc($results)) {
    echo "<tr>";
    echo "<td>" . $result['datasetname'] . "</td>";
    echo "<td>" . $result['subjectname'] . "</td>";
    
    echo "<td>";
    echo "<select>";
    foreach ($grades as $g){
        echo "<option ";
        if ($result['grade'] == $g){
            echo "selected";
        }
        echo ">" . $g . "</option>";
    }
    echo "</select>";
    echo "</td>";
    
    echo "</tr>";
}

echo "</table>\n";

echo "<p></p>";

echo "<input type = \"submit\" value = \"submit\" name = \"submit\" onclick = \"updateStudent(" . $studentid . ")\"/>";

echo "<div id=\"updatestudentresponse\" style=\"padding-top: 20px\"></div>";

?>
