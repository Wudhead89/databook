<?php
/*
    Document   : tchGroup.php
    Created on : 22-May-2011
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
        <script src="../ajax/stusearch.js" language="javascript"></script>
        <link rel="stylesheet" type="text/css" href="../css/stylesheet.css" />
        <link rel="stylesheet" type="text/css" href="../css/div.css" />
        <title>Data Book - Teaching Group Report</title>
    </head>
    
    <body onload="init()" onResize="movepopup()" onClick="clearTable()">
        <div id="container">

            <?php include('../header.php'); ?>

            <div id="content-container">           
        
        <?php
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
        
        if (isset($datasetid) && isset($subjectid) && isset($tchgroupcode)) {

            $subjectname = getSubjectName($subjectid);

            echo "<div id=\"filter\">\n";
            echo "<form name=\"filter\" action=\"subject.php?datasetid=$datasetid&subjectid=$subjectid\" method=\"post\">\n";
            include('filter.php');
            echo "</form>\n";
            echo "</div>  <!-- end filter -->\n";
            
            $sqlstring = "SELECT * FROM results_view  
                    INNER JOIN students ON results_view.studentid = students.studentid
                    INNER JOIN tchgroups ON results_view.studentid = tchgroups.studentid AND results_view.subjectid = tchgroups.subjectid";
            $sqlstring .= buildSQLStringIncDataSet($datasetid);
            $sqlstring .= " AND tchgroupcode = '$tchgroupcode' ORDER BY results_view.surname";

            $results = mysql_query($sqlstring);
            
            echo "<div id=\"content\">\n";
            echo "<h2>Teaching Group Report: $tchgroupcode</h2>\n";

            echo "<table class=\"contentable\">\n";
            echo "<tr>\n";
            echo "<td>Student Name</td>\n";
            echo "<td>Grade</td>\n";
            echo "</tr>\n";

            while ($row = mysql_fetch_assoc($results)) {
                echo "<tr>\n";
                echo "<td><a href=\"student.php?datasetid=$datasetid&studentid=" . $row['studentid'] . "\">" . $row['surname'] . "</a></td>\n";
                echo "<td>" . $row['grade'] . "</td>";
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