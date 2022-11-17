<?php
    include "../../inc/eclassinfo.inc";
    include "../member/stud_prof_flag.php";
    session_start();
    $id = $_SESSION['userid'];
    $flag = stud_or_prof($id);
?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="../css/notice_post.css" />
	<title>강의 자료</title>
</head>
<body>
	<?php
        $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        if(mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();
        $num = $_GET['num'];
		$query = "SELECT * FROM lecture WHERE num='$num';";
		$bodselect = mysqli_query($connection, $query);
		$board = mysqli_fetch_array($bodselect);
	?>
<div class="container">
	<table class="board">
		<tr>
			<th class='title'>제목</th>
			<th class='ttitle' colspan="3"><h4><?php echo $board['title']; ?></h4></th>
		</tr>
		<tr>
			<th class='title'>작성자</th>
			<th class='info'><?php echo $board['writer']; ?></th>
			<th class='title'>작성일자</th>
			<th class='info'><?php echo $board['create_date']; ?></th>
		</tr>
		<tr>
			<th class='title'>강의 자료</th>
			<th class='info' colspan="3"><a href="../board/lecture/<?php echo $board['file'];?>" download><?php echo $board['file']; ?></a></th>
		</tr>
		<tr class='ccontent'>
			<th class='content' colspan="4"><?php echo nl2br("$board[content]"); ?></th>
		</tr>
	</table>
	<div class='write-btn'>
        <?php
			echo "<button id='list' onclick='location.href=`./lecture.php`'>전체 글</button>";
            if ($board['writer'] == $flag[0]) {
				echo "<button id='delete' onclick='location.href=`./lecture_delete.php?num=$board[num]`'>삭제하기</button>";
				echo "<button id='modify' onclick='location.href=`./lecture_modify.php?num=$board[num]`'>수정하기</button>";
			}
		?>
	</div>
</div>
</body>
</html>
