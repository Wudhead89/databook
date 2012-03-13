<?php
/*
  Document   : headlines.php
  Created on : 05-May-2011
  Author     : Richard Williamson
 */

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit;
}

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

if (isset($_POST['compset'])) {
    $compsetid = $_POST['compset'];
} else if (isset($_GET['compsetid'])) {
    $compsetid = $_GET['compsetid'];
}

if (isset($_POST['dataset'])) {
    $datasetid = $_POST['dataset'];
    $datasetname = getDataSetName($datasetid);
    $numstudents = getNumStudents($datasetid);

    $stats = array(
        "5AA" => 0,
        "5AC" => 0,
        "5EM" => 0,
        "5AG" => 0,
        "1AC" => 0,
        "1AG" => 0,
        "Total Points" => 0
    );

    $results = getResults($datasetid);

    while ($result = mysql_fetch_assoc($results)) {
        if ($result['aa'] >= 5) {
            $stats['5AA']++;
        }
        if ($result['clevel2'] >= 1) {
            $stats['5AC']++;
        }
        if ($result['eng'] == 1 && $result['mat'] == 1) {
            $stats['5EM']++;
        }
        if ($result['clevel1'] >= 1) {
            $stats['5AG']++;
        }
        if ($result['ac'] >= 1) {
            $stats['1AC']++;
        }
        if ($result['ag'] >= 1) {
            $stats['1AG']++;
        }

        $stats['Total Points'] += $result['points'];
    }

    foreach ($stats as $k => $v) {
        if ($k == 'Total Points') {
            $stats[$k] = sprintf("%01.2f", ($v / $numstudents));
        } else {
            $stats[$k] = sprintf("%01.2f", (($v / $numstudents) * 100));
        }
    }

    if (isset($_POST['compset']) && $_POST['compset'] != "") {
        $compsetid = $_POST['compset'];
        $compsetname = getDataSetName($compsetid);
        $compnumstudents = getNumStudents($compsetid);

        $compStats = array(
            "5AA" => 0,
            "5AC" => 0,
            "5EM" => 0,
            "5AG" => 0,
            "1AC" => 0,
            "1AG" => 0,
            "Total Points" => 0
        );

        $results = getResults($compsetid);

        while ($result = mysql_fetch_assoc($results)) {
            if ($result['aa'] >= 5) {
                $compStats['5AA']++;
            }
            if ($result['clevel2'] >= 1) {
                $compStats['5AC']++;
            }
            if ($result['eng'] == 1 && $result['mat'] == 1) {
                $compStats['5EM']++;
            }
            if ($result['clevel1'] >= 1) {
                $compStats['5AG']++;
            }
            if ($result['ac'] >= 1) {
                $compStats['1AC']++;
            }
            if ($result['ag'] >= 1) {
                $compStats['1AG']++;
            }

            $compStats['Total Points'] += $result['points'];
        }

        foreach ($compStats as $k => $v) {
            if ($k == 'Total Points') {
                $compStats[$k] = sprintf("%01.2f", ($v / $numstudents));
            } else {
                $compStats[$k] = sprintf("%01.2f", (($v / $numstudents) * 100));
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="utf-8">
        <script src="../ajax/stusearch.js"></script>
        <script src="../js/jquery.min.js"></script>
        <script src="../js/highcharts.js"></script>   
        <!--[if lt IE 9]>
        <script>
        document.createElement("nav");
        document.createElement("header");
        document.createElement("footer");
        </script>
        <![endif]-->           
        <link rel="stylesheet" href="../css/stylesheet.css" />
        <link rel="stylesheet" href="../css/div.css" />

        <?php
        if (isset($_POST['dataset'])) {
            echo "            
            <script type=\"text/javascript\">

                var chart;
                $(document).ready(function() {
                    chart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'graph',
                            defaultSeriesType: 'column',
                            marginRight: 140,
                        },
                        title: {
                            text: 'GCSE Headline Figures'
                        },
                        xAxis: {
                            categories: [
                                '5AA', 
                                '5AC', 
                                '5EM', 
                                '5AG',
                                '1AC',
                                '1AG'
                            ]
                        },
                        yAxis: {
                            min: 0,
                            max: 100,
                            title: {
                                text: 'Percentage'
                            }
                        },
                        legend: {
                            layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'top',
                            x: -20,
                            y: 100,
                            borderWidth: 0
                        },
                        tooltip: {
                            formatter: function() {
                                return this.y +'%';
                            }
                        },
                        plotOptions: {
                            column: {
                                pointPadding: 0.06,
                                borderWidth: 0
                            }
                        },
                        series: [{
                                name: '$datasetname',
                                data: [" . $stats['5AA'] . "," . $stats['5AC'] . "," . $stats['5EM'] . "," . $stats['5AG'] . "," . $stats['1AC'] . "," . $stats['1AG'] . "]
                            }";
            if (isset($_POST['compset']) && $_POST['compset'] != "") {
                echo ",{ name: '$compsetname',
                                data: [" . $compStats['5AA'] . "," . $compStats['5AC'] . "," . $compStats['5EM'] . "," . $compStats['5AG'] . "," . $compStats['1AC'] . "," . $compStats['1AG'] . "]}";
            }
            echo "]
                    });


                });

            </script>           
            ";
        }
        ?>

        <title>Data Book - Headline Figures</title>        
    </head>

    <body onload="init()" onresize="movepopup()">
        <div id="container">

            <?php include('../header.php'); ?>

            <div id="content-container">        

                <?php
                echo "<div id=\"filter\">\n";
                echo "<form name=\"filter\" action=\"headlines.php\" method=\"post\">\n";
                include('filter.php');
                echo "</form>\n";
                echo "</div>  <!-- end filter -->\n";

                echo "<div id=\"content\">\n";
                echo "<h2>Headline Figures</h2>\n";

                if (isset($_POST['dataset'])) {
                    echo "<table class=\"contenttable\">\n";

                    echo "<tr>\n";
                    echo "<td>Indicator</td>\n";
                    echo "<td>$datasetname</td>\n";
                    if (isset($_POST['compset']) && $_POST['compset'] != "") {
                        echo "<td>" . $compsetname . "</td>";
                    }
                    echo "</tr>\n";

                    echo "<tr>\n";
                    echo "<td>Number of Students</td>\n";
                    echo "<td>$numstudents</td>\n";
                    if (isset($_POST['compset']) && $_POST['compset'] != "") {
                        echo "<td>" . $compnumstudents . "</td>";
                    }
                    echo "</tr>\n";
                    
                    echo "<tr>\n";
                    echo "<td>5AA</td>\n";
                    echo "<td>" . $stats['5AA'] . "</td>\n";
                    if (isset($_POST['compset']) && $_POST['compset'] != "") {
                        echo "<td>" . $compStats['5AA'] . "</td>";
                    }
                    echo "</tr>\n";
                    
                    echo "<tr>\n";
                    echo "<td>5AC</td>\n";
                    echo "<td>" . $stats['5AC'] . "</td>\n";
                    if (isset($_POST['compset']) && $_POST['compset'] != "") {
                        echo "<td>" . $compStats['5AC'] . "</td>";
                    }
                    echo "</tr>\n";
                    
                    echo "<tr>\n";
                    echo "<td>5EM</td>\n";
                    echo "<td>" . $stats['5EM'] . "</td>\n";
                    if (isset($_POST['compset']) && $_POST['compset'] != "") {
                        echo "<td>" . $compStats['5EM'] . "</td>";
                    }
                    echo "</tr>\n";
                    
                    echo "<tr>\n";
                    echo "<td>1AC</td>\n";
                    echo "<td>" . $stats['1AC'] . "</td>\n";
                    if (isset($_POST['compset']) && $_POST['compset'] != "") {
                        echo "<td>" . $compStats['1AC'] . "</td>";
                    }
                    echo "</tr>\n";

                    echo "<tr>\n";
                    echo "<td>1AG</td>\n";
                    echo "<td>" . $stats['1AG'] . "</td>\n";
                    if (isset($_POST['compset']) && $_POST['compset'] != "") {
                        echo "<td>" . $compStats['1AG'] . "</td>";
                    }
                    echo "</tr>\n";
                    
                    echo "</table>\n";
                }
                ?>

                <div id="graph" style="width: 100%; height: 350px; margin-top: 20px;"></div>
            </div> <!-- end content -->

        </div> <!-- end content-container -->

<?php include('../footer.php'); ?>

    </div> <!-- end of container -->

</body>
</html>