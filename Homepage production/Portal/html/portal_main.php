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
          <input type="button" class="side_menubar2" value="메인바"></input>
            <div id="side_menu_scroll">
            <ol>
            <li>
              <input type="button" class="side_menubar3" value="학적정보"></input>
            </li>
            <li>
                <input type="button" class="side_menubar4" value="·학사일정조회"></input>
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
                    }
                  } else {echo 'side_menubar5';}
            ?>" onclick="location.href='<?php
                if( isset( $_SESSION[ 'userid' ] ) ) {
                $jb_login = TRUE;}?><?php
                if ( $jb_login = TRUE) {
                    if($flag[1]=='student') {
                      echo './portal_info.php';
                    } elseif($flag[1] == 'professor') {
                      echo './portal_info.php';
                    } else {echo 'login.php';}
                  }
            ?>'" value="<?php
                if( isset( $_SESSION[ 'userid' ] ) ) {
                $jb_login = TRUE;}?><?php
                if ( $jb_login ) {
                    if($flag[1]=='student') {
                      echo '신상정보관리';
                    } elseif($flag[1] == 'professor') {
                      echo '신상정보관리';
                    } else {echo '신상정보관리';}
                  }
            ?>"></input>
                <!-- <input type="button" class="side_menubar5" onclick="location.href='./portal_info.php'"  value="·신상정보관리"></input> -->

            </li>
            <li>
                <input type="button" class="side_menubar4" value="·교수종합정보조회"></input>
            </li>
            <li>
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
                    } else {echo 'side_menubar5';}
                  }
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
          <input type="button" id="banner_button1-2" value="메인페이지">
        </div>
        <div id="top_1-2">
          <p>&nbsp;&nbsp;&nbsp;&nbsp;메인페이지</p>
        </div>
        <div class="main">
          <div id="background">
            <div id="main1_grade">


              <div id="main2">
                <ion-icon name="star-outline"></ion-icon><p>부천대학교 포털 메인페이지입니다.</p>
              </div>

              <div id="a_subject" >
                  <P>해당 페이지에서는 학생들의 성적확인, 교수의 성적입력 및 수정을 구현한 페이지입니다.</p>
              </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>

