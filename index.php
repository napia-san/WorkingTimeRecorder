<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/ress.min.css">
        <link rel="stylesheet" href="css/style.css">
        <title>Working time recorder</title>
    </head>
    <header>
		<div class="headerLeft">
			<h1>Working time recorder</h1>
		</div>
    </header>
    <body>
        <form class="inputs" method="post">
            <label class="input_label">ID: </label><input class="text_box" name="user_id"><br>
            <input class="btn" type="submit" value="開始" name="start">
            <input class="btn" type="submit" value="終了"name="finish">
        </form>
        <div class="others">
            <button class="btn btn_register" onclick="location.href='registration.html'">利用登録</button>
        </div>
        <div class="results">
            <?php
            require_once("db_process.php");// DBの入出力関連
            require_once("calendar_process.php"); // Googleカレンダーの入出力関連
            
            //作業開始時間登録
            if($_POST['start'] && !empty($_POST['user_id'])){
                $user_id = $_POST['user_id'];
                list($user_name, $cal_id) = get_user_info($user_id); // [DB]user_name/GoogleカレンダーID取得
                $event_id = insert_event($cal_id); // [Calendar]イベントの挿入(開始時間の記録)
                $time = put_user_status($user_id, $event_id); // [DB]作業開始時刻とイベントidの記録
                echo "<p class=\"result\">" . $user_name . "(" . htmlspecialchars($user_id, ENT_QUOTES) . ")さん：" . $time . "に作業開始しました</p>";
            }elseif($_POST['start']){/**不正入力判定 */
                if(empty($_POST['id'])){
                    echo '<p class="error">[ERROR]IDが入力されていません.<br></p>';
                }
                // TODO：その他バリデーション各種
            }
            ?>
        </div>
    </body>
</html>