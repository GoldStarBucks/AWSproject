<?php include "../inc/eclassinfo.inc";?>
<?php include "../inc/prid.inc";
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
                    <input type="button" id="banner_button1-2" value="신상정보관리">
                </div>
                <div id="top_1-2">
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;학사행정>학생전용>학적정보>신상정보관리</p>
                </div>
                <div class="main">
                    <div id="background">
                        <div id="main1">


                            <div id="main2">
                                <ion-icon name="star-outline"></ion-icon><p>신상정보관리</p>
                            </div>
                            <div id="main3">
                                <p>학적기본정보</p>
                            </div>
                            <div class="main4">
                                <img src="https://cdn-icons-png.flaticon.com/512/456/456283.png">
                                <div class="info">


        <style type="text/css">
            #vertical-2 thead,#vertical-2 tbody{
                display:inline-block;
            }

        </style>
        <table id="vertical-2">
            <thead>
                <tr>
                    <th colspan="3"><?php
                if( isset( $_SESSION[ 'userid' ] ) ) {
                  $jb_login = TRUE;}?><?php
                  if ( $jb_login ) {
                      if($flag[1]=='student') {
                        echo '학번';
                      } elseif($flag[1] == 'professor') {
                        echo '교번';
                      }
                    }
            ?></th>
                </tr>
                <tr>
                    <th colspan="3">이름</th>
                </tr>
                <tr>
                    <th colspan="3">전화번호</th>
                </tr>
                <tr>
                    <th colspan="3">주소</th>
                </tr>
                <tr>
                    <th colspan="3">학과</th>
                </tr>
                <tr>
                    <th colspan="3"><?php
                if( isset( $_SESSION[ 'userid' ] ) ) {
                  $jb_login = TRUE;}?><?php
                  if ( $jb_login ) {
                      if($flag[1]=='student') {
                        echo '학년';
                      } elseif($flag[1] == 'professor') {
                        echo '직책';
                      }
                    }
            ?></th>
                </tr>
                <tr>
                    <th colspan="3"><?php
                if( isset( $_SESSION[ 'userid' ] ) ) {
                  $jb_login = TRUE;}?><?php
                  if ( $jb_login ) {
                      if($flag[1]=='student') {
                        echo '출신고등학교';
                      } elseif($flag[1] == 'professor') {
                        echo '분야';
                      }
                    }
            ?></th>
                </tr>
            </thead>
            <tbody>
          <?php /*
          $connection = mysqli_connect(DB_SERVER_P, DB_USERNAME_P, DB_PASSWORD_P);
          $connection2 = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
          $database = mysqli_select_db($connection, DB_DATABASE_P);
          $database2 = mysqli_select_db($connection2, DB_DATABASE);
            
        
            if (isset($_SESSION["userid"])) {
              if( isset( $_SESSION[ 'userid' ] ) ) {
                $jb_login = TRUE;}?><?php
                if ( $jb_login ) {
                    if($flag[1]=='student') {
                      $sid = $_SESSION["userid"];
                $stud_id = mysqli_query($connection2, "SELECT stud_id FROM stud_mem WHERE id='$sid';");
                $stud_id_2 = mysqli_fetch_row($stud_id);
                $stud_id_3 = $stud_id_2[0];
                $result3 = mysqli_query($connection, "SELECT number FROM students WHERE number ='$stud_id_3';");
                $stud_id_2_1 = mysqli_fetch_row($result3);
                $stud_id_3_1 = $stud_id_2_1[0];
                $result2 = mysqli_query($connection, "SELECT * FROM students WHERE number='$stud_id_3_1';");
                while($query_data = mysqli_fetch_row($result2)) {


                echo"<tr>","<td>",$query_data[0], "</td>","<tr>";
                echo"<tr>","<td>",$query_data[1], "</td>","<tr>";
                echo"<tr>","<td>",$query_data[2], "</td>","<tr>";
                echo"<tr>","<td>",$query_data[3], "</td>","<tr>";
                echo"<tr>","<td>",$query_data[4], "</td>","<tr>";
                echo"<tr>","<td>",$query_data[5], "</td>","<tr>";
                echo"<tr>","<td>",$query_data[6], "</td>","<tr>";
                    } elseif($flag[1] == 'professor') {
                      $sid = $_SESSION["userid"];
                $stud_id = mysqli_query($connection2, "SELECT stud_id FROM stud_mem WHERE id='$sid';");
                $stud_id_2 = mysqli_fetch_row($stud_id);
                $stud_id_3 = $stud_id_2[0];
                $result3 = mysqli_query($connection, "SELECT number FROM students WHERE number ='$stud_id_3';");
                $stud_id_2_1 = mysqli_fetch_row($result3);
                $stud_id_3_1 = $stud_id_2_1[0];
                $result2 = mysqli_query($connection, "SELECT * FROM students WHERE number='$stud_id_3_1';");
                while($query_data = mysqli_fetch_row($result2)) {


                echo"<tr>","<td>",$query_data[0], "</td>","<tr>";
                echo"<tr>","<td>",$query_data[1], "</td>","<tr>";
                echo"<tr>","<td>",$query_data[2], "</td>","<tr>";
                echo"<tr>","<td>",$query_data[3], "</td>","<tr>";
                echo"<tr>","<td>",$query_data[4], "</td>","<tr>";
                echo"<tr>","<td>",$query_data[5], "</td>","<tr>";
                echo"<tr>","<td>",$query_data[6], "</td>","<tr>";
                    }
                  }
                $sid = $_SESSION["userid"];
                $stud_id = mysqli_query($connection2, "SELECT prof_mem FROM stud_mem WHERE id='$sid';");
                $stud_id_2 = mysqli_fetch_row($stud_id);
                $stud_id_3 = $stud_id_2[0];
                $result3 = mysqli_query($connection, "SELECT call_num FROM students WHERE number ='$stud_id_3';");
                $stud_id_2_1 = mysqli_fetch_row($result3);
                $stud_id_3_1 = $stud_id_2_1[0];
                $result2 = mysqli_query($connection, "SELECT * FROM students WHERE number='$stud_id_3_1';");
                while($query_data = mysqli_fetch_row($result2)) {


                echo"<tr>","<td>",$query_data[0], "</td>","<tr>";
                echo"<tr>","<td>",$query_data[1], "</td>","<tr>";
                echo"<tr>","<td>",$query_data[2], "</td>","<tr>";
                echo"<tr>","<td>",$query_data[3], "</td>","<tr>";
                echo"<tr>","<td>",$query_data[4], "</td>","<tr>";
                echo"<tr>","<td>",$query_data[5], "</td>","<tr>";
                echo"<tr>","<td>",$query_data[6], "</td>","<tr>";


            }
        }
           */ ?>
        <?php
        $connection = mysqli_connect(DB_SERVER_P, DB_USERNAME_P, DB_PASSWORD_P);
        $connection2 = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
        $database = mysqli_select_db($connection, DB_DATABASE_P);
        $database2 = mysqli_select_db($connection2, DB_DATABASE);
            
        
            if (isset($_SESSION["userid"])) {
                $sid = $_SESSION["userid"];
                $stud_id = mysqli_query($connection2, "SELECT stud_id FROM stud_mem WHERE id='$sid';");
                $stud_id_2 = mysqli_fetch_row($stud_id);
                $stud_id_3 = $stud_id_2[0];
                $result3 = mysqli_query($connection, "SELECT number FROM students WHERE number ='$stud_id_3';");
                $stud_id_2_1 = mysqli_fetch_row($result3);
                $stud_id_3_1 = $stud_id_2_1[0];
                $result2 = mysqli_query($connection, "SELECT * FROM students WHERE number='$stud_id_3_1';");
                while($query_data = mysqli_fetch_row($result2)) {


                echo"<tr>","<td>",$query_data[0], "</td>","<tr>";
                echo"<tr>","<td>",$query_data[1], "</td>","<tr>";
                echo"<tr>","<td>",$query_data[2], "</td>","<tr>";
                echo"<tr>","<td>",$query_data[3], "</td>","<tr>";
                echo"<tr>","<td>",$query_data[4], "</td>","<tr>";
                echo"<tr>","<td>",$query_data[5], "</td>","<tr>";
                echo"<tr>","<td>",$query_data[6], "</td>","<tr>";


            }
        }
            ?>
            </tbody>
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
        </div>
    </body>
</html>
