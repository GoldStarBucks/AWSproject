<?php
  include "../inc/eclassinfo.inc";
  include "./member/stud_prof_flag.php";
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" media="all" href="./css/main.css" />
</head>
<body>
  <div role="region" class="left-left-sidebar" aria-label="글로벌 네비게이션">
    <ul>
      <li class="home-logo">
        <a href="main.php">
          <img src="../images/bc_symbol.png">
        </a>
      </li>
      <li class="sidebar-image">
        <a href="main.php">
          <img src="./images/subject.png"><br>
          <span>과목</span>
        </a>
      </li>
      <li class="sidebar-image">
        <a href="calendar.php">
          <img src="./images/calendar.png"><br>
          <span>캘린더</span>
        </a>
      </li>
      <li class="sidebar-image">
        <a href="home.html">
          <img src="./images/about_us.png"><br>
          <span>About Us</span>
        </a>
      </li>
    </ul>
  </div>

  <nav id="headbox">
    <table class="login-table">
      <tr class="login">
          <th><a href='http://3.39.2.188/portal_main.php'>종합정보시스템</a></th>
    <?php
        if (isset($_SESSION["userid"])) {
          $id = $_SESSION['userid'];
          $flag = stud_or_prof($id);
          if ($flag != -1) {
            echo $flag[0];
            echo "<th><a href='./member/logout.php'>로그아웃</a></th>";
          } else {
            echo "<th><a href='./member/login.php'>로그인</a></th>";
            echo "<th><a href='./member/auth.php'>회원가입</a></th>";
          }
        } else {
          echo "<th><a href='./member/login.php'>로그인</a></th>";
          echo "<th><a href='./member/auth.php'>회원가입</a></th>";
        }
    ?>
    </tr>
    </table>
  </nav>
  <section id="main" class="main">
      <iframe id="iframeno" name="iframe1" src="./iframe/notice.php" seamless frameborder=0 framespacing=0 vspace=0></iframe>
  </section>
        <div id="left-side" class="sidebar">
          <span class="ellipsis">2022학년 2학기 모의해킹</span>
          <nav role="navigation" aria-label="과목 네비게이션 메뉴">
            <ul style="list-style:none; margin-top:10px;">
              <li class="section-current">
                <button onclick="location.href='main.php'" title="홈">홈</button>
              </li>
              <li class="section">
                <button onclick="location.href='lecture.php'" title="강의 및 자료">강의 및 자료</button>
              </li>
              <li class="section">
                <button onclick="location.href='eval.php'" title="과제 및 평가">과제 및 평가</button>
              </li>
              <li class="section">
                <button onclick="location.href='qna.php'" title="문의 게시판">문의 게시판</button>
              </li>
            </ul>
          </nav>
        </div>
</body>
</html>
