<?php
// DB接続関連
function db_connector(){
    require_once('putenv.php'); //環境変数読み込み
    try {
        $dsn = get_env('DB_DSN');
        $user = get_env('DB_ID');
        $password = get_env('DB_PASS');
        
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }catch (PDOException $e) {
        echo $e->getMessage();
        return $db = null;
    }
}