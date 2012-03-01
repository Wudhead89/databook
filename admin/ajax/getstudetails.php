<?php
/*
  Document   : getstudetails.php
  Created on : 01-Mar-2012
  Author     : Richard Williamson
 */
include('../../config.php');
include('../../reports/functions.php');

$studentid = $_GET["studentid"];
$year = $_GET['year'];
$form = getStudentTutorGroup($studentid);
$fsm = getStudentFSM($studentid);
$sen = getStudentSEN($studentid);

echo "<h4>Student Name: " . getStudentName($studentid) . " <img src = \"../images/icons/delete.png\" width = \"16\" height = \"16\"/ onclick=deleteStudent(" . $studentid . ")></h4>";
echo "<p>Student ID: " . $studentid . "<br /> Student Year: " . $year . "</p>";

$sqlstring = "SELECT DISTINCT form FROM students WHERE year = $year ORDER BY form";
$forms = mysql_query($sqlstring);

echo "<p>Student Form: ($form) ";
echo "<select id=\"studentform\">\n";
while ($row = mysql_fetch_assoc($forms)) {
    echo "<option ";
    if ($row['form'] == $form){
        echo "selected";
    }
    echo ">" . $row['form'] . "</option>\n";
}
echo "</select>\n";
echo "</p>";

echo "<p>FSM: (" . $fsm . ") ";
echo "<select id=\"studentfsm\">";
if ($fsm == "Y"){
    echo "<option selected>Y</option>";
    echo "<option>N</option>";
}
else{
    echo "<option>Y</option>";
    echo "<option selected>N</option>";
}
    
echo "</select>";
echo "</p>";

echo "<p>SEN: (" . $sen . ") ";
echo "<select id=\"studentsen\">";
echo "<option "; if ($sen == "S") { echo "selected"; } echo ">S</option>";
echo "<option "; if ($sen == "P") { echo "selected"; } echo ">P</option>";
echo "<option "; if ($sen == "A") { echo "selected"; } echo ">A</option>";
echo "<option "; if ($sen == "N") { echo "selected"; } echo ">N</option>";
echo "</select>";
echo "</p>";

echo "<input type = \"submit\" value = \"submit\" name = \"submit\" onclick = \"updateStudent(" . $studentid . ")\"/>";

echo "<div id=\"updatestudentresponse\" style=\"padding-top: 20px\"></div>";

?>