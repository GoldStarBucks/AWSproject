<?php
    include "../inc/eclassinfo.inc";
    function stud_or_prof($id) {
        $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        $query = "SELECT name FROM student WHERE student_id = (SELECT stud_id FROM stud_mem WHERE id='$id');";
        $query2 = "SELECT name FROM professor WHERE call_num = (SELECT call_num FROM prof_mem WHERE id='$id');";
        $select = mysqli_query($connection, $query);
        $select2 = mysqli_query($connection, $query2);
        $row = mysqli_fetch_array($select);
        $row2 = mysqli_fetch_array($select2);
        if($row[0] !='' && $row2[0] == ''){
            $flag = array();
            $flag[0] = $row['name'];
            $flag[1] = 'student';
            return $flag;
        } elseif($row[0] =='' && $row2[0] != '') {
            $flag = array();
            $flag[0] = $row2['name'];
            $flag[1] = 'professor';
            return $flag;
        } else {
            return -1;
        }
    }
?>
