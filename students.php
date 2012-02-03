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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <script src="ajax/stusearch.js" language="javascript" type="text/javascript"></script>
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

                echo "<div id=\"filter\">\n";
                echo "<form name=\"filter\" action=\"students.php\" method=\"post\">\n";
                include('reports/filter.php');
                echo "</form>\n";
                echo "</div>\n";

                $sqlstring = "SELECT * FROM students";
                $sqlstring .= buildSQLStringNoDataSet();

                $students = mysql_query($sqlstring);

                echo "<div id=\"content\">\n";
                echo "<h2>Student Browser</h2>\n";
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
                    echo "<tr>\n";
                    echo "<td>" . $row['studentid'] . "</td>\n";
                    echo "<td>" . $row['forename'] . " " . $row['surname'] . "</td>\n";
                    echo "<td>" . $row['form'] . "</td>\n";
                    echo "<td>" . $row['year'] . "</td>\n";
                    echo "<td>" . $row['gender'] . "</td>\n";
                    echo "<td>" . $row['sen'] . "</td>\n";
                    echo "<td>" . $row['fsm'] . "</td>\n";
                    echo "<td>" . $row['lac'] . "</td>\n";
                    echo "</tr>\n";
                }

                echo "</table>\n";
                ?>
            </div> <!-- end content -->

        </div> <!-- end content-container -->

        <?php include('footer.php'); ?>

        </div> <!-- end of container -->
    </body>
</html>
