<?php
  include "../../inc/eclassinfo.inc";
  include "../member/stud_prof_flag.php";
  session_start();
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
  if(mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="../css/qna.css" />
    <title></title>
  </head>
  <body>
  <div class="qna">
    <div class="page-title">
      <div class="container">
        <h3>과제 및 평가</h3>
      </div>
    </div>
      <?php
        if (isset($_SESSION["userid"])) {
          $id = $_SESSION['userid'];
          $flag = stud_or_prof($id);
          if ($flag != -1) {
            $datetime = date("Y-m-d", time());
            if ($flag[1] == "student") {
              $as_title = $_POST["assignment_title"];
              $as_writer = $_POST["assignment_writer"];
              if ($as_title != '' && $as_writer != '') {
                $tmpfile =  $_FILES['file_Upload']['tmp_name'];
                $real_name = $_FILES['file_Upload']['name'];
                $directory = "../board/eval/" . $real_name;
                move_uploaded_file($tmpfile, $directory);

                $query = "INSERT INTO eval(num, title, writer, create_date, file) VALUES (NULL, '$as_title', '$as_writer', '$datetime', '$real_name');";
                $eval_query = mysqli_query($connection, $query);
              }
              ?>
              <form action="eval.php" method="POST" enctype="multipart/form-data">
                <div class="input-box">
                  <input type="text" class="question" name="assignment_title" placeholder="내용">
                  <input type="hidden" name="assignment_writer" value=<?php echo $flag[0] ?>>
                  <div class="filebox">
                    <input type="file" id="assignment_file" name="file_Upload">
                  </div>
                  <button type="submit" class="write-btn">제출하기</button>
                </div>
              </form>
              <?php
            } else {
            }
            $del_num = $_POST["delete"];
            if($del_num != "") {
              $sql = "SELECT writer FROM eval WHERE num = $del_num;";
              $writer_query = mysqli_query($connection, $sql);
              $writer = mysqli_fetch_array($writer_query);
              if($flag[1] == "professor" || $flag[0] == $writer['writer']) {
                $query = "DELETE from eval WHERE num = $del_num;";
                $delete_query = mysqli_query($connection, $query);
              }
            }
          }
        } else echo "<script>alert('권한이 없습니다.'); document.location.href='./notice.php';</script>"
      ?>
    <table class="board-table">
      <thead>
        <tr>
          <th width="100">제출자</th>
          <th width="100">작성일</th>
          <th width="290">제출 제목</th>
          <th width="200">파일명</th>
          <th width="40">삭제</th>
        </tr>
      </thead>
    <?php
    if ($flag[1] != '') {
        $stud_writer = "";
        if ($flag[1] == 'student') $stud_writer = "where writer = '$flag[0]'";
        $query = "SELECT * FROM eval $stud_writer order by num desc limit 0,9;";
        $select = mysqli_query($connection, $query);
        if(mysqli_num_rows($select)>=1){
            while($board = mysqli_fetch_array($select)) { ?>
                <tbody>
                    <tr>
                        <td width="100"><b><?php echo $board['writer'];?></b></td>
                        <td width="100"><?php echo $board['create_date'];?></td>
                        <td width="290"><?php echo $board['title'];?></td>
                        <td width="200"><a href="../board/eval/<?php echo $board['file'];?>" download><?php echo $board['file']; ?></a></td>
                        <td width="40">
                            <?php if($board['writer'] == $flag[0] || $flag[1] == 'professor') { ?>
                            <form action="eval.php" method="POST">
                                <input id="delete" type="hidden" name="delete" value=<?php echo $board['num'] ?>>
                                <button type="submit" class="x-btn-eval">X</button>
                            </form>
                            <?php } ?>
                        </td>
                    </tr>
                </tbody>
        <?php } } }  ?>
    </table>
  </body>
</html>