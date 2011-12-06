<?php
/*
  Document   : index.php
  Created on : 05-May-2011
  Author     : Richard Williamson
 */
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script src="ajax/ajax_framework.js" language="javascript"></script>
        <script src="ajax/javascript.js" language="javascript"></script>
        <link rel="stylesheet" type="text/css" href="css/stylesheet.css" />
        <link rel="stylesheet" type="text/css" href="css/div.css" />
        <title>Data Book - Home</title>
    </head>
    
    <body onload="init()" onResize="movepopup()" onClick="clearTable()">

        <div id="container">

            <?php include('header.php'); ?>

            <div id="content-container">

                <div id="content">

                    <h2>Welcome</h2>
                   
                    <p>
                        To navigate the site please log in by entering your details above. If you are experiencing any difficulties please 
                        contact Richard Williamson on rwi@swanwickhall.derbyshire.sch.uk or dial ext 108. Thank You.
                    </p>

                </div> <!-- end content -->

            </div> <!-- end content-container -->

            <?php include('footer.php'); ?>

        </div> <!-- end of container -->
    </body>
</html>