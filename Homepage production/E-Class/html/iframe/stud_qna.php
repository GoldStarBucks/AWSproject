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
        <h3>문의 게시판</h3>
      </div>
    </div>
    <?php
      if (isset($_SESSION["userid"])) {
        $id = $_SESSION['userid'];
        $flag = stud_or_prof($id);
        if ($flag != -1) {
          $datetime = date("Y-m-d", time());
          if ($flag[1] == "student") {
            $question = $_POST["question"];
            $questioner = $_POST["questioner"];
            if ($question != '' && $questioner != '') {
              $query = "INSERT INTO qna(num, question, writer, create_date) VALUES (NULL, '$question', '$questioner', '$datetime');";
              $question_query = mysqli_query($connection, $query);
            }
            ?>
            <form action="stud_qna.php" method="POST">
              <div class="input-box">
                <input id="question" class="question" type="text" name="question" placeholder="내용">
                <input id="questioner" type="hidden" name="questioner" value=<?php echo $flag[0] ?>>
                <button type="submit" class="write-btn">문의하기</button>
              </div>
            </form>
        <?php
          } else {
            $answer = $_POST["answer"];
            $answerer = $_POST["answerer"];
            $ans_num = $_POST["answer_number"];
            if ($answer != '' && $answerer != '' && $ans_num != '') {
              $query = "UPDATE qna SET answer = '$answer', answerer = '$answerer', answer_date = '$datetime' WHERE num = $ans_num;";
              $answer_query = mysqli_query($connection, $query);
            }
          }
          $del_num = $_POST["delete"];
          if($del_num != "") {
            $sql = "SELECT writer FROM qna WHERE num = $del_num;";
            $writer_query = mysqli_query($connection, $sql);
            $writer = mysqli_fetch_array($writer_query);
            if($flag[1] == "professor" || $flag[0] == $writer['writer']) {
              $query = "DELETE from qna WHERE num = $del_num;";
              $delete_query = mysqli_query($connection, $query);
            }
          }
        }
      }
    ?>
    <div class="container">
    <table class="board-table">
      <thead>
        <tr>
          <th width="40">번호</th>
          <th width="460">문의</th>
          <th width="100">등록자</th>
          <th width="100">작성일</th>
          <th width="40">삭제</th>
        </tr>
      </thead>
      <?php
        $query = "SELECT * FROM qna order by num desc limit 0,9";
        $select = mysqli_query($connection, $query);
        if(mysqli_num_rows($select)>=1){
          while($board = mysqli_fetch_array($select)) { ?>
            <tbody>
              <tr>
                <td rowspan="2" width="40" style="background-color: #f5f3f0;"><b><?php echo $board['num']; ?></b></td>
                <td width="460"><?php echo $board['question'];?></td>
                <td width="100"><?php echo $board['writer'];?></td>
                <td width="100"><?php echo $board['create_date'];?></td>
                <td rowspan="2" width="40" style="background-color: #f5f3f0;">
                  <?php if($board['writer'] == $flag[0] || $flag[1] == 'professor') { ?>
                  <form action="stud_qna.php" method="POST">
                    <input id="delete" type="hidden" name="delete" value=<?php echo $board['num'] ?>>
                    <button type="submit" class="x-btn">X</button>
                  </form>
                  <?php } ?>
                </td>
              </tr>
              <?php if ($board['answer']=='') { ?>
                <tr class="no-answer">
                  <?php if ($flag[1]=='professor') { ?>
                    <td width="460">
                      <form action="stud_qna.php" method="POST">
                        <div class="input-box-ans">
                          <input id="answer" class="answe" type="text" name="answer" placeholder="내용">
                          <input id="answerer" type="hidden" name="answerer" value=<?php echo $flag[0] ?>>
                          <input id="answer_number" type="hidden" name="answer_number" value=<?php echo $board['num'] ?>>
                          <button type="submit" class="answer-btn">답변하기</button>
                        </div>
                      </form>
                    </td>
                    <td colspan="2"></td>
                  <?php } else { ?>
                    <td colspan="1" width="460">답변이 없습니다.</td>
                    <td colspan="2"></td>
                  <?php } ?>
                </tr>
              <?php } else { ?>
                <tr class="yes-answer">
                  <td width="460"><?php echo $board['answer'];?></td>
                  <td width="100"><?php echo $board['answerer']?></td>
                  <td width="100"><?php echo $board['answer_date']?></td>
                </tr>
              <?php } ?>
            </tbody>
      <?php } } ?>
    </table>
  </div>
  </body>
</html>