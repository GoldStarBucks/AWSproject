<?php include "../inc/students.inc";?>
<?php include "../inc/eclassinfo.inc";
    include "./stud_prof_flag.php"; session_start();?>
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
      <?php
        if (isset($_SESSION["userid"])) {
          $id = $_SESSION['userid'];
          $flag = stud_or_prof($id);
          if ($flag != -1) {
            echo $flag[0];
            // echo "  <a href='logout.php'>로그아웃</a>";
          } else {
            echo "<a href='login.php'>로그인</a>";
            echo " <a href='auth.php'>회원가입</a>";
          }
        } else {
          echo "<a href='login.php'>로그인</a>";
          echo " ";
          echo "<a href='auth.php'>회원가입</a>";
        }
    ?>
      <input type ="button" onclick="location.href='logout.php'" class="login_btn" value="로그아웃"></input>
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
          <input type="button" class="side_menubar2" value="학생전용"></input>
            <div id="side_menu_scroll">
            <ol>
            <li>
              <input type="button" class="side_menubar3" value="학적정보"></input>
            </li>
            <li>
                <input type="button" class="side_menubar4" value="·학사일정조회"></input>
            </li>
                <input type="button" class="side_menubar5" onclick="location.href='./portal_info.php'"  value="·신상정보관리"></input>
            </li>
                <input type="button" class="side_menubar4" value="·교수종합정보조회"></input>
            </li>
            </li>
            <input type="button" class="side_menubar3" value="교육과정정보"></input>
            </li>
            <li>
            <input type="button" class="side_menubar3" value="등록장학정보"></input>
            </li>
            <li>
            <input type ="button" class="<?php
                if( isset( $_SESSION[ 'userid' ] ) ) {
                $jb_login = TRUE;}?><?php
                if ( $jb_login ) {
                    if($flag[1]=='student') {
                      echo 'side_menubar3';
                    } elseif($flag[1] == 'professor') {
                      echo 'side_menubar5';
                    }
                  } else {echo 'side_menubar5';}
            ?>" onclick="location.href='<?php
                if( isset( $_SESSION[ 'userid' ] ) ) {
                $jb_login = TRUE;}?><?php
                if ( $jb_login = TRUE) {
                    if($flag[1]=='student') {
                      echo '#';
                    } elseif($flag[1] == 'professor') {
                      echo 'portal_grade_pro1.php';
                    } else {echo 'login.php';}
                  }
            ?>'" value="<?php
                if( isset( $_SESSION[ 'userid' ] ) ) {
                $jb_login = TRUE;}?><?php
                if ( $jb_login ) {
                    if($flag[1]=='student') {
                      echo '수강정보';
                    } elseif($flag[1] == 'professor') {
                      echo '1학년 성적정보';
                    } else {echo '수강정보';}
                  }
            ?>"></input>
            </li>




            <li>
            <input type ="button" class="<?php
                if( isset( $_SESSION[ 'userid' ] ) ) {
                  $jb_login = TRUE;}?><?php
                  if ( $jb_login ) {
                      if($flag[1]=='student') {
                        echo 'side_menubar3';
                      } elseif($flag[1] == 'professor') {
                        echo 'side_menubar5';
                      } else {echo 'side_menubar5';}
                    }
            ?>" onclick="location.href='<?php
                 if( isset( $_SESSION[ 'userid' ] ) ) {
                $jb_login = TRUE;}?><?php
                if ( $jb_login ) {
                    if($flag[1]=='student') {
                      echo '#';
                    } elseif($flag[1] == 'professor') {
                      echo 'portal_grade_pro2.php';
                    } else {echo 'login.php';}
                  }
            ?>'" value="<?php
                 if( isset( $_SESSION[ 'userid' ] ) ) {
                $jb_login = TRUE;}?><?php
                if ( $jb_login ) {
                    if($flag[1]=='student') {
                      echo 'NCS정보';
                    } elseif($flag[1] == 'professor') {
                      echo '2학년 성적정보';
                    } else {echo 'NCS정보';}
                  }
            ?>"></input>
            </li>





            <li>
            <input type ="button" class="<?php
                 if( isset( $_SESSION[ 'userid' ] ) ) {
                $jb_login = TRUE;}?><?php
                if ( $jb_login ) {
                    if($flag[1]=='student') {
                      echo 'side_menubar5';
                    } elseif($flag[1] == 'professor') {
                      echo 'side_menubar5';
                    } else {echo 'side_menubar5';}
                  }
            ?>" onclick="location.href='<?php
                 if( isset( $_SESSION[ 'userid' ] ) ) {
                $jb_login = TRUE;}?><?php
                if ( $jb_login ) {
                    if($flag[1]=='student') {
                      echo 'portal_grade.php';
                    } elseif($flag[1] == 'professor') {
                      echo 'portal_grade_pro3.php';
                    } else {echo 'login.php';}
                  }
            ?>'" value="<?php
                 if( isset( $_SESSION[ 'userid' ] ) ) {
                $jb_login = TRUE;}?><?php
                if ( $jb_login ) {
                    if($flag[1]=='student') {
                      echo '내성적정보';
                    } elseif($flag[1] == 'professor') {
                      echo '3학년 성적정보';
                    } else {echo '성적정보';}
                  }
            ?>"></input>
            </li>
            </ol>
              <input type="button" onclick="location.href='#' " class="side_menubar4" value="·전체성적조회"></input>
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
                    <!-- <table id="grade_table" border="1" cellpadding="2" cellspacing="2"> -->
                    <table id="grade_table">
                    <caption>1학년 성적</caption>
                      <tr>

                        <td>학번</td>

                        <td>이름</td>

                        <td>중간고사</td>

                        <td>기말고사</td>

                        <td>과제</td>

                        <td>백분위</td>

                        <td>학점</td>

                      </tr>

                      <?php
                      $connection = mysqli_connect(DB_SERVER_S, DB_USERNAME_S, DB_PASSWORD_S, DB_DATABASE_S);
                      $connection2 = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
                      if (isset($_SESSION["userid"])) {
                        $sid = $_SESSION["userid"];
                        $a="SELECT stud_id FROM stud_mem WHERE id='$sid';";
                        $stud_id = mysqli_query($connection2, $a);
                        $stud_id_2 = mysqli_fetch_row($stud_id);
                        $stud_id_3 = $stud_id_2[0];
                        $b="SELECT number FROM 1st_grader WHERE number ='$stud_id_3';";
                        $result3 = mysqli_query($connection, $b);
                        $stud_id_2_1 = mysqli_fetch_row($result3);
                        $stud_id_3_1 = $stud_id_2_1[0];
                        $c = "SELECT * FROM 1st_grader WHERE number='$stud_id_3_1';";
                        $result2 = mysqli_query($connection, "SELECT * FROM 1st_grader WHERE number='$stud_id_3_1';");

                      while($query_data = mysqli_fetch_row($result2)) {

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
                      }
                      ?>

                    </table>

                    <table id="grade_table">
                    <caption>2학년 성적</caption>
                      <tr>

                        <td>학번</td>

                        <td>이름</td>

                        <td>중간고사</td>

                        <td>기말고사</td>

                        <td>과제</td>

                        <td>백분위</td>

                        <td>학점</td>

                      </tr>

                      <?php
                      $connection = mysqli_connect(DB_SERVER_S, DB_USERNAME_S, DB_PASSWORD_S, DB_DATABASE_S);
                      $connection2 = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
                      if (isset($_SESSION["userid"])) {
                        $sid = $_SESSION["userid"];
                        $a="SELECT stud_id FROM stud_mem WHERE id='$sid';";
                        $stud_id = mysqli_query($connection2, $a);
                        $stud_id_2 = mysqli_fetch_row($stud_id);
                        $stud_id_3 = $stud_id_2[0];
                        $b="SELECT number FROM 2nd_grader WHERE number ='$stud_id_3';";
                        $result3 = mysqli_query($connection, $b);
                        $stud_id_2_1 = mysqli_fetch_row($result3);
                        $stud_id_3_1 = $stud_id_2_1[0];
                        $c = "SELECT * FROM 2nd_grader WHERE number='$stud_id_3_1';";
                        $result2 = mysqli_query($connection, "SELECT * FROM 2nd_grader WHERE number='$stud_id_3_1';");
                      while($query_data = mysqli_fetch_row($result2)) {

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
                      }
                      ?>

                    </table>

                    <table id="grade_table">
                    <caption>3학년 성적</caption>
                      <tr>

                        <td>학번</td>

                        <td>이름</td>

                        <td>중간고사</td>

                        <td>기말고사</td>

                        <td>과제</td>

                        <td>백분위</td>

                        <td>학점</td>

                      </tr>

                      <?php
                      $connection = mysqli_connect(DB_SERVER_S, DB_USERNAME_S, DB_PASSWORD_S, DB_DATABASE_S);
                      $connection2 = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
                      if (isset($_SESSION["userid"])) {
                        $sid = $_SESSION["userid"];
                        $a="SELECT stud_id FROM stud_mem WHERE id='$sid';";
                        $stud_id = mysqli_query($connection2, $a);
                        $stud_id_2 = mysqli_fetch_row($stud_id);
                        $stud_id_3 = $stud_id_2[0];
                        $result3 = mysqli_query($connection, "SELECT number FROM 3rd_grader WHERE number ='$stud_id_3';");
                        $stud_id_2_1 = mysqli_fetch_row($result3);
                        $stud_id_3_1 = $stud_id_2_1[0];
                        $result2 = mysqli_query($connection, "SELECT * FROM 3rd_grader WHERE number='$stud_id_3_1';");

                      while($query_data = mysqli_fetch_row($result2)) {

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
                      }
                      ?>

                    </table>

                    <?php

                    mysqli_free_result($result);

                    mysqli_close($connection);

                    ?>
              </div>


            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>

