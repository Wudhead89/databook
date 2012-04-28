<?php
/*
  Document   : dsbroadsheet.php
  Created on : 05-May-2011
  Author     : Richard Williamson
 */

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit;
}
include('../config.php');
?>  
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <script src="../js/jquery.min.js"></script>
        <script src="../ajax/stusearch.js"></script>
        <script src="js/corefunctions.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.button').click(function(){
                    var ds = $(".selectdataset").val();
                    $.post("ajax/getdsbroadsheet.php?dataset="+ds, function(data){
                        var win = window.open();
                        win.document.write(data);
                        win.document.close();
                    });
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
        <title>Data Book - Student Broadsheet</title>
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
                            <td>    
                                <select name="dataset" class="selectdataset">
                                    <?php
                                    $datasets = mysql_query("SELECT * FROM datasets");
                                    while ($ds = mysql_fetch_assoc($datasets)) {
                                        echo "<option value=\"" . $ds['datasetid'] . "\"";
                                        if (isset($datasetid) && $datasetid == $ds['datasetid']) {
                                            echo " selected ";
                                        }
                                        echo ">" . $ds['datasetname'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                    </table>

                    <a href="#" class="button">
                        <span class="filter">Apply Filter</span>
                    </a>
                </div>

                <div id="content">
                    <h2>Dataset Broadsheet</h2>
                    <p>Using the filter on the left of the page select a dataset and a broadsheet of results against students will appear in a new window.</p>
                    <p>Students will appear alphabetically from top to bottom.</p>
                    <p>Subject will appear alphabetically from left to right.</p>
                </div> <!-- end content -->

            </div> <!-- end content-container -->

            <?php include('../footer.php'); ?>

        </div> <!-- end of container -->
    </body>
</html>