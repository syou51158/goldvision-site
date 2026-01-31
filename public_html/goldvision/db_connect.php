<?php
// db_connect.php
// SQLiteデータベースへの接続とテーブル作成を行う

// データベースファイルのパス
$db_path = __DIR__ . '/goldvision.db';

try {
    // データベース接続
    $pdo = new PDO('sqlite:' . $db_path);
    // エラー発生時に例外を投げるように設定
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // デフォルトのフェッチモードを連想配列に
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // テーブル作成（存在しない場合のみ）
    
    // 1. お問い合わせテーブル (inquiries)
    $pdo->exec("CREATE TABLE IF NOT EXISTS inquiries (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        type TEXT,
        name TEXT,
        company TEXT,
        email TEXT,
        phone TEXT,
        message TEXT,
        status TEXT DEFAULT 'unread', -- unread, replied, done
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // 2. ニューステーブル (news) - Phase 2用
    $pdo->exec("CREATE TABLE IF NOT EXISTS news (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT,
        content TEXT,
        published_date DATE,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
    
    // 3. 管理者ユーザーテーブル (users) - 将来の拡張用（今回は簡易認証のため未使用の可能性あり）
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT UNIQUE,
        password_hash TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

} catch (PDOException $e) {
    // エラー時はログに残すか、特定のメッセージを表示
    error_log("Database Connection Error: " . $e->getMessage());
    die("データベース接続エラーが発生しました。");
}
