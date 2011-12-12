<?php
/*
  Document   : getformprofile.php
  Created on : 12-Dec-2011
  Author     : Richard Williamson
 */

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit;
}

include('../mssql.php');

$form = $_GET["form"];
$setid = $_SESSION['setid'];

echo "<h3>Form Profile " . $form . "</h3>";

// return total number of students in a form
$sqlstring = "SELECT COUNT(ClassGroupId) AS numStudents FROM CurYrStudents WHERE ClassGroupId = '$form'";
$numStudents = sqlsrv_query($conn, $sqlstring);

while ($row = sqlsrv_fetch_array($numStudents, SQLSRV_FETCH_ASSOC)) {
    echo "Total number of students: " . $row['numStudents'] . "<br />\n";
}

// return total number of boys and girls in a form
$sqlstring = "SELECT CurYrNStuPersonal.StuSex AS Gender, COUNT(CurYrStudents.ClassGroupId) AS numStudents 
                FROM CurYrStudents INNER JOIN CurYrNStuPersonal ON CurYrStudents.StudentId = CurYrNStuPersonal.StudentId GROUP BY CurYrNStuPersonal.StuSex, CurYrStudents.ClassGroupId 
                HAVING (CurYrStudents.ClassGroupId = '$form')";
$numStudents = sqlsrv_query($conn, $sqlstring);

while ($row = sqlsrv_fetch_array($numStudents, SQLSRV_FETCH_ASSOC)) {
    echo "Total number of " . $row['Gender'] . " = " . $row['numStudents'] . "<br />\n";
}
sqlsrv_free_stmt($numStudents);


// return sen students
echo "<h3>SEN Students</h3>\n";

$sqlstring = "SELECT CurYrStudents.Name, CurYrSENStages.StageCode, SENSTUSTAGES.StartDate, SENSTUSTAGES.EndDate
    FROM CurYrStudents 
    INNER JOIN SENSTUSTAGES ON CurYrStudents.StudentId = SENSTUSTAGES.StudentId 
    INNER JOIN CurYrSENStages ON SENSTUSTAGES.StageId = CurYrSENStages.StageId 
    WHERE (CurYrStudents.ClassGroupId = '$form') AND (SENSTUSTAGES.SetId = '$setid') AND (curYrSENStages.StageCode <> 'N') AND (SENSTUSTAGES.EndDate = '')
    ORDER BY CurYrStudents.Name";
$senStudents = sqlsrv_query($conn, $sqlstring);

echo "<table cellpadding=2px>";
echo "<tr>";
echo "<th>Name</th>\n";
echo "<th>Stage</th>\n";
echo "<th>Start Date</th>\n";
echo "</tr>";

while ($row = sqlsrv_fetch_array($senStudents, SQLSRV_FETCH_ASSOC)) {
    echo "<tr>\n";
    echo "<td>" . $row['Name'] . "</td>\n";
    echo "<td>" . $row['StageCode'] . "</td>\n";
    echo "<td>" . $row['StartDate'] . "</td>\n";
    echo "</tr>\n";
}

echo "</table>\n";
sqlsrv_free_stmt($senStudents);


// return fsm students
echo "<h3>FSM Students</h3>\n";

$sqlstring = "SELECT CurYrStudents.Name, UKSTUSTATS.FSMEligible FROM UKSTUSTATS 
                INNER JOIN CurYrStudents ON UKSTUSTATS.StudentId = CurYrStudents.StudentId 
                WHERE (UKSTUSTATS.FSMEligible = 'Y') AND (UKSTUSTATS.SetId = '$setid') AND (CurYrStudents.ClassGroupId = '$form') 
                ORDER BY CurYrStudents.Name";
$fsmStudents = sqlsrv_query($conn, $sqlstring);

while ($row = sqlsrv_fetch_array($fsmStudents, SQLSRV_FETCH_ASSOC)) {
    echo $row['Name'] . "<br />\n";
}
sqlsrv_free_stmt($fsmStudents);

// return cats data
echo "<table width=801px valign=top>\n";
echo "<tr>\n";
echo "<th colspan = \"3\"><h3>CATs Data</h3></th>\n";
echo "</tr>\n";
echo "<tr>\n";

echo "<td width=267px valign=top>\n";
echo "<h4>Students with Mean < 85</h4>\n";
$sqlstring = "SELECT CurYrStudents.Name, CurYrStuCATResults.vblsas, CurYrStuCATResults.nsas, CurYrStuCATResults.qsas, CurYrStuCATResults.meansas 
                FROM CurYrStudents 
                INNER JOIN CurYrStuCATResults ON CurYrStudents.StudentId = CurYrStuCATResults.StudentId 
                WHERE (CurYrStudents.ClassGroupId = '$form')  AND (CAST(CurYrStuCATResults.meansas AS INT) BETWEEN '59' AND '85') 
                ORDER BY CurYrStudents.Name";
$catStudents = sqlsrv_query($conn, $sqlstring);

while ($row = sqlsrv_fetch_array($catStudents, SQLSRV_FETCH_ASSOC)) {
    echo $row['Name'] . " (" . $row['meansas'] . ")<br />\n";
}
echo "</td>\n";

echo "<td width=267px valign=top>\n";
echo "<h4>Students with Mean between 95 - 100</h4>\n";
$sqlstring = "SELECT CurYrStudents.Name, CurYrStuCATResults.vblsas, CurYrStuCATResults.nsas, CurYrStuCATResults.qsas, CurYrStuCATResults.meansas 
                FROM CurYrStudents 
                INNER JOIN CurYrStuCATResults ON CurYrStudents.StudentId = CurYrStuCATResults.StudentId 
                WHERE (CurYrStudents.ClassGroupId = '$form')  AND (CAST(CurYrStuCATResults.meansas AS INT) BETWEEN '95' AND '100') 
                ORDER BY CurYrStudents.Name";
$catStudents = sqlsrv_query($conn, $sqlstring);

while ($row = sqlsrv_fetch_array($catStudents, SQLSRV_FETCH_ASSOC)) {
    echo $row['Name'] . " (" . $row['meansas'] . ")<br />\n";
}
echo "</td>\n";

echo "<td width=267px valign=top>\n";
echo "<h4>Students with Mean > 115</h4>\n";
$sqlstring = "SELECT CurYrStudents.Name, CurYrStuCATResults.vblsas, CurYrStuCATResults.nsas, CurYrStuCATResults.qsas, CurYrStuCATResults.meansas 
                FROM CurYrStudents 
                INNER JOIN CurYrStuCATResults ON CurYrStudents.StudentId = CurYrStuCATResults.StudentId 
                WHERE (CurYrStudents.ClassGroupId = '$form')  AND (CAST(CurYrStuCATResults.meansas AS INT) BETWEEN '115' AND '200') 
                ORDER BY CurYrStudents.Name";
$catStudents = sqlsrv_query($conn, $sqlstring);

while ($row = sqlsrv_fetch_array($catStudents, SQLSRV_FETCH_ASSOC)) {
    echo $row['Name'] . " (" . $row['meansas'] . ")<br />\n";
}
echo "</td>\n";
echo "</tr>\n";
echo "</table>\n";


sqlsrv_free_stmt($catStudents);



sqlsrv_close($conn);

?>
