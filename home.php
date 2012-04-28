<?php
/*
 * Document     : index.php
 * Created on   : 05-May-2011
 * Author       : Richard Williamson
 * 
 * Description  : Main home page once user has successfully logged in
 */
if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <script src="js/jquery.min.js"></script>
        <script src="ajax/stusearch.js"></script>   
        <script src="js/corefunctions.js"></script>     
        <!--[if lt IE 9]>
        <script>
        document.createElement("nav");
        document.createElement("header");
        document.createElement("footer");
        </script>
        <![endif]-->   
        <link rel="stylesheet" href="css/stylesheet.css" />
        <link rel="stylesheet" href="css/div.css" />
        <title>Data Book - Home</title>
    </head>

    <body onload="init()" onResize="movepopup()" onClick="clearTable()">

        <div id="container">

            <?php include('header.php'); ?>

            <div id="content-container">

                <div id="content">

                    <h2>Welcome ... </h2>

                </div> <!-- end content -->

            </div> <!-- end content-container -->

            <?php include('footer.php'); ?>

        </div> <!-- end of container -->
    </body>
</html>
