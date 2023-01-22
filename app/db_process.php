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
        $stmt = $pdo -> prepare("INSERT INTO time_card VALUES (:user_id, :start_time, :event_id)");
        $stmt -> bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $stmt -> bindParam(':start_time',$time , PDO::PARAM_STR);
        $stmt -> bindParam(':event_id', $event_id, PDO::PARAM_STR);
        $stmt -> execute();
    } catch(PDOException $e) {
    	echo $e->getMessage();
    	die();
    }
    $pdo = null;
    
    return $time;
}

// [DB]作業開始時刻とイベントidの取得
function get_event_info($user_id) {
    require_once("db_connector.php"); //DB接続関連
    $pdo = db_connector("main_db");
    try {
        $stmt = $pdo -> prepare("SELECT start_time, event_id FROM time_card WHERE user_id = :user_id");
        $stmt -> bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $stmt -> execute();
        foreach ($stmt as $row) {
            $start_time = $row['start_time'];
            $event_id = $row['event_id'];
        }
    } catch(PDOException $e) {
    	echo $e->getMessage();
    	die();
    }
    $pdo = null;
    
    return array($start_time, $event_id);
}

// [DB]作業中レコードの削除(作業終了処理)
function delete_event_info($user_id) {
    require_once("db_connector.php"); //DB接続関連
    $pdo = db_connector("main_db");
    try {
        $finish_time = date("Y-m-d H:i:s");
        $stmt = $pdo -> prepare("DELETE FROM time_card WHERE user_id = :user_id");
        $stmt -> bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $stmt -> execute();
    } catch(PDOException $e) {
    	echo $e->getMessage();
    	die();
    }
    $pdo = null;
    
    return $finish_time;
}

function user_registration($user_id, $user_name, $cal_id) {
    require_once("db_connector.php"); //DB接続関連
    $pdo = db_connector();
    
    try {
        $stmt = $pdo -> prepare("INSERT INTO user_data(user_id, name, calendar_id) VALUES (:user_id, :name, :calendar_id)");
        $stmt -> bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $stmt -> bindParam(':name',$user_name , PDO::PARAM_STR);
        $stmt -> bindParam(':calendar_id', $cal_id, PDO::PARAM_STR);
        $stmt -> execute();
    } catch(PDOException $e) {
    	echo $e->getMessage();
    	die();
    }
    $pdo = null;
    
    return $time;
}