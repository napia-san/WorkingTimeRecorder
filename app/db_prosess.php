<?php

// [DB]user_name/GoogleカレンダーID取得
function get_user_info($user_id) {
    require_once("db_connector.php"); //DB接続関連
    $pdo = db_connector();

    try {
        $stmt = $pdo -> prepare("SELECT name, calendar_id FROM user_data WHERE user_id = :user_id");
        $stmt -> bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $stmt -> execute();
        foreach ($stmt as $row) {
            $user_name = $row['name'];
            $cal_id = $row['calendar_id'];
        }
    } catch(PDOException $e) {
    	echo $e->getMessage();
    	die();
    }
    $pdo = null;
    
    return array($user_name, $cal_id);
}

// [DB]作業開始時刻とイベントidの記録
function put_user_status($user_id, $event_id) {
    require_once("db_connector.php"); //DB接続関連
    $pdo = db_connector();
    $time = date("Y-m-d H:i:s");
    
    try {
        $sql = $pdo -> prepare("INSERT INTO time_card VALUES (:user_id, :start_time, :event_id)");
        $sql -> bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $sql -> bindParam(':start_time',$time , PDO::PARAM_STR);
        $sql -> bindParam(':event_id', $event_id, PDO::PARAM_STR);
        $sql -> execute();
    } catch(PDOException $e) {
    	echo $e->getMessage();
    	die();
    }
    $pdo = null;
    
    return $time;
}