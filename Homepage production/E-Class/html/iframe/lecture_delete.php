<?php
    include "../../inc/eclassinfo.inc";
    include "../member/stud_prof_flag.php";

    session_start();
    $num = $_GET['num'];
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    if(mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();
    $selquery = "SELECT * FROM lecture WHERE num=$num;";
    $select = mysqli_query($connection, $selquery);
    $row =  mysqli_fetch_array($select);
    
    if (isset($_SESSION["userid"])) {
        $id = $_SESSION['userid'];
        $flag = stud_or_prof($id);

        if ($flag[1] == "professor" && $flag[0] == $row['writer']) {
            $query = "DELETE FROM lecture WHERE num=$num;";
			$delete = mysqli_query($connection, $query);
            echo '<script>alert("삭제 완료"); document.location.href="lecture.php";</script>';
        } else {
            echo '<script>alert("권한 부족"); history.back();</script>';
        }
    }
?>