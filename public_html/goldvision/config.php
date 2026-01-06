<?php
// config.php

// サイト基本情報
define('SITE_NAME', 'GOLD VISION 株式会社');
define('SITE_NAME_EN', 'GOLD VISION Co., Ltd.');
define('SITE_URL', (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . '/goldvision/');

// メール設定
// 管理者メールアドレス（お問い合わせ受信先）
define('ADMIN_EMAIL', 'info@goldvision.co.jp'); 

// 自動返信メールの送信元アドレス
// ロリポップの場合、ドメインのメールアドレスを設定することを推奨します（なりすまし判定回避のため）
// 独自ドメイン運用なら info@goldvision.co.jp などが理想ですが、なければgmailでも可（ただし迷惑メールに入りやすい）
// 一旦、送信元も管理者メールと同じにします
define('FROM_EMAIL', 'info@goldvision.co.jp');
define('FROM_NAME', SITE_NAME);

// 会社情報
define('COMPANY_NAME', 'GOLD VISION 株式会社');
define('COMPANY_NAME_KANA', 'ゴールドヴィジョン');
define('CEO_NAME', '中尾 敬祐');
define('CEO_NAME_EN', 'NAKAO KEISUKE');
define('REGISTRATION_DATE', '2025年11月18日');

// 住所情報
define('COMPANY_POSTAL_CODE', '569-0826');
define('COMPANY_ADDRESS', '大阪府高槻市寿町二丁目21番25号 バッハレジデンスI 102号室');
define('COMPANY_ADDRESS_EN', 'Bach Residence I 102, 2-21-25 Kotobuki-cho, Takatsuki-shi, Osaka 569-0826, Japan');

// 連絡先
// 電話番号は未定の場合は空文字、または代表者携帯など
define('COMPANY_PHONE', '080-6154-7156'); 
define('COMPANY_EMAIL', 'info@goldvision.co.jp');
