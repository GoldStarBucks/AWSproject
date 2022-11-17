<?php include "../../inc/eclassinfo.inc";
    session_start();
    if (isset($_SESSION["userid"])) echo "<script>alert('이미 로그인 상태입니다.'); history.back();</script>";
    $name = $_POST["name"];
    $birth = $_POST["birth"];
    $stud_id = $_POST["stud_id"];
    $prof_id = $_POST["prof_id"];
    if(!is_null($name) && !is_null($birth) && ($stud_id !== '' || $prof_id !== '')) {
        if($prof_id) {
            $table = "professor";
            $tab = "prof";
            $col_id = $prof_id;
            $text_id = "전화번호";
            $column = "call_num";
            $column2 = $column;
        }
        elseif ($stud_id) {
            $table = "student";
            $tab = "stud";
            $col_id = $stud_id;
            $text_id = "학번";
            $column = $table . "_id";
            $column2 = $tab . "_id";
        }
        $query = "SELECT $column FROM $table WHERE name = '$name' and birth = '$birth' and $column = '$col_id';";
        $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        if(mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();
        $select = mysqli_query($connection, $query);
        if(!$select) echo("<p>Error adding users data.</p>");
        $row = mysqli_fetch_array($select);
        if(!$row[$column]) echo("<script>alert('인증에 실패했습니다.'); history.back();</script>");
        $tab_mem = $tab . '_mem';
        $query2 = "SELECT * FROM $tab_mem WHERE $column2 = '$col_id';";
        $select2 = mysqli_query($connection, $query2);
        $row2 = mysqli_fetch_array($select2);
        if($row2['id'] != '') echo "<script>alert('이미 회원가입을 하셨습니다.'); location.href='/board/main.php';</script>";
    }
    else {
        echo '<script>alert("정상적인 접근이 아닙니다."); history.back();</script>';
    }
?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, height=device-height, minimum-scale=1.0, maximum-scale=1.0, initial-scale=1.0">
        <link rel="stylesheet" href="./css/signup.css">
    </head>
    <body>
        <div class="signupform">
        <section class="signup-form">
        <header>
            <h1>회원가입</h1>
        </header>
        <form action="signup_proc.php" method="POST">
            <p>성명 : <?php echo $name; ?></p>
            <div class="int-area">
            <?php
                echo "<input id='stud_prof_id' type='text' name='stud_prof_id' value='$row[$column]' readonly><label for='stud_prof_id'>$text_id</label>";
                echo "<input id='stud_prof_flag' type=text name='stud_prof_flag' value ='$table' style='display:none'>";
            ?>
            </div>
            <div class="int-area">
                <input id="id" type="text" name="id" required>
                <label for="id">아이디</label>
            </div>
            <div class="int-area">
                <input id="pw" type="password" name="pw" required>
                <label for="pw">패스워드</label>
            </div>
            <div class="int-area">
                <input id="pw_check" type="password" name="pw_check" required>
                <label for="pw_check">패스워드 확인</label>
            </div>
            <div class="btn-area">
                <button id="btn" type="submit">Login</button><br>
                <a href="./login.php">로그인</a>
                <a href="../board/main.php">홈페이지</a>
            </div>
        </form>
        </section>
        <div>
    </body>
</html>
