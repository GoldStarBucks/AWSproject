<?php
    include "../../inc/eclassinfo.inc";
    include "../member/stud_prof_flag.php";
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="../css/notice.css" />
    <title></title>
  </head>
  <body>
    <div class="page-title">
      <div class="container">
        <h3>강의 및 자료</h3>
      </div>
    </div>
    <div id="board-list">
      <div class="container">
        <table class="board-table">
          <thead>
            <tr>
              <th width="70">번호</th>
              <th width="500">제목</th>
              <th width="120">글쓴이</th>
              <th width="100">작성일</th>
            </tr>
          </thead>
        <?php
        // board테이블에서 idx를 기준으로 내림차순해서 5개까지 표시
          $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
          if(mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();
          $query = "SELECT * FROM lecture order by num desc limit 0,10";
          $select = mysqli_query($connection, $query);
          if(mysqli_num_rows($select)>=1){
            while($board = mysqli_fetch_array($select))
            {
              //title변수에 DB에서 가져온 title을 선택
              $title=$board["title"];
              if(strlen($title)>50)
              {
                //title이 30을 넘어서면 ...표시
                $title=str_replace($board["title"],mb_substr($board["title"],0,50,"utf-8")."...",$board["title"]);
              }
              ?>
              <tbody>
                <tr>
                  <td width="70"><?php echo $board['num']; ?></td>
                  <td width="500"><a href="lecture_read.php?num=<?php echo $board["num"];?>"><?php echo $title;?></a></td>
                  <td width="120"><?php echo $board['writer']?></td>
                  <td width="100"><?php echo $board['create_date']?></td>
                </tr>
              </tbody>
      <?php } } ?>
          </table>
        </div>
      </div>
    <?php
      if (isset($_SESSION["userid"])) {
        $id = $_SESSION['userid'];
        $flag = stud_or_prof($id);
        if ($flag != -1) {
          if ($flag[1] == "professor") {
            echo "<div class='write-btn'><button onclick='location.href=`lecture_write.php`'>글쓰기</button></div>";
          }
        }
      }
    ?>
  </body>
</html>