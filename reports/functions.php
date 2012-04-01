<?php
/* 
    Document   : functions.php
    Created on : 05-May-2011
    Author     : Richard Williamson
*/


// return the name of a dataset
function getDataSetName($datasetid) {
    $results = mysql_query("SELECT datasetname FROM datasets WHERE datasetid='$datasetid'");
    while ($row = mysql_fetch_assoc($results)) {
        $datasetname = $row['datasetname'];
    }
    return $datasetname;
}

// return the name of a dataset
function getDataSetYear($datasetid) {
    $results = mysql_query("SELECT year FROM datasets WHERE datasetid='$datasetid'");
    while ($row = mysql_fetch_assoc($results)) {
        $datasetyear = $row['year'];
    }
    return $datasetyear;
}


// return the name of a student
function getStudentName($studentid) {
    $results = mysql_query("SELECT surname, forename FROM students WHERE studentid='$studentid'");
    while ($row = mysql_fetch_array($results)){
        $studentname = $row['forename'] . " " .$row['surname'];
    }
    return $studentname;
}

// return a students year
function getStudentYear($studentid){
    $results = mysql_query("SELECT year FROM students WHERE studentid='$studentid'");
    while ($row = mysql_fetch_assoc($results)){
        $studentyear = $row['year'];
    }
    return $studentyear;
}

// return the name of a students tutor group 
function getStudentTutorGroup($studentid){
    $results = mysql_query("SELECT form FROM students WHERE studentid='$studentid'");
    while ($row = mysql_fetch_assoc($results)){
        $studentform = $row['form'];
    }
    return $studentform;
}

// return a students FSM status
function getStudentFSM($studentid){
    $results = mysql_query("SELECT fsm FROM students WHERE studentid='$studentid'");
    while ($row = mysql_fetch_assoc($results)){
        $studentfsm = $row['fsm'];
    }
    return $studentfsm;
}

// return a students LAC status
function getStudentLAC($studentid){
    $results = mysql_query("SELECT lac FROM students WHERE studentid='$studentid'");
    while ($row = mysql_fetch_assoc($results)){
        $studentlac = $row['lac'];
    }
    return $studentlac;
}

// return a students CAT scores
function getStudentCAT($studentid){
    $results = mysql_query("SELECT catv, catn, catq, catm FROM students WHERE studentid='$studentid'");
    while ($row = mysql_fetch_assoc($results)){
        $studentcatv = $row['catv'];
        $studentcatn = $row['catn'];
        $studentcatq = $row['catq'];
        $studentcatm = $row['catm'];
    }
    return array("V" => $studentcatv , "N" => $studentcatn , "Q" => $studentcatq ,"M" => $studentcatm);
}

// return a students SEN status
function getStudentSEN($studentid){
    $results = mysql_query("SELECT sen FROM students WHERE studentid='$studentid'");
    while ($row = mysql_fetch_assoc($results)){
        $studentfsm = $row['sen'];
    }
    return $studentfsm;
}

// return the name of a subject
function getSubjectName($subjectid) {
    $results = mysql_query("SELECT subjectname FROM subjects WHERE subjectid='$subjectid'");
    while ($row = mysql_fetch_array($results)){
        $subjectname = $row['subjectname'];
    }
    return $subjectname;
}

// return the number of results in a single dataset
function getNumResults($datasetid) {
    $sqlstring = "SELECT COUNT(resultid) AS results FROM results INNER JOIN students ON results.studentid = students.studentid";
    $sqlstring .= buildSQLStringIncDataSet($datasetid);

    $results = mysql_query($sqlstring);
    while ($row = mysql_fetch_assoc($results)) {
        $numresults = $row['results'];
    }
    return $numresults;
}

// return the number of individual students in a dataset
function getNumStudents($datasetid) {
    $sqlstring = "SELECT COUNT(DISTINCT results.studentid) AS students FROM results INNER JOIN students ON results.studentid = students.studentid";
    $sqlstring .= buildSQLStringIncDataSet($datasetid);

    $results = mysql_query($sqlstring);
    while ($row = mysql_fetch_assoc($results)) {
        $students = $row['students'];
    }
    return $students;
}

// return the number of individual students in a dataset
function getNumStudentsPerYear($year) {
    $sqlstring = "SELECT COUNT(DISTINCT studentid) AS students FROM students";
    $sqlstring .= buildSQLStringNoDataSet();
    if (strpos($sqlstring, "WHERE") === false) {
            $sqlstring .= " WHERE year = '$year'";
        } else {
            $sqlstring .= " AND year = '$year'";
        }
    
    $results = mysql_query($sqlstring);
    while ($row = mysql_fetch_assoc($results)) {
        $students = $row['students'];
    }
    return $students;
}

// return the results table for a dataset
function getResults($datasetid) {
    $sqlstring = "SELECT results.studentid,
                        COUNT(grade) as grades, 
                        SUM(CASE WHEN shortname = 'ENG' AND points >= 40 THEN 1 ELSE 0 END) AS eng,
                        SUM(CASE WHEN shortname = 'MAT' AND points >= 40 THEN 1 ELSE 0 END) AS mat,
                        SUM(CASE WHEN shortname = 'GEO' OR 'HIS' AND points >= 40 THEN 1 ELSE 0 END) as hums,
                        SUM(CASE WHEN shortname = 'FRE' OR 'GER' AND points >= 40 THEN 1 ELSE 0 END) as mfl,
                        SUM(CASE WHEN points >= 52 THEN 1 ELSE 0 END) AS aa,
                        SUM(CASE WHEN points >= 40 THEN 1 ELSE 0 END) AS ac, 
                        SUM(CASE WHEN points >= 16 THEN 1 ELSE 0 END) AS ag,
                        SUM(clevel1) as clevel1,
                        SUM(clevel2) as clevel2,
                        SUM(clevel3) as clevel3,
                        SUM(points) as points 
                    FROM results 
                    INNER JOIN grades ON results.gradeid = grades.gradeid
                    INNER JOIN subjects ON results.subjectid = subjects.subjectid
                    INNER JOIN students ON results.studentid = students.studentid
                    ";
    $sqlstring .= buildSQLStringIncDataSet($datasetid);
    $sqlstring .= " GROUP BY studentid";

    $results = mysql_query($sqlstring);
    return $results;
}


?>