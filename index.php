<?php
/*
  Document   : index.php
  Created on : 05-May-2011
  Author     : Richard Williamson
 */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <script src="ajax/login.js" language="javascript" type="text/javascript"></script>
        <script src="ajax/stusearch.js" language="javascript" type="text/javascript"></script>
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
                        contact Richard Williamson on rwi@swanwickhall.derbyshire.sch.uk or dial ext 142. Thank You.
                    </p>

                </div> <!-- end content -->

            </div> <!-- end content-container -->

            <?php include('footer.php'); ?>

        </div> <!-- end of container -->
    </body>
</html>
