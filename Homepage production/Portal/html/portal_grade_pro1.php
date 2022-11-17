<?php include "../inc/students.inc"; ?>
<?php include "../inc/eclassinfo.inc";
      include "./stud_prof_flag.php";
    session_start();?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/portal.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  </head>
  <body>
    <div class="header">
      <a id="mark" href="http://a83d2d49bf56b427f903d831b6ea2512-1866076524.ap-northeast-2.elb.amazonaws.com/"><img src="./images/mark.png"></a>
      <div class="menu_bar">
        <input type ="button" class="menu_btn" value="학사행정"></input>
      </div>
      <div class="menu_bar">
        <input type ="button" class="menu_btn" value="일반행정"></input>
      </div>
      <input type ="button" onclick="location.href='<?php
      if (isset($_SESSION["userid"])) {
        $id = $_SESSION['userid'];
        $flag = stud_or_prof($id);
        if ($flag != -1) {
          echo "logout.php";
        } else {
          echo "login.php";
        }
      } else {
        echo "login.php";
      }
      ?>'" class="login_btn" value="<?php
      if (isset($_SESSION["userid"])) {
        $id = $_SESSION['userid'];
        $flag = stud_or_prof($id);
        if ($flag != -1) {
          echo "로그아웃";
        } else {
          echo "로그인";
        }
      } else {
        echo "로그인";
      }
      ?>"></input>
      <!-- <input type ="button" onclick="location.href='logout.php'" class="login_btn" value="로그아웃"></input> -->
    </div>
    <div id="menu_under_bar"></div>



    <div class="container">
      <div class="left">
        <!--검색바-->
        <div>
          <div id="serch_div">
            <input type="text" class="search" placeholder="메뉴검색">
            <button class="search_button"><ion-icon name="search-outline"></ion-icon></button>
          </div>


          <div id="left_top">
            <input type="button" class="side_menubar" value="전체메뉴"></input>
            <input type="button" class="side_menubar" value="My menu"></input>
          </div>
        </div>
        <div>
          <input type="button" class="side_menubar2" value="교수전용"></input>
            <div id="side_menu_scroll">
              <input type="button" class="side_menubar3" value="학적정보"></input>
                <input type="button" class="side_menubar4" value="·학사일정조회"></input>
                <input type="button" class="side_menubar5" onclick="location.href='./portal_info.php'"  value="·신상정보관리"></input>
                <input type="button" class="side_menubar4" value="·교수종합정보조회"></input>
            <input type="button" class="side_menubar3" value="교육과정정보"></input>
            <input type="button" class="side_menubar3" value="등록장학정보"></input>
            <input type="button" class="side_menubar3" value="수강정보"></input>
            <input type="button" class="side_menubar3" value="NCS정보"></input>
            <input type="button" class="side_menubar3" value="학생성적정보"></input>
              <input type="button" onclick="location.href='./portal_grade_pro1.php'" class="side_menubar5" value="·1학년 성적정보"></input>
              <input type="button" onclick="location.href='./portal_grade_pro2.php'" class="side_menubar5" value="·2학년 성적정보"></input>
              <input type="button" onclick="location.href='./portal_grade_pro3.php'" class="side_menubar5" value="·3학년 성적정보"></input>
              <input type="button" onclick="location.href='# " class="side_menubar4" value="·전체성적조회"></input>
            <input type="button" class="side_menubar3" value="교직정보"></input>
            <input type="button" class="side_menubar3" value="졸업정보"></input>
            <input type="button" class="side_menubar3" value="설문"></input>
            <input type="button" class="side_menubar3" value="봉사신청관리"></input>
          </div>
        </div>
      </div>

      <div class="right">
        <div id="banner_1-2">
          <input type="button" id="banner_button1-2" value="전체성적조회">
        </div>
        <div id="top_1-2">
          <p>&nbsp;&nbsp;&nbsp;&nbsp;학사행정>학생전용>성적정보>전체성적조회</p>
        </div>
        <div class="main">
          <div id="background">
            <div id="main1_grade">


              <div id="main2">
                <ion-icon name="star-outline"></ion-icon><p>전체성적조회</p>
              </div>

              <div id="a_subject" >

                <?php

                /* 데이터베이스 연결확인 */

                 $connection = mysqli_connect(DB_SERVER_S, DB_USERNAME_S, DB_PASSWORD_S);

                 if(mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

                  $database = mysqli_select_db($connection, DB_DATABASE_S);

                 /* 칸이 입력되어있으면 데이터 입력 */
                 $students_number = htmlentities($_POST['number']);

                 $students_name = $_POST['Name'];

                 $students_exam1 = htmlentities($_POST['exam1']);

                 $students_exam2 = htmlentities($_POST['exam2']);

                 $students_assignment = htmlentities($_POST['assignment']);

                 $students_percentile = htmlentities($_POST['percentile']);

                 $students_grade = htmlentities($_POST['grade']);

                  if(strlen($students_number) || strlen($students_name)) {

                   Add1st_grader($connection, $students_number, $students_name, $students_exam1, $students_exam2, $students_assignment, $students_percentile, $students_grade);
                 }

                 ?>

                <form action="./portal_grade_pro1.php" method="POST">

                  <table class="grade_insert">

                    <tr>

                    <th>학번</th>

                    <th>이름</th>

                    <th>중간고사</th>

                    <th>기말고사</th>

                    <th>과제</th>

                    <th>백분위</th>

                    <th>학점</th>

                    </tr>

                    <tr>

                    <td><input type="text" name="number" maxlength="10" size="15" /></td>

                    <td><input type="text" name="Name" maxlength="10" size="15" /></td>

                    <td><input type="text" name="exam1" maxlength="10" size="10" /></td>

                    <td><input type="text" name="exam2" maxlength="10" size="10" /></td>

                    <td><input type="text" name="assignment" maxlength="10" size="10" /></td>

                    <td><input type="text" name="percentile" maxlength="10" size="10" /></td>

                    <td><input type="text" name="grade" maxlength="10" size="10" /></td>

                    <td><input type="submit" class="grade_insert_btn" value="성적입력" /></td>

                    </tr>

                  </table>

                  </form>



                  <?php
                      $connection = mysqli_connect(DB_SERVER_S, DB_USERNAME_S, DB_PASSWORD_S);

                      $database = mysqli_select_db($connection, DB_DATABASE_S);

                        $students_number_d = htmlentities($_POST['number_d']);

                        $students_name_d = $_POST['Name_d'];

                        $students_exam1_d = htmlentities($_POST['exam1_d']);

                        $students_exam2_d = htmlentities($_POST['exam2_d']);

                        $students_assignment_d = htmlentities($_POST['assignment_d']);

                        $students_percentile_d = htmlentities($_POST['percentile_d']);

                        $students_grade_d = htmlentities($_POST['grade_d']);

                        if(strlen($students_number_d) > 0) {

                          $query_d = "UPDATE 1st_grader SET name='$students_name_d', exam1=$students_exam1_d, exam2=$students_exam2_d, assignment=$students_assignment_d, percentile=$students_percentile_d, grade=$students_grade_d WHERE number=$students_number_d;";

                          mysqli_query($connection, $query_d);
                        }



                    ?>

                  <form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">

                    <table class="grade_insert">

                      <tr>

                      <th>학번</th>

                      <th>이름</th>

                      <th>중간고사</th>

                      <th>기말고사</th>

                      <th>과제</th>

                      <th>백분위</th>

                      <th>학점</th>

                      <th rowspan='2'></th>

                      </tr>

                      <tr>

                      <td><input type="text" name="number_d" maxlength="10" size="15" /></td>

                      <td><input type="text" name="Name_d" maxlength="10" size="15" /></td>

                      <td><input type="text" name="exam1_d" maxlength="10" size="10" /></td>

                      <td><input type="text" name="exam2_d" maxlength="10" size="10" /></td>

                      <td><input type="text" name="assignment_d" maxlength="10" size="10" /></td>

                      <td><input type="text" name="percentile_d" maxlength="10" size="10" /></td>

                      <td><input type="text" name="grade_d" maxlength="10" size="10" /></td>

                      <td><input type="submit" class="grade_insert_btn" value="성적수정" /></td>

                      </tr>

                    </table>

                    </form>


                    <table class="grade_table2" border="1" cellpadding="2" cellspacing="2">

                      <tr>

                        <th>학번</th>

                        <th>이름</th>

                        <th>중간고사</th>

                        <th>기말고사</th>

                        <th>과제</th>

                        <th>백분위</th>

                        <th>학점</th>

                      </tr>

                      <?php

                      $result = mysqli_query($connection, "SELECT * FROM 1st_grader;");

                      while($query_data = mysqli_fetch_row($result)) {

                      echo "<tr>";

                      echo "<td>",$query_data[0], "</td>",

                         "<td>",$query_data[1], "</td>",

                         "<td>",$query_data[2], "</td>",

                         "<td>",$query_data[3], "</td>",

                         "<td>",$query_data[4], "</td>",

                         "<td>",$query_data[5], "</td>",

                         "<td>",$query_data[6], "</td>";

                      echo "</tr>";

                      }

                      ?>

                    </table>

                    <?php

                    mysqli_free_result($result);

                    mysqli_close($connection);

                    ?>
              </div>

<?php

/* 성적추가 */

function Add1st_grader($connection, $students_number, $students_name, $students_exam1, $students_exam2, $students_assignment, $students_percentile, $students_grade) {

   $num = mysqli_real_escape_string($connection, $students_number);

   $n = mysqli_real_escape_string($connection, $students_name);

   $e1 = mysqli_real_escape_string($connection, $students_exam1);

   $e2 = mysqli_real_escape_string($connection, $students_exam2);

   $a = mysqli_real_escape_string($connection, $students_assignment);

   $p = mysqli_real_escape_string($connection, $students_percentile);

   $g = mysqli_real_escape_string($connection, $students_grade);

   $query = "INSERT INTO 1st_grader(number, name, exam1, exam2, assignment, percentile, grade) VALUES('$num', '$n', '$e1', '$e2', '$a', '$p', '$g');";

   if(!mysqli_query($connection, $query)) echo("<p>Error adding students data.</p>");

}



/* 테이블이 있는지 확인함. */

function TableExists($tableName, $connection, $dbName) {

  $t = mysqli_real_escape_string($connection, $tableName);

  $d = mysqli_real_escape_string($connection, $dbName);



  $checktable = mysqli_query($connection,

    "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_NAME = '$t' AND TABLE_SCHEMA = '$d'");

  if(mysqli_num_rows($checktable)> 0) return true;

  return false;

}

?>

            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>

