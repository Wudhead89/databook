<?php
/*
    Document   : buildsqlstring.php
    Created on : 05-May-2011
    Author     : Richard Williamson
*/

// build an sql string including the datasetid
function buildSQLStringIncDataSet($datasetid = 0) {
    $sqlstring = " WHERE datasetid = '" . $datasetid . "'";
    $sqlstring = buildMainString($sqlstring);
    return $sqlstring;
}

// build an sql string not including the datasetid
function buildSQLStringNoDataSet() {
    $sqlstring = "";
    $sqlstring = buildMainString($sqlstring);
    return $sqlstring;
}

// main function to build the sql string based on the filter options selected by the user
function buildMainString($sqlstring) {
   
    // filter if male
    if ((isset($_POST['male']) && $_POST['male'] == 'ON') && (!isset($_POST['female']))) {
        if (strpos($sqlstring, "WHERE") === false) {
            $sqlstring .= " WHERE students.gender = 'M'";
        } else {
            $sqlstring .= " AND students.gender = 'M'";
        }
    }

    // filter if female
    if ((isset($_POST['female']) && $_POST['female'] == 'ON') && (!isset($_POST['male']))) {
        if (strpos($sqlstring, "WHERE") === false) {
            $sqlstring .= "  WHERE students.gender = 'F'";
        } else {
            $sqlstring .= "  AND students.gender = 'F'";
        }
    }

    // filter on sen status
    if (isset($_POST['sen']) && count($GLOBALS['sen']) == 1) {
        if (strpos($sqlstring, "WHERE") === false) {
            $sqlstring .= " WHERE students.sen = '" . $GLOBALS['sen'][0] . "'";
        } else {
            $sqlstring .= " AND students.sen = '" . $GLOBALS['sen'][0] . "'";
        }
    } elseif (isset($_POST['sen']) && count($GLOBALS['sen']) > 1) {
        if (strpos($sqlstring, "WHERE") === false) {
            $sqlstring .= " WHERE students.sen = '" . $GLOBALS['sen'][0] . "'";
        } else {
            $sqlstring .= " AND (students.sen = '" . $GLOBALS['sen'][0] . "'";
        }

        for ($i = 1; $i < count($GLOBALS['sen']); $i++) {
            $sqlstring .= " OR students.sen = '" . $GLOBALS['sen'][$i] . "'";
        }
        $sqlstring .= ")";
    }

    // filter on fsm status
    if (isset($_POST['fsm']) && $_POST['fsm'] == 'ON') {
        if (strpos($sqlstring, "WHERE") === false) {
            $sqlstring .= " WHERE students.fsm = 'Y'";
        } else {
            $sqlstring .= " AND students.fsm = 'Y'";
        }
    }

    // filter on lac status
    if (isset($_POST['lac']) && $_POST['lac'] == 'ON') {
        if (strpos($sqlstring, "WHERE") === false) {
            $sqlstring .= " WHERE students.lac = 'Y'";
        } else {
            $sqlstring .= " AND students.lac = 'Y'";
        }
    }

    // filter on ma status
    if (isset($_POST['ma']) && $_POST['ma'] == 'ON') {
        if (strpos($sqlstring, "WHERE") === false) {
            $sqlstring .= " WHERE students.catm > 114";
        } else {
            $sqlstring .= " AND students.catm > 114";
        }
    }    
    
    // return the completed sql to the calling function
    return $sqlstring;
}

?>
