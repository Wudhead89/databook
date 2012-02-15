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
                    MAX(IF(grades.grade='A*',results.gradeid,0)) as sgradeid,
                    SUM(IF(grades.grade='A',1,0)) as A,
                    MAX(IF(grades.grade='A',results.gradeid,0)) as agradeid,
                    SUM(IF(grades.grade='B',1,0)) as B,
                    MAX(IF(grades.grade='B',results.gradeid,0)) as bgradeid,
                    SUM(IF(grades.grade='C',1,0)) as C,
                    MAX(IF(grades.grade='C',results.gradeid,0)) as cgradeid,
                    SUM(IF(grades.grade='D',1,0)) as D,
                    MAX(IF(grades.grade='D',results.gradeid,0)) as dgradeid,
                    SUM(IF(grades.grade='E',1,0)) as E,
                    MAX(IF(grades.grade='E',results.gradeid,0)) as egradeid,
                    SUM(IF(grades.grade='F',1,0)) as F,
                    MAX(IF(grades.grade='F',results.gradeid,0)) as fgradeid,
                    SUM(IF(grades.grade='G',1,0)) as G,
                    MAX(IF(grades.grade='G',results.gradeid,0)) as ggradeid,
                    SUM(IF(grades.grade='U',1,0)) as U,
                    MAX(IF(grades.grade='U',results.gradeid,0)) as ugradeid
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
                        echo "<td><a href=\"subjectgrades.php?datasetid=$datasetid&subjectid=" . $row['subjectid'] . "&gradeid=" . $row['sgradeid'] . "\">" . $row['A*'] . "</a></td>";
                        echo "<td><a href=\"subjectgrades.php?datasetid=$datasetid&subjectid=" . $row['subjectid'] . "&gradeid=" . $row['agradeid'] . "\">" . $row['A'] . "</a></td>";
                        echo "<td><a href=\"subjectgrades.php?datasetid=$datasetid&subjectid=" . $row['subjectid'] . "&gradeid=" . $row['bgradeid'] . "\">" . $row['B'] . "</a></td>";
                        echo "<td><a href=\"subjectgrades.php?datasetid=$datasetid&subjectid=" . $row['subjectid'] . "&gradeid=" . $row['cgradeid'] . "\">" . $row['C'] . "</a></td>";
                        echo "<td><a href=\"subjectgrades.php?datasetid=$datasetid&subjectid=" . $row['subjectid'] . "&gradeid=" . $row['dgradeid'] . "\">" . $row['D'] . "</a></td>";
                        echo "<td><a href=\"subjectgrades.php?datasetid=$datasetid&subjectid=" . $row['subjectid'] . "&gradeid=" . $row['egradeid'] . "\">" . $row['E'] . "</a></td>";
                        echo "<td><a href=\"subjectgrades.php?datasetid=$datasetid&subjectid=" . $row['subjectid'] . "&gradeid=" . $row['fgradeid'] . "\">" . $row['F'] . "</a></td>";
                        echo "<td><a href=\"subjectgrades.php?datasetid=$datasetid&subjectid=" . $row['subjectid'] . "&gradeid=" . $row['ggradeid'] . "\">" . $row['G'] . "</a></td>";
                        echo "<td><a href=\"subjectgrades.php?datasetid=$datasetid&subjectid=" . $row['subjectid'] . "&gradeid=" . $row['ugradeid'] . "\">" . $row['U'] . "</a></td>";
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