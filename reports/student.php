<?php
/*
    Document   : student.php
    Created on : 05-May-2011
    Author     : Richard Williamson
*/
?>

<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit;
}
?>  

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script src="../ajax/javascript.js" language="javascript"></script>
        <link rel="stylesheet" type="text/css" href="../css/stylesheet.css" />
        <link rel="stylesheet" type="text/css" href="../css/div.css" />
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

                if (isset($datasetid) && isset($studentid)) {

                    echo "<div id=\"filter\">\n";
                    echo "Dataset: &nbsp;\n";
                    echo "<form name=\"filter\" action=\"student.php?datasetid=$datasetid&studentid=$studentid\" method=\"post\">\n";
                    echo "<select name=\"dataset\">\n";

                    $datasets = mysql_query("SELECT * FROM datasets");
                    while ($ds = mysql_fetch_assoc($datasets)) {
                        echo "<option value=\"" . $ds['datasetid'] . "\"";

                        if (isset($datasetid) && $datasetid == $ds['datasetid']) {
                            echo " selected ";
                        }

                        echo ">" . $ds['datasetname'] . "</option>\n";
                    }

                    echo "</select>\n";
                    echo "<input type=\"submit\" value=\"submit\" /><br />\n";
                    echo "</form>\n";
                    echo "</div>  <!-- end filter -->\n";

                }
                
                if (isset($studentid)) {
                    $studentname = getStudentName($studentid);
                    echo "<div id=\"content\">\n";
                    echo "<h2>Student Report: $studentname</h2>\n";

                    echo "<p>";
                    echo "Form: " . getStudentTutorGroup($studentid) . "</p>\n";
                    echo "<p>FSM: " . getStudentFSM($studentid) . "<br />\n";
                    echo "LAC: " . getStudentLAC($studentid) . "<br />\n";
                    echo "SEN: " . getStudentSEN($studentid);
                    if (getStudentSEN($studentid) != "N"){
                        echo " <a href=\"stusenreport.php?studentid=" . $studentid . "\">[SEN Report]</a>";
                    }
                    echo "</p>\n";
                    echo "<p> CATS: ";
                    foreach (getStudentCAT($studentid) as $value) {
                        echo $value . " ";
                    }
                    echo "</p>\n";
                }
                
                if (isset($datasetid) && isset($studentid)) {
                    $sqlstring = "SELECT * FROM results_view WHERE datasetid = '$datasetid' AND studentid = '$studentid' ORDER BY subjectname";
                    $results = mysql_query($sqlstring);

                    echo "<table class=\"contenttable\">\n";
                    echo "<tr>\n";
                    echo "<td>Subject Name</td>";
                    echo "<td>Grade</td>\n";
                    echo "</tr>\n";

                    while ($row = mysql_fetch_assoc($results)) {
                        echo "<tr>\n";
                        echo "<td>" . $row['subjectname'] . "</td>\n";
                        echo "<td>" . $row['grade'] . "</td>\n";
                        echo "</tr>\n";
                    }

                    echo "</table>\n";
                }
                ?>

            </div> <!-- end content -->

        </div> <!-- end content-container -->

<?php include('../footer.php'); ?>

        </div> <!-- end of container -->
    </body>
</html>