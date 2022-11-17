<?php
    session_start();
    if (isset($_SESSION["userid"])) echo "<script>alert('이미 로그인 상태입니다.'); history.back();</script>";
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="../css/login.css">
    </head>
    <body>
        <div class="loginform">
        <section class="login-form">
        <header>
            <h1>로그인</h1>
        </header>
        <form action="login_proc.php" method="POST">
            <div class="select">
                <input id="select_stud" type="radio" name="stud_prof" value="stud" checked><label for="select_stud">학생</label>
                <input id="select_prof" type="radio" name="stud_prof" value="prof"><label for="select_prof">교직원</label>
            </div>

            <div class="int-area">
                <input id="id" type="text" name="id" required>
                <label for="id">아이디</label>
            </div>
            <div class="int-area">
                <input id="pw" type="password" name="pw" required>
                <label for="pw">패스워드</label>
            </div>
            <div class="btn-area">
                <button id="btn" type="submit">Login</button><br>
                <a href="./auth.php">회원가입</a>
                <a href="/">홈페이지</a>
            </div>
        </form>
        </section>
        <div>
    </body>
</html>