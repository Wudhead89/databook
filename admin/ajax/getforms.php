<?php
/*
  Document   : getforms.php
  Created on : 29-02-2012
  Author     : Richard Williamson
 */

$year = $_GET["year"];

include('../../config.php');

$sqlstring = "SELECT DISTINCT form FROM students WHERE year = $year ORDER BY form";

$forms = mysql_query($sqlstring);
echo "<select onchange=\"formSelected(this.value)\">\n";
echo "<option></option>";
while ($row = mysql_fetch_assoc($forms)) {
    echo "<option>" . $row['form'] . "</option>\n";
}
echo "</select>\n";

?>
