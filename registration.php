<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/ress.min.css">
        <link rel="stylesheet" href="css/style.css">
        <title>Registration | Working time recorder</title>
    </head>
    <header>
		<div class="headerLeft">
			<h1>Working time recorder - Registration</h1>
		</div>
    </header>
    <body>
        <form class="inputs" method="post">
            <label class="input_label">ID: </label><input class="text_box" name="user_id"><br>
            <label class="input_label">ユーザー名: </label><input class="text_box" name="user_name"><br>
            <label class="input_label">GoogleカレンダーID: </label><input class="text_box" name="cal_id"><br>
            <input class="btn" type="submit" value="登録" name="register">
        </form>
    </body>
</html>

<?php
/* 読み込み
-----------------------*/
require_once("db_process.php");// DBの入出力関連

//利用登録処理
if($_POST['register'] && !empty($_POST['user_id']) && !empty($_POST['user_name']) && !empty($_POST['cal_id'])){
	user_registration($_POST['user_id'], $_POST['user_name'], $_POST['cal_id']); // [DB]新規ユーザー情報登録
	echo "<p class=\"result\">登録完了しました．</p>";
}elseif($_POST['register']){/**不正入力判定 */
	if(empty($_POST['user_id'])){
		echo '<p class="error">[ERROR]IDが入力されていません.<br></p>';
	}
	if(empty($_POST['user_name'])){
		echo '<p class="error">[ERROR]ユーザー名が入力されていません.<br></p>';
	}
	if(empty($_POST['cal_id'])){
		echo '<p class="error">[ERROR]GoogleカレンダーIDが入力されていません.<br></p>';
	}
	// TODO：その他バリデーション各種
}
?>