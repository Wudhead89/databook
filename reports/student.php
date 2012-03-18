<?php
/*
  Document   : student.php
  Created on : 05-May-2011
  Author     : Richard Williamson
 */

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit;
}
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
        <title>Data Book - Student Report</title>        
    </head>

    <body onload="init()" onResize="movepopup()" onClick="clearTable()">
        <div id="container">

            <?php include('../header.php'); ?>

            <div id="content-container">  

                <?php
                include('../config.php');
                include('functions.php');

                if (isset($_POST['dataset'])) {
                    $datasetid = $_POST['dataset'];
                } else if (isset($_GET['datasetid'])) {
                    $datasetid = $_GET['datasetid'];
                }

                $studentid = $_GET['studentid'];

                echo "<div id=\"filter\">";
                echo "Dataset:";
                echo "<form name=\"filter\" action=\"student.php?studentid=$studentid\" method=\"post\">";
                echo "<select name=\"dataset\">";

                $datasets = mysql_query("SELECT * FROM datasets");
                while ($ds = mysql_fetch_assoc($datasets)) {
                    echo "<option value=\"" . $ds['datasetid'] . "\"";

                    if (isset($datasetid) && $datasetid == $ds['datasetid']) {
                        echo " selected ";
                    }

                    echo ">" . $ds['datasetname'] . "</option>";
                }

                echo "</select>";
                echo "<input type=\"submit\" value=\"submit\" /><br>";
                echo "</form>";
                echo "</div>  <!-- end filter -->";

                $studentname = getStudentName($studentid);
                echo "<div id=\"content\">";
                echo "<h2>Student Report: $studentname</h2>";

                echo "<p>";
                echo "Form: " . getStudentTutorGroup($studentid) . "</p>";
                echo "<p>FSM: " . getStudentFSM($studentid) . "<br>";
                echo "LAC: " . getStudentLAC($studentid) . "<br>";
                echo "SEN: " . getStudentSEN($studentid);
                if (getStudentSEN($studentid) != "N") {
                    echo " <a href=\"stusenreport.php?studentid=" . $studentid . "\">[SEN Report]</a>";
                }
                echo "</p>";
                echo "<p> CATS: ";
                foreach (getStudentCAT($studentid) as $value) {
                    echo $value . " ";
                }
                echo "</p>";


                if (isset($datasetid)) {
                    $sqlstring = "SELECT * FROM results_view WHERE datasetid = '$datasetid' AND studentid = '$studentid' ORDER BY subjectname";
                    $results = mysql_query($sqlstring);

                    echo "<table class=\"contenttable\">";
                    echo "<tr>";
                    echo "<td>Subject Name</td>";
                    echo "<td>Grade</td>";
                    echo "</tr>";

                    while ($row = mysql_fetch_assoc($results)) {
                        echo "<tr>";
                        echo "<td>" . $row['subjectname'] . "</td>";
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