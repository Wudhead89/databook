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
include('../config.php');
include('functions.php');

$studentid = $_GET['studentid'];
?>  
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <script src="../js/jquery.min.js"></script>
        <script src="../ajax/stusearch.js"></script>
        <script src="../js/corefunctions.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.button').click(function(){
                    var ds = $("#selectdataset").val();
                    var studentid = $("#studenth2").attr('data-studentid');
                    $('#studentgrades').load("ajax/getstudentgrades.php?studentid="+studentid+"&datasetid="+ds);        
                });
            });            
        </script>
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

    <body>
        <div id="container">

            <?php include('../header.php'); ?>

            <div id="content-container">  
                
                <div id="filter">
                    <h3>Filter</h3>
                    <table class="filtertable">
                        <tr>
                            <td>Dataset</td>
                            <td><select id="selectdataset"></select></td>
                        </tr>
                    </table>
                    <a href="#" class="button">
                        <span class="filter">Apply Filter</span>
                    </a>
                </div>  <!-- end filter -->
                
                <div id="content">

                    <?php
                    echo "<h2 id=\"studenth2\" data-studentid=\"$studentid\">Student Report: " . getStudentName($studentid) . "</h2>";

                    echo "Form: " . getStudentTutorGroup($studentid) . "<br>";
                    echo "FSM: " . getStudentFSM($studentid) . "<br>";
                    echo "LAC: " . getStudentLAC($studentid) . "<br>";
                    echo "SEN: " . getStudentSEN($studentid);
                    if (getStudentSEN($studentid) != "N") {
                        echo " <a href=\"stusenreport.php?studentid=" . $studentid . "\">[SEN Report]</a>";
                    }

                    echo "<h4>CATs</h4> ";
                    $stucats = getStudentCAT($studentid);
                    echo "V = " . $stucats['V'] . "<br>";
                    echo "N = " . $stucats['N'] . "<br>";
                    echo "Q = " . $stucats['Q'] . "<br>";
                    echo "M = " . $stucats['M'] . "<br>";
                    ?>
                    
                    <div id="studentgrades"></div>
                    
                </div> <!-- end content -->

            </div> <!-- end content-container -->

<?php include('../footer.php'); ?>

        </div> <!-- end of container -->
    </body>
</html>