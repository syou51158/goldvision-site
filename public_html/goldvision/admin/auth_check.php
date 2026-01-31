<?php
session_start();
require_once '../config.php';
require_once '../db_connect.php';

// ログインチェック
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// ログアウト処理
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    // セッション変数を全て解除
    $_SESSION = array();
    // セッションクッキーを削除
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    // セッション破棄
    session_destroy();
    header('Location: login.php');
    exit;
}

// セッションハイジャック対策: 定期的にID再生成
if (!isset($_SESSION['last_regeneration'])) {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
} else {
    $interval = 60 * 30; // 30分ごとにID変更
    if (time() - $_SESSION['last_regeneration'] >= $interval) {
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }
}
?>
