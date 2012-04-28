<?php
/*
 * Document     : header.php
 * Created on   : 05-May-2011
 * Author       : Richard Williamson
 * 
 * Description  : Defines the default html header for all project files
 */
if (!isset($_SESSION)) {
    session_start();
}
?>
<header>
    
    <!-- main site header -->
    <h1>Swanwick <span class="red">Hall</span> School Databook</h1>

    <!-- display current user and login out link -->
    <div id="logindetails">
        <?php echo $_SESSION['name']; ?> 
        <a href="/databook/logout.php">[logout]</a>
    </div>

    <!-- navigation menu -->
    <nav>
        <ul>
            <li><a href="/databook/home.php">Home</a></li>
            <li><a href="/databook/reports/headlines.php">Headlines</a></li>
            <li><a href="/databook/reports/ebacc.php">EBacc</a></li>
            <li><a href="/databook/reports/subbroadsheet.php">Subjects</a></li>
            <li><a href="/databook/reports/dsbroadsheet.php">Broadsheet</a></li>
            <li><a href="/databook/reports/formprofile.php">Form Profile</a></li>
            <li><a href="/databook/reports/groupdata.php">Group Data</a></li>
            <li><a href="/databook/docs/docs.php">Documents</a></li>

            <?php
            
            // if the user type is "admin" then display the admin menu option
            if (isset($_SESSION['type']) && $_SESSION['type'] == 'admin') {
                echo "<li><a href=\"/databook/admin/admin.php\">Admin</a></li>";
            }
            
            ?>

        </ul>

        <!-- student search field -->
        <form name="autofillform" action="/databook/ajax/stusearch.php">
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
        
    </nav>

</header>