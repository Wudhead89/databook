<?php
/*
  Document   : index.php
  Created on : 05-May-2011
  Author     : Richard Williamson
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
        <script src="ajax/login.js"></script>
        <script src="ajax/stusearch.js"></script>        
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
                    
                    <?php
                    if (isset($_SESSION['name'])) {
                        echo "<h2>Welcome</h2>";
                        echo "<p>
                                Welcome to Swanwick Hall databook ...
                             </p>";
                    } else {
                        echo "<div id=\"login\">";
                        echo "<h2>Please login</h2>";
                        echo "<table id=\"logintable\">";
                        echo "<tr>";
                        echo "<td>username: </td>";
                        echo "<td><input type=\"text\" id=\"username\" class=\"textinput\" autocomplete=\"off\" /></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td>password: </td>";
                        echo "<td><input type=\"password\" id=\"password\" class=\"textinput\" autocomplete=\"off\" /></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td></td>";
                        echo "<td><a href=\"#\" id=\"loginImg\" />[login]</a></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td></td>";
                        echo "<td><div id=\"login_response\"></div></td>";
                        echo "</tr>";
                        echo "</table>";
                        echo "</div>";
                    }
                    ?>

                </div> <!-- end content -->

            </div> <!-- end content-container -->

            <?php include('footer.php'); ?>

        </div> <!-- end of container -->
    </body>
</html>
