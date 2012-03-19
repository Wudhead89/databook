<?php
/*
  Document   : tchGroupGrades.php
  Created on : 22-May-2011
  Author     : Richard Williamson
 */

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit;
}
include('../config.php');
include('buildsqlstring.php');
include('functions.php');

if (isset($_POST['sen'])) {
    $sen = $_POST['sen'];
} else {
    $sen = array();
}

if (isset($_POST['dataset'])) {
    $datasetid = $_POST['dataset'];
} else if (isset($_GET['datasetid'])) {
    $datasetid = $_GET['datasetid'];
}

$subjectid = $_GET['subjectid'];
$tchgroupcode = $_GET['tchgroupcode'];
$gradeid = $_GET['gradeid'];
?>  
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <script src="../ajax/stusearch.js"></script>
        <!--[if lt IE 9]>
        <script>
        document.createElement("nav");
        document.createElement("header");
        document.createElement("footer");
        </script>
        <![endif]-->           
        <link rel="stylesheet" href="../css/stylesheet.css" />
        <link rel="stylesheet" href="../css/div.css" />
        <title>Data Book - Teaching Group Grades Report</title>
    </head>

    <body onload="init()" onResize="movepopup()" onClick="clearTable()">
        <div id="container">

            <?php include('../header.php'); ?>

            <div id="content-container">           

                <?php
                if (isset($datasetid) && isset($subjectid) && isset($tchgroupcode) && isset($gradeid)) {

                    $subjectname = getSubjectName($subjectid);

                    echo "<div id=\"filter\">";
                    echo "<form name=\"filter\" action=\"tchgroupgrades.php?datasetid=$datasetid&subjectid=$subjectid&gradeid=$gradeid&tchgroupcode=$tchgroupcode\" method=\"post\">";
                    include('filter.php');
                    echo "</form>";
                    echo "</div>  <!-- end filter -->";


                    $sqlstring = "SELECT * FROM results_view  
                    INNER JOIN students ON results_view.studentid = students.studentid
                    INNER JOIN tchgroups ON results_view.studentid = tchgroups.studentid AND results_view.subjectid = tchgroups.subjectid";
                    $sqlstring .= buildSQLStringIncDataSet($datasetid);
                    $sqlstring .= " AND results_view.subjectid = '$subjectid' AND tchgroupcode = '$tchgroupcode' AND gradeid='$gradeid' ORDER BY results_view.surname";

                    $results = mysql_query($sqlstring);

                    echo "<div id=\"content\">";
                    echo "<h2>Subject Grades Report: $subjectname ($gradeid)</h2>";

                    echo "<table class=\"contenttable\">";
                    echo "<tr>";
                    echo "<td>Student Name</td>";
                    echo "<td>Grade</td>";
                    echo "</tr>";

                    while ($row = mysql_fetch_assoc($results)) {
                        echo "<tr>";
                        echo "<td><a href=\"student.php?datasetid=$datasetid&amp;studentid=" . $row['studentid'] . "\">" . $row['surname'] . ', ' . $row['forename'] . "</a></td>";
                        echo "<td>" . $row['grade'] . "</td>";
                        echo "</tr>";
                    }

                    echo "</table>";
                }
                ?>
            </div> <!-- end content -->

        </div> <!-- end content-container -->

        <?php include('../footer.php'); ?>

    </div> <!-- end of container -->
</body>
</html>