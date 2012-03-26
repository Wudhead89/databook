<?php
/*
  Document   : header.php
  Created on : 05-May-2011
  Author     : Richard Williamson
 */
if (!isset($_SESSION)) {
    session_start();
}
?>
<header>
    <h1>Swanwick <span class="red">Hall</span> School Data Book</h1>

    <div id="logindetails">
        <?php
        if (isset($_SESSION['name'])) {
            echo $_SESSION['name'] . " <a href=\"/databook/logout.php\">[logout]</a>";
        }
        ?>
    </div>

    <nav>
        <ul>
            <li><a href="/databook/index.php">Home</a></li>
            <li><a href="/databook/reports/headlines.php">Headlines</a></li>
            <li><a href="/databook/reports/ebacc.php">EBacc</a></li>
            <li><a href="/databook/reports/subbroadsheet.php">Subjects</a></li>
            <li><a href="/databook/reports/stubroadsheet.php">Broadsheet</a></li>
            <li><a href="/databook/reports/formprofile.php">Form Profile</a></li>
            <li><a href="/databook/reports/groupdata.php">Group Data</a></li>
            <li><a href="/databook/docs/docs.php">Documents</a></li>
            
            <?php
            if (isset($_SESSION['type']) && $_SESSION['type'] == 'admin') {
                echo "<li><a href=\"/databook/admin/admin.php\">Admin</a></li>";
            }
            ?>
            
        </ul>

        <?php
        if (isset($_SESSION['name'])) {
            echo "<form name=\"autofillform\" action=\"/databook/ajax/stusearch.php\">";
            echo "<div id=\"search\">";
            echo "<table>";
            echo "<tr>";
            echo "<td>Student Search</td>";
            echo "<td><input type=\"text\" onkeyup=\"doCompletion();\" autocomplete=\"off\" /></td>";
            echo "<td id=\"auto-row\"></td>";
            echo "</tr>";
            echo "</table>";
            echo "</div>";
            echo "</form>";
        }
        ?>
    </nav>

</header>