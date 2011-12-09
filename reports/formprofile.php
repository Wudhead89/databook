<?php
/*
  Document   : formprofile.php
  Created on : 05-Dec-2011
  Author     : Richard Williamson
 */
?>

<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit;
}
?>  

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script src="../ajax/stusearch.js" language="javascript"></script>
        <link rel="stylesheet" type="text/css" href="../css/stylesheet.css" />
        <link rel="stylesheet" type="text/css" href="../css/div.css" />
        <title>Data Book - Form Profile</title>     

        <script type="text/javascript">
            function showYear(year)
            {
                if (year=="") {
                    document.getElementById("txtHint").innerHTML="";
                    return;
                } 
                
                if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp=new XMLHttpRequest();
                }
                else {// code for IE6, IE5
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                }
                
                xmlhttp.onreadystatechange=function()
                {
                    //if (xmlhttp.readyState==4 && xmlhttp.status==200)
                    //{
                        document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
                    //}
                }
                xmlhttp.open("GET","../ajax/getforms.php?year="+year,true);
                xmlhttp.send();
            }
        </script>

    </head>

    <body onload="init()" onResize="movepopup()" onClick="clearTable()">
        <div id="container">

            <?php include('../header.php'); ?>

            <div id="content-container">  

                <h2>Form Profile</h2>

                <form>
                    <select name="year" onchange="showYear(this.value)">
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                    </select>
                    <div id="txtHint"><b>Please select a year group</b></div>
                </form>
                
                
                
            </div> <!-- end content-container -->

<?php include('../footer.php'); ?>

        </div> <!-- end of container -->
    </body>
</html>