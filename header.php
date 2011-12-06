<?php
/*
  Document   : header.php
  Created on : 05-May-2011
  Author     : Richard Williamson
*/
?>

<div id="header">
    <h1>Swanwick Hall School Data Book</h1>

    <div id="login">
        <?php
        if (!isset($_SESSION)) {
            session_start();
        }

        if (isset($_SESSION['name'])) {
            echo $_SESSION['name'] . " <a href=\"/netbeans/databook/logout.php\">[logout]</a>";
            $currentds = '2011/2012';
            
        } else {
            // call the javascript function "login" into ajax_framework.js
            echo "<form action=\"javascript:login()\" method=\"post\">\n";
            echo "<table class=\"logintable\">\n";
            echo "<tr>\n";
            echo "<td>username</td><td>password</td><td></td>";
            echo "</tr>\n";
            echo "<tr>\n";
            echo "<td><input name=\"username\" type=\"text\" id=\"username\" class=\"textinput\" autocomplete=\"off\" /></td>\n";
            echo "<td><input name=\"password\" type=\"password\" id=\"password\" class=\"textinput\" autocomplete=\"off\" /></td>\n";
            echo "<td><input type=\"submit\" name=\"Submit\" value=\"login\" class=\"buttoninput\" /></td>\n";
            echo "</tr>\n";
            echo "</table>\n";
            echo "</form>\n";
        }
        ?>
    </div>
    <div id="login_response">
    </div>
</div> <!--end header-->

<div id="navigation">
    <ul>
        <li><a href="/NetBeans/DataBook/index.php">Home</a></li>
        <li><a href="/NetBeans/DataBook/reports/headlines.php">Headlines</a></li>
        <li><a href="/NetBeans/DataBook/reports/subbroadsheet.php">Subjects</a></li>
        <li><a href="/NetBeans/DataBook/reports/stubroadsheet.php">Broadsheet</a></li>
        <li><a href="/NetBeans/DataBook/students.php">Students</a></li>
        <li><a href="/NetBeans/DataBook/reports/formprofile.php">Form Profile</a></li>
    </ul>
    
    <form name="autofillform" action="/NetBeans/DataBook/ajax/autocomplete.php">
        <div id="search">
        <table>
            <tr>
                <td>Student Search</td>
                <td><input type="text" id="complete-field" onkeyup="doCompletion();" autocomplete="off" /></td>
                <td id="auto-row"></td>
            </tr>
        </table>
        </div>   
    </form> 
    
</div> <!--end navigation-->