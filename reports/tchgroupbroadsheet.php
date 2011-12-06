<?php
/*
    Document   : tchGroupBroadsheet.php
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
        <script src="../ajax/javascript.js" language="javascript"></script>
        <link rel="stylesheet" type="text/css" href="../css/stylesheet.css" />
        <link rel="stylesheet" type="text/css" href="../css/div.css" />
        <title>Data Book - Teaching Group Broadsheet</title>        
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
                $subjectid = $_GET['subjectid'];
                
                echo "<div id=\"filter\">\n";
                echo "<form name=\"filter\" action=\"tchgroupbroadsheet.php?datasetid=$datasetid&subjectid=$subjectid\" method=\"post\">\n";
                include('filter.php');
                echo "</form>\n";
                echo "</div>  <!-- end filter -->\n";

                echo "<div id=\"content\">\n";
                echo "<h2>Teaching Group Broadsheet</h2>\n";
                
                if (isset($datasetid)) {
                    //$datasetid = $_POST['dataset'];

                    $sqlstring = "SELECT tchgroups.tchgroupcode,
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
                        INNER JOIN students ON results.studentid = students.studentid
                        INNER JOIN tchgroups ON results.studentid = tchgroups.studentid AND results.subjectid = tchgroups.subjectid";
                    $sqlstring .= buildSQLStringIncDataSet($datasetid);
                    $sqlstring .= " AND results.subjectid = " . $subjectid;
                    $sqlstring .= " GROUP BY tchgroups.tchgroupcode";

                    $result = mysql_query($sqlstring);

                    echo "<table class=\"contenttable\">
                    <tr>
                    <td>Teaching Group</td>
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
                        echo "<td><a href=\"tchgroup.php?datasetid=$datasetid&subjectid=$subjectid&tchgroupcode=" . $row['tchgroupcode'] . "\">" . $row['tchgroupcode'] . "</a></td>";
                        echo "<td><a href=\"tchgroupgrades.php?datasetid=$datasetid&subjectid=$subjectid&gradeid=1&tchgroupcode=" . $row['tchgroupcode'] . "\">" . $row['A*'] . "</a></td>";
                        echo "<td><a href=\"tchgroupgrades.php?datasetid=$datasetid&subjectid=$subjectid&gradeid=2&tchgroupcode=" . $row['tchgroupcode'] . "\">" . $row['A'] . "</a></td>";
                        echo "<td><a href=\"tchgroupgrades.php?datasetid=$datasetid&subjectid=$subjectid&gradeid=3&tchgroupcode=" . $row['tchgroupcode'] . "\">" . $row['B'] . "</a></td>";
                        echo "<td><a href=\"tchgroupgrades.php?datasetid=$datasetid&subjectid=$subjectid&gradeid=4&tchgroupcode=" . $row['tchgroupcode'] . "\">" . $row['C'] . "</a></td>";
                        echo "<td><a href=\"tchgroupgrades.php?datasetid=$datasetid&subjectid=$subjectid&gradeid=5&tchgroupcode=" . $row['tchgroupcode'] . "\">" . $row['D'] . "</a></td>";
                        echo "<td><a href=\"tchgroupgrades.php?datasetid=$datasetid&subjectid=$subjectid&gradeid=6&tchgroupcode=" . $row['tchgroupcode'] . "\">" . $row['E'] . "</a></td>";
                        echo "<td><a href=\"tchgroupgrades.php?datasetid=$datasetid&subjectid=$subjectid&gradeid=7&tchgroupcode=" . $row['tchgroupcode'] . "\">" . $row['F'] . "</a></td>";
                        echo "<td><a href=\"tchgroupgrades.php?datasetid=$datasetid&subjectid=$subjectid&gradeid=8&tchgroupcode=" . $row['tchgroupcode'] . "\">" . $row['G'] . "</a></td>";
                        echo "<td><a href=\"tchgroupgrades.php?datasetid=$datasetid&subjectid=$subjectid&gradeid=9&tchgroupcode=" . $row['tchgroupcode'] . "\">" . $row['U'] . "</a></td>";
                        echo "<td>" . $total . "</td>";
                        echo "<td>" . sprintf("%01.2f", (($aa / $total) * 100)) . "</td>";
                        echo "<td>" . sprintf("%01.2f", (($ac / $total) * 100)) . "</td>";
                        echo "<td>" . sprintf("%01.2f", (($ag / $total) * 100)) . "</td>";
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