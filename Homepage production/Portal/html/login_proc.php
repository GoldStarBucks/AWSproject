<?php include "../inc/eclassinfo.inc";
	session_start();
    if (isset($_SESSION["userid"])) echo "<script>alert('이미 로그인 상태입니다.'); history.back();</script>";
    $id = $_POST["id"];
    $pw = $_POST["pw"];
    $stat = $_POST["stud_prof"];
    if(!is_null($id) && !is_null($pw) && !is_null($stat)) {
        $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        if(mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();
        if($stat == "prof") $mem = "prof_mem";
        else $mem = "stud_mem";
        $query = "SELECT id, pw FROM $mem WHERE id='$id'";
        $select = mysqli_query($connection, $query);
        if(mysqli_num_rows($select)==1){
            $row = mysqli_fetch_array($select);
            echo $row['id'];
            echo $row['pw'];
            if($row['pw'] == $pw) {
                $_SESSION['userid'] = $row['id'];
                if(isset($_SESSION['userid'])){
                    echo '<script>alert("로그인 성공"); document.location.href="portal_main.php";</script>';
                } else echo '<script>alert("로그인 실패"); history.back();</script>';
            } else echo '<script>alert("로그인 실패"); history.back();</script>';
        } else echo '<script>alert("로그인 실패"); history.back();</script>';
    } else echo '<script>alert("정상적인 접근이 아닙니다."); history.back();</script>';
?>