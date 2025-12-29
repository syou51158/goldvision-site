<?php
// config.php

// サイト基本情報
define('SITE_NAME', 'GOLD VISION 株式会社');
define('SITE_URL', (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . '/goldvision/');

// メール設定（★差し替え箇所）
// 管理者メールアドレス（お問い合わせ受信先）
// 本番公開時に必ず正式なメールアドレスに変更してください。
define('ADMIN_EMAIL', 'info@example.com'); 

// 自動返信メールの送信元アドレス
// ロリポップの場合、ドメインのメールアドレスを設定することを推奨します。
define('FROM_EMAIL', 'noreply@' . $_SERVER['HTTP_HOST']);
define('FROM_NAME', SITE_NAME);

// 会社情報
define('COMPANY_NAME', 'GOLD VISION 株式会社');
define('CEO_NAME', '中尾 敬祐');
define('COMPANY_ADDRESS', '〒569-0826 大阪府高槻市寿町2-21-25-102');
define('COMPANY_PHONE', '080-6154-7156'); // 必要に応じて固定電話へ変更
