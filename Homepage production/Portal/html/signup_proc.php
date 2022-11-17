<?php include "../inc/eclassinfo.inc";
    session_start();
    if (isset($_SESSION["userid"])) echo "<script>alert('이미 로그인 상태입니다.'); history.back();</script>";
    $stud_prof_id = $_POST["stud_prof_id"];
    $id = $_POST["id"];
    $pw = $_POST["pw"];
    $pw_check = $_POST["pw_check"];
    $flag = $_POST["stud_prof_flag"];
    if(!is_null($stud_prof_id) && !is_null($id) && !is_null($pw) && !is_null($pw_check) && !is_null($flag)) {
        if($pw != $pw_check) echo "<script>alert('비밀번호 확인 실패'); history.go(-2);</script>";
        else{
            $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
            if(mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();
            if($flag === "professor") {
                $query = "SELECT id FROM prof_mem WHERE id = '$id';";
                $query_test = "SELECT id FROM stud_mem WHERE id = '$id'";
                $query2 = "INSERT INTO prof_mem (call_num, id, pw) VALUES ('$stud_prof_id', '$id', '$pw');";
            }
            else {
                $query = "SELECT id FROM stud_mem WHERE id = '$id';";
                $query_test = "SELECT id FROM prof_mem WHERE id = '$id'";
                $query2 = "INSERT INTO stud_mem (stud_id, id, pw) VALUES ('$stud_id', '$id', '$pw');";
            }
            $select = mysqli_query($connection, $query);
            while($row = mysqli_fetch_array($select)) {
                $id_check = $row['id'];
            }
            if($id == $id_check) echo '<script>alert("ID 중복"); history.go(-2);</script>';
            $select_test = mysqli_query($connection, $query_test);
            while($row_test = mysqli_fetch_array($select_test)) {
                $id_check_test = $row_test['id'];
            }
            if($id == $id_check_test) echo '<script>alert("ID 중복"); history.back();</script>';
            else {
                $insert = mysqli_query($connection, $query2);
                echo "<script>alert('회원가입 성공'); document.location.href='login.php'</script>";
            }
        }
    } else echo "<script>alert('정상적인 접근이 아닙니다.'); history.back();</script>";
?>
