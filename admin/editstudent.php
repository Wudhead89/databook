<?php
/*
  Document   : editstudent.php
  Created on : 29-Feb-2012
  Author     : Richard Williamson
 */
?>

<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../../index.php");
    exit;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <script src="../ajax/stusearch.js" language="javascript" type="text/javascript"></script>       
        <script src="ajax/getforms.js" language="javascript" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="../css/stylesheet.css" />
        <link rel="stylesheet" type="text/css" href="../css/div.css" />
        <title>Data Book - Edit Student</title>
    </head>
    
    <body onload="init()" onResize="movepopup()" onClick="clearTable()">

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
                                <div id ="selectYear">
                                    <select name="year" onchange="getForms(this.value)">
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
                    <div id="selectStudent"></div>
                </div> <!-- end content -->

            </div> <!-- end content-container -->

            <?php include('../footer.php'); ?>

        </div> <!-- end of container -->
    </body>
</html>