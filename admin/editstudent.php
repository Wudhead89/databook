<?php
/*
  Document   : editstudent.php
  Created on : 29-Feb-2012
  Author     : Richard Williamson
 */

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="utf-8">
        <script src="../js/jquery.min.js"></script>
        <script src="../ajax/stusearch.js"></script>
        <script src="../js/corefunctions.js"></script>     
        <script src="ajax/editstudents.js"></script>
        <!--[if lt IE 9]>
        <script>
        document.createElement("nav");
        document.createElement("header");
        document.createElement("footer");
        </script>
        <![endif]-->          
        <link rel="stylesheet" href="../css/stylesheet.css" />
        <link rel="stylesheet" href="../css/div.css" />
        <title>Data Book - Edit Student</title>
    </head>

    <body>

        <div id="container">

            <?php include('../header.php'); ?>

            <div id="content-container">

                <div id="filter">
                    <?php include('adminmenu.php'); ?>
                </div>

                <div id="content">

                    <h2>Find a student to edit</h2>
                    <form>
                        <div id="selector">
                            <div id="selectYear">
                                <select id="year">
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

                    <div id="studenteditor">
                        <div id="selectStudent"></div>
                        <div id="editStudent"></div>
                    </div>
                    
                </div> <!-- end content -->

            </div> <!-- end content-container -->

            <?php include('../footer.php'); ?>

        </div> <!-- end of container -->
    </body>
</html>