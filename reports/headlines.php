<?php
/*
  Document   : headlines.php
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
        <script src="../ajax/stusearch.js" language="javascript"></script>
        <link rel="stylesheet" type="text/css" href="../css/stylesheet.css" />
        <link rel="stylesheet" type="text/css" href="../css/div.css" />
        <title>Data Book - Headline Figures</title>        
    </head>

    <body onload="init()" onresize="movepopup()">
        <div id="container">

            <?php include('../header.php'); ?>

            <div id="content-container">        

                <?php
                include('../config.php');
                include('functions.php');
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
                echo "<form name=\"filter\" action=\"headlines.php\" method=\"post\">\n";
                include('filter.php');
                echo "</form>\n";
                echo "</div>  <!-- end filter -->\n";

                echo "<div id=\"content\">\n";
                echo "<h2>Headline Figures</h2>\n";

                if (isset($_POST['dataset'])) {
                    $datasetid = $_POST['dataset'];
                    $datasetname = getDataSetName($datasetid);
                    $numresults = getNumResults($datasetid);
                    $numstudents = getNumStudents($datasetid);

                    echo "<p>\n";
                    echo "Dataset Name : " . $datasetname . "<br />";
                    echo "Number of Results : " . $numresults . "<br />";
                    echo "Number of Students : " . $numstudents . "<br />";
                    echo "</p>\n";

                    $fiveaa = 0;
                    $fiveac = 0;
                    $fiveag = 0;
                    $oneaa = 0;
                    $oneac = 0;
                    $oneag = 0;
                    $totalpoints = 0;

                    $results = getResults($datasetid);

                    while ($result = mysql_fetch_assoc($results)) {
                        if ($result['aa'] >= 5) {
                            $fiveaa++;;
                        }
                        if ($result['clevel2'] >= 1) {
                            $fiveac++;
                        }
                        if ($result['clevel1'] >= 1) {
                            $fiveag++;
                        }
                        if ($result['aa'] >= 1) {
                            $oneaa++;
                        }
                        if ($result['ac'] >= 1) {
                            $oneac++;
                        }
                        if ($result['ag'] >= 1) {
                            $oneag++;
                        }
                        $totalpoints += $result['points'];
                    }

                    echo "<p>";
                    echo "Percent 5AA = " . sprintf("%01.2f", (($fiveaa / $numstudents) * 100)) . "% (" . $fiveaa . ")<br />";
                    echo "Percent 5AC = " . sprintf("%01.2f", (($fiveac / $numstudents) * 100)) . "% (" . $fiveac . ")<br />";
                    echo "Percent 5AG = " . sprintf("%01.2f", (($fiveag / $numstudents) * 100)) . "% (" . $fiveag . ")";
                    echo "</p>";
                    echo "<p>";
                    echo "Percent 1AA = " . sprintf("%01.2f", (($oneaa / $numstudents) * 100)) . "% (" . $oneaa . ")<br />";
                    echo "Percent 1AC = " . sprintf("%01.2f", (($oneac / $numstudents) * 100)) . "% (" . $oneac . ")<br />";
                    echo "Percent 1AG = " . sprintf("%01.2f", (($oneag / $numstudents) * 100)) . "% (" . $oneag . ")";
                    echo "</p>";
                    echo "<p>";
                    echo "APS = " . sprintf("%01.2f", ($totalpoints / $numstudents)) . "<br />";
                    echo "</p>";
                    
                }
                ?>
            </div> <!-- end content -->

        </div> <!-- end content-container -->

                <?php include('../footer.php'); ?>

    </div> <!-- end of container -->
</body>
</html>