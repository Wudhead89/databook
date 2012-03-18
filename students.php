<?php
/*
  Document   : students.php
  Created on : 05-May-2011
  Author     : Richard Williamson
 */
?>

<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}
?>       
<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="utf-8">
        <script src="ajax/stusearch.js" language="javascript" type="text/javascript"></script>
        <!--[if lt IE 9]>
        <script>
        document.createElement("nav");
        document.createElement("header");
        document.createElement("footer");
        </script>
        <![endif]-->   
        <link rel="stylesheet" type="text/css" href="css/stylesheet.css" />
        <link rel="stylesheet" type="text/css" href="css/div.css" />
        <title>Data Book - Students</title>
    </head>

    <body onload="init()" onResize="movepopup()" onClick="clearTable()">
        <div id="container">

            <?php include('header.php'); ?>

            <div id="content-container">

                <?php
                include('config.php');
                include('reports/buildsqlstring.php');

                if (isset($_POST['sen'])) {
                    $sen = $_POST['sen'];
                } else {
                    $sen = array();
                }

                echo "<div id=\"filter\">";
                echo "<form name=\"filter\" action=\"students.php\" method=\"post\">";
                include('reports/filter.php');
                echo "</form>";
                echo "</div>";

                $sqlstring = "SELECT * FROM students";
                $sqlstring .= buildSQLStringNoDataSet();

                $students = mysql_query($sqlstring);

                echo "<div id=\"content\">";
                echo "<h2>Student Browser</h2>";
                echo "<table class=\"contenttable\">
        	<tr>
        	<td>studentid</td>
        	<td>name</td>
        	<td>form</td>
        	<td>year</td>
        	<td>gender</td>	
                <td>sen</td>
                <td>fsm</td>
                <td>lac</td>
        	</tr>";

                while ($row = mysql_fetch_assoc($students)) {
                    echo "<tr>";
                    echo "<td>" . $row['studentid'] . "</td>";
                    echo "<td>" . $row['forename'] . " " . $row['surname'] . "</td>";
                    echo "<td>" . $row['form'] . "</td>";
                    echo "<td>" . $row['year'] . "</td>";
                    echo "<td>" . $row['gender'] . "</td>";
                    echo "<td>" . $row['sen'] . "</td>";
                    echo "<td>" . $row['fsm'] . "</td>";
                    echo "<td>" . $row['lac'] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
                ?>
            </div> <!-- end content -->

        </div> <!-- end content-container -->

        <?php include('footer.php'); ?>

        </div> <!-- end of container -->
    </body>
</html>
