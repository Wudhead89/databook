<?php
/*
    Document   : filter.php
    Created on : 05-May-2011
    Author     : Richard Williamson
*/
?>

<h3>Filter</h3>

<table class="filtertable">
    <tr>
        <td>Dataset</td>
        <td>    
            <select name="dataset">
                <?php
                $datasets = mysql_query("SELECT * FROM datasets");
                while ($ds = mysql_fetch_assoc($datasets)) {
                    echo "<option value=\"" . $ds['datasetid'] . "\"";
                    if (isset($datasetid) && $datasetid == $ds['datasetid']) { echo " selected "; }
                    echo ">" . $ds['datasetname'] . "</option>";
                }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td>Compare</td>
        <td>    
            <select name="compset">
                <option value=""></option>
                <?php
                $datasets = mysql_query("SELECT * FROM datasets");
                while ($ds = mysql_fetch_assoc($datasets)) {
                    echo "<option value=\"" . $ds['datasetid'] . "\"";
                    if (isset($compsetid) && $compsetid == $ds['datasetid']) { echo " selected "; }
                    echo ">" . $ds['datasetname'] . "</option>";
                }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td>Gender</td>
        <td>
            M <input type="checkbox" name="male" value="ON" <?php if ((isset($_POST['male']) && $_POST['male'] == 'ON')) { echo 'checked = "checked"'; } ?> />&nbsp;
            F <input type="checkbox" name="female" value="ON" <?php if ((isset($_POST['female']) && $_POST['female'] == 'ON')) { echo 'checked = "checked"'; } ?> />
        </td>
    </tr>
    <tr>
        <td>SEN</td>
        <td>
            N <input type="checkbox" name="sen[]" value="N" <?php if (in_array("N", $sen)) { echo ' checked'; } ?> />
            S <input type="checkbox" name="sen[]" value="S" <?php if (in_array("S", $sen)) { echo ' checked'; } ?> /> <br />
            P <input type="checkbox" name="sen[]" value="P" <?php if (in_array("P", $sen)) { echo ' checked'; } ?> />
            A <input type="checkbox" name="sen[]" value="A" <?php if (in_array("A", $sen)) { echo ' checked'; } ?> />
        </td>
    </tr>
    <tr>
        <td>FSM</td>
        <td>
            <input type="checkbox" name="fsm" value="ON" <?php if ((isset($_POST['fsm']) && $_POST['fsm'] == 'ON')) { echo 'checked = "checked"'; } ?> />
        </td>
    </tr>
    <tr>
        <td>LAC</td>
        <td>
            <input type="checkbox" name="lac" value="ON" <?php if ((isset($_POST['lac']) && $_POST['lac'] == 'ON')) { echo 'checked = "checked"'; } ?> />
        </td>
    </tr>
    <tr>
        <td>MA</td>
        <td>
            <input type="checkbox" name="ma" value="ON" <?php if ((isset($_POST['ma']) && $_POST['ma'] == 'ON')) { echo 'checked = "checked"'; } ?> />
        </td>
    </tr>
</table>

<a href="#" class="button" onclick="document.forms['filter'].submit(); return false;">
<span class="filter">Apply Filter</span>
</a>