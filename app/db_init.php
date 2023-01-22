<?php
require_once("db_connector.php"); //DB接続関連
$pdo = db_connector();

/*テーブルの設定
------------------------------------------*/
try {
    // ユーザー情報
    $sql = "CREATE TABLE IF NOT EXISTS user_data"
    ."("
    ."user_id CHAR(8),"
    ."name CHAR(32),"
    ."calendar_id CHAR(140)"
    .");";
    $stmt = $pdo -> query($sql);
} catch(PDOException $e) {
	echo $e->getMessage();
	die();
}

try {
    // 作業中情報
    $sql = "CREATE TABLE IF NOT EXISTS time_card"
    ."("
    ."user_id CHAR(8),"
    ."start_time DATETIME,"
    ."event_id CHAR(140)"
    .");";
    $stmt = $pdo -> query($sql);
} catch(PDOException $e) {
	echo $e->getMessage();
	die();
}

$pdo = null;