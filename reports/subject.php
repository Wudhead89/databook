<?php
/*
  Document   : subject.php
  Created on : 05-May-2011
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
        <title>Data Book - Subject Report</title>
    </head>

    <body>
        <div id="container">

            <?php include('../header.php'); ?>

            <div id="content-container">           

                <div id="filter">
                    <form name="filter" action="subject.php?datasetid=$datasetid&amp;subjectid=$subjectid" method="post">
                        <?php include('filter.php'); ?>
                    </form>
                </div>  <!-- end filter -->

                <div id="content">

                    <?php
                    if (isset($datasetid) && isset($subjectid)) {

                        $subjectname = getSubjectName($subjectid);

                        $sqlstring = "SELECT * FROM results_view  
                    INNER JOIN students ON results_view.studentid = students.studentid";
                        $sqlstring .= buildSQLStringIncDataSet($datasetid);
                        $sqlstring .= " AND subjectid = '$subjectid' ORDER BY results_view.studentname";

                        $results = mysql_query($sqlstring);


                        echo "<h2>Subject Report: $subjectname</h2>";

                        echo "<table class=\"contentable\">";
                        echo "<tr>";
                        echo "<td>Student Name</td>";
                        echo "<td>Grade</td>";
                        echo "</tr>";

                        while ($row = mysql_fetch_assoc($results)) {
                            echo "<tr>";
                            echo "<td><a href=\"student.php?datasetid=$datasetid&amp;studentid=" . $row['studentid'] . "\">" . $row['studentname'] . "</a></td>";
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