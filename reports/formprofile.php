<?php
/*
  Document   : formprofile.php
  Created on : 05-Dec-2011
  Author     : Richard Williamson
 */

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit;
}
?>  
<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="utf-8">
        <script src="../js/jquery.min.js"></script>
        <script src="../ajax/getforms.js"></script>
        <script src="../ajax/stusearch.js"></script>
        <script src="js/corefunctions.js"></script>
        <!--[if lt IE 9]>
        <script>
        document.createElement("nav");
        document.createElement("header");
        document.createElement("footer");
        </script>
        <![endif]-->   
        <link rel="stylesheet" href="../css/stylesheet.css" />
        <link rel="stylesheet" href="../css/div.css" />
        <title>Data Book - Form Profile</title> 
    </head>

    <body>
        <div id="container">

            <?php include('../header.php'); ?>

            <div id="content-container">  

                <h2>Form Profile</h2>

                <form>
                    <div id="selector">
                        <div id ="selectYear">
                            <select name="year" onchange="showYear(this.value)">
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                            </select>
                        </div>
                        <div id="selectForm"></div>
                        
                    </div>
                </form>

                <div id="formProfile">
                </div>
                
            </div> <!-- end content-container -->

            <?php include('../footer.php'); ?>

        </div> <!-- end of container -->
    </body>
</html>