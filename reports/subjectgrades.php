<?php
/*
  Document   : subjectGrades.php
  Created on : 21-May-2011
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
$gradeid = $_GET['gradeid'];
?>  
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <script src="../js/jquery.min.js"></script>
        <script src="../ajax/stusearch.js"></script>
        <script src="../js/corefunctions.js"></script>
        <!--[if lt IE 9]>
        <script>
        document.createElement("nav");
        document.createElement("header");
        document.createElement("footer");
        </script>
        <![endif]-->           
        <link rel="stylesheet" href="../css/stylesheet.css" />
        <link rel="stylesheet" href="../css/div.css" />
        <title>Data Book - Subject Grades Report</title>
    </head>

    <body>
        <div id="container">

            <?php include('../header.php'); ?>

            <div id="content-container">           

                <div id="filter">
                    <form name="filter" action="subjectgrades.php?datasetid=$datasetid&amp;subjectid=$subjectid&amp;gradeid=$gradeid" method="post">
                        <?php include('filter.php'); ?>
                    </form>
                </div>  <!-- end filter -->
                <div id="content">

                    <?php
                    if (isset($datasetid) && isset($subjectid) && isset($gradeid)) {

                        $subjectname = getSubjectName($subjectid);

                        $sqlstring = "SELECT * FROM results_view  
                    INNER JOIN students ON results_view.studentid = students.studentid";
                        $sqlstring .= buildSQLStringIncDataSet($datasetid);
                        $sqlstring .= " AND subjectid = '$subjectid' AND gradeid='$gradeid' ORDER BY results_view.surname";

                        $results = mysql_query($sqlstring);

                        echo "<h2>Subject Grades Report: $subjectname</h2>";

                        echo "<table class=\"contenttable\">";
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>Student Name</th>";
                        echo "<th>Grade</th>";
                        echo "</tr>";
                        echo "</thead>";

                        echo "<tbody>";
                        while ($row = mysql_fetch_assoc($results)) {
                            echo "<tr>";
                            echo "<th><a href=\"student.php?datasetid=$datasetid&amp;studentid=" . $row['studentid'] . "\">" . $row['surname'] . ', ' . $row['forename'] . "</a></th>";
                            echo "<td>" . $row['grade'] . "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                    }
                    ?>
                </div> <!-- end content -->

            </div> <!-- end content-container -->

            <?php include('../footer.php'); ?>

        </div> <!-- end of container -->
    </body>
</html>