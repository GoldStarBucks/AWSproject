<?php include "../../inc/eclassinfo.inc";
    session_start();
    if (isset($_SESSION["userid"])) echo "<script>alert('이미 로그인 상태입니다.'); history.back();</script>";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="../css/auth.css">
    </head>
    <body>
        <div class="authform">
        <section class="auth-form">
        <header>
            <div id="stud_auth"><h1>학생 인증</h1></div>
            <div id="prof_auth" style="display:none"><h1>교직원 인증</h1></div>
            <div class="select">
                <input type="radio" id="select_stud" name="stud_prof" value="stud" onclick="stud_prof(this.value);" checked><label for="select_stud">학생</label>
                <input type="radio" id="select_prof" name="stud_prof" value="prof" onclick="stud_prof(this.value);"><label for="select_prof">교직원</label>
            </div>
        </header>
        <form action="signup.php" method="POST">
            <div class="int-area">
                <input id="name" type="text" name="name" required>
                <label for="name">성명</label>
            </div>
            <div class="int-area" class="int-area">
                <input id="birth" type="date" name="birth" placeholder="생년월일">
                <label for="birth">생년월일</label>
            </div>
            <div id="stud_auth2" class="int-area">
                <input id="stud_id" type="text" name="stud_id">
                <label for="stud_id">학번</label>
            </div>
            <div id="prof_auth2" class="int-area" style="display:none">
                <input id="prof_id" type="text" name="prof_id">
                <label for="prof_id">휴대폰번호('-' 제외)</label>
            </div>
            <div class="btn-area">
                <button id="btn" type="submit">본인인증</button><br>
                <a href="./login.php">로그인</a>
                <a href="/">홈페이지</a>
            </div>
        </form>
        </section>
        <div>
        <script>
            function stud_prof(v){
                if(v == "stud"){
                    document.getElementById('stud_auth').style.display = "";
                    document.getElementById('stud_auth2').style.display = "";
                    document.getElementById('prof_auth').style.display = "none";
                    document.getElementById('prof_auth2').style.display = "none";
                    document.getElementById('prof_id').value = "";
                    document.getElementById('prof_id').required = false;
                    document.getElementById('stud_id').required = true;
                }else {                    
                    document.getElementById('prof_auth').style.display = "";
                    document.getElementById('prof_auth2').style.display = "";
                    document.getElementById('stud_auth').style.display = "none";
                    document.getElementById('stud_auth2').style.display = "none";
                    document.getElementById('stud_id').value = "";
                    document.getElementById('stud_id').required = false;
                    document.getElementById('prof_id').required = true;
                }
            }
            stud_prof("stud");
        </script>
    </body>
</html>
