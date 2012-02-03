<?php
/*
    Document   : subBroadsheet.php
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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <script src="../ajax/stusearch.js" language="javascript" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="../css/stylesheet.css" />
        <link rel="stylesheet" type="text/css" href="../css/div.css" />
        <title>Data Book - Subject Broadsheet</title>        
    </head>
    
    <body onload="init()" onResize="movepopup()" onClick="clearTable()">
        <div id="container">

            <?php include('../header.php'); ?>

            <div id="content-container">       

                <?php
                include('../config.php');
                include('buildsqlstring.php');

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

                echo "<div id=\"filter\">\n";
                echo "<form name=\"filter\" action=\"subbroadsheet.php\" method=\"post\">\n";
                include('filter.php');
                echo "</form>\n";
                echo "</div>  <!-- end filter -->\n";

                echo "<div id=\"content\">\n";
                echo "<h2>Subject Broadsheet</h2>\n";
                
                if (isset($_POST['dataset'])) {
                    $datasetid = $_POST['dataset'];

                    $sqlstring = "SELECT subjects.subjectname, results.subjectid, 
                    SUM(IF(grades.grade='A*',1,0)) as 'A*',
                    SUM(IF(grades.grade='A',1,0)) as A,
                    SUM(IF(grades.grade='B',1,0)) as B,
                    SUM(IF(grades.grade='C',1,0)) as C,
                    SUM(IF(grades.grade='D',1,0)) as D,
                    SUM(IF(grades.grade='E',1,0)) as E,
                    SUM(IF(grades.grade='F',1,0)) as F,
                    SUM(IF(grades.grade='G',1,0)) as G,
                    SUM(IF(grades.grade='U',1,0)) as U
                    FROM results 
                    INNER JOIN grades ON results.gradeid = grades.gradeid 
                    INNER JOIN subjects ON results.subjectid = subjects.subjectid
                    INNER JOIN students ON results.studentid = students.studentid";

                    $sqlstring .= buildSQLStringIncDataSet($datasetid);
                    $sqlstring .= " GROUP BY subjects.subjectname";

                    $result = mysql_query($sqlstring);

                    echo "<table class=\"contenttable\">
                    <tr>
                    <td>Subject Name</td>
                    <td>A*</td>
                    <td>A</td>
                    <td>B</td>
                    <td>C</td>
                    <td>D</td>	
                    <td>E</td>
                    <td>F</td>
                    <td>G</td>
                    <td>U</td>
                    <td>Total</td>
                    <td>%AA</td>
                    <td>%AC</td>
                    <td>%AG</td>
                    </tr>";

                    while ($row = mysql_fetch_assoc($result)) {
                        $total = $row['A*'] + $row['A'] + $row['B'] + $row['C'] + $row['D'] + $row['E'] + $row['F'] + $row['G'] + $row['U'];
                        $aa = $row['A*'] + $row['A'];
                        $ac = $row['A*'] + $row['A'] + $row['B'] + $row['C'];
                        $ag = $row['A*'] + $row['A'] + $row['B'] + $row['C'] + $row['D'] + $row['E'] + $row['F'] + $row['G'];

                        echo "<tr>\n";
                        echo "<td><a href=\"subject.php?datasetid=$datasetid&subjectid=" . $row['subjectid'] . "\"><img src=\"../images/icons/application_view_list.png\" width=\"16\" height=\"16\"/></a>&nbsp;";
                        echo "<a href=\"tchgroupbroadsheet.php?datasetid=$datasetid&subjectid=" . $row['subjectid'] . "\">" . $row['subjectname'] . "</a></td>";
                        echo "<td><a href=\"subjectgrades.php?datasetid=$datasetid&subjectid=" . $row['subjectid'] . "&gradeid=1\">" . $row['A*'] . "</a></td>";
                        echo "<td><a href=\"subjectgrades.php?datasetid=$datasetid&subjectid=" . $row['subjectid'] . "&gradeid=2\">" . $row['A'] . "</a></td>";
                        echo "<td><a href=\"subjectgrades.php?datasetid=$datasetid&subjectid=" . $row['subjectid'] . "&gradeid=3\">" . $row['B'] . "</a></td>";
                        echo "<td><a href=\"subjectgrades.php?datasetid=$datasetid&subjectid=" . $row['subjectid'] . "&gradeid=4\">" . $row['C'] . "</a></td>";
                        echo "<td><a href=\"subjectgrades.php?datasetid=$datasetid&subjectid=" . $row['subjectid'] . "&gradeid=5\">" . $row['D'] . "</a></td>";
                        echo "<td><a href=\"subjectgrades.php?datasetid=$datasetid&subjectid=" . $row['subjectid'] . "&gradeid=6\">" . $row['E'] . "</a></td>";
                        echo "<td><a href=\"subjectgrades.php?datasetid=$datasetid&subjectid=" . $row['subjectid'] . "&gradeid=7\">" . $row['F'] . "</a></td>";
                        echo "<td><a href=\"subjectgrades.php?datasetid=$datasetid&subjectid=" . $row['subjectid'] . "&gradeid=8\">" . $row['G'] . "</a></td>";
                        echo "<td><a href=\"subjectgrades.php?datasetid=$datasetid&subjectid=" . $row['subjectid'] . "&gradeid=9\">" . $row['U'] . "</a></td>";
                        echo "<td>" . $total . "</td>";
                        echo "<td>" . sprintf("%01.1f", (($aa / $total) * 100)) . "</td>";
                        echo "<td>" . sprintf("%01.1f", (($ac / $total) * 100)) . "</td>";
                        echo "<td>" . sprintf("%01.1f", (($ag / $total) * 100)) . "</td>";
                        echo "</tr>\n";
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