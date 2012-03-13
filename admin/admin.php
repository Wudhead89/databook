<?php
/*
  Document   : admin.php
  Created on : 29-Feb-2012
  Author     : Richard Williamson
 */
?>
<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="utf-8">
        <script src="../ajax/stusearch.js"></script>
        <script src="../js/jquery.min.js"></script>      
        <!--[if lt IE 9]>
        <script>
        document.createElement("nav");
        document.createElement("header");
        document.createElement("footer");
        </script>
        <![endif]-->          
        <link rel="stylesheet" href="../css/stylesheet.css" />
        <link rel="stylesheet" href="../css/div.css" />
        <title>Data Book - Admin</title>
    </head>
    
    <body onload="init()" onResize="movepopup()" onClick="clearTable()">

        <div id="container">

            <?php include('../header.php'); ?>

            <div id="content-container">

                <div id="filter">
                    <?php include('adminmenu.php'); ?>
                </div>
                
                <div id="content">

                    <h2>Admin</h2>
                   
                </div> <!-- end content -->

            </div> <!-- end content-container -->

            <?php include('../footer.php'); ?>

        </div> <!-- end of container -->
    </body>
</html>