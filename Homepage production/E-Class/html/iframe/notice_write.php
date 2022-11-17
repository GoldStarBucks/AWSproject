<?php
    include "../../inc/eclassinfo.inc";
    include "../member/stud_prof_flag.php";

    session_start();
    if (isset($_SESSION["userid"])) {
        $id = $_SESSION['userid'];
        $flag = stud_or_prof($id);

        if ($flag[1] == "professor") {
            $title = $_POST["title"];
            $content = $_POST["content"];
            $datetime = date("Y-m-d", time());
            if ($title != '' && $content != '') {
                $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
                if(mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();
                $query = "INSERT INTO notice(num, title, content, writer, create_date) VALUES (NULL, '$title', '$content', '$flag[0]', '$datetime');";
	            $insert = mysqli_query($connection, $query); 
	            echo '<script>alert("글 작성 완료"); document.location.href="./notice.php";</script>';
            }
        } else {
            echo "<script>alert('교직원만 작성 가능합니다.'); document.location.href='./notice.php';</script>";
        }
    } else {
        echo "<script>alert('로그인이 필요합니다'); document.location.href='./notice.php';</script>";
    }
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="../css/notice_post.css" />
	<title>게시판</title>
</head>
<body>
<div class="container">
    <form action="notice_write.php" method="post">
        <table class="board">
            <tr>
                <th class='title'>작성자</th>
                <th class='ttitle'><?php echo $flag[0]; ?></th>
            </tr>
            <tr>
                <th class='title'>제목</th>
                <th class='ttitle'><input name="title" rows="1" cols="55" maxlength="50" required></th>
            </tr>
            <tr>
                <th class='title'>내용</th>
                <th class='ttitle'><textarea name="content" rows="10" cols="100" required></textarea></th>
            </tr>
        </table>
        <div class='write-btn'>
            <button id='delete' type="submit">글 작성</button>
        </div>
    </form>
    <div class='write-btn'>
        <button id='list' onclick="location.href='./notice.php'">전체 글</button>
    </div>
</div>
</body>
</html>
