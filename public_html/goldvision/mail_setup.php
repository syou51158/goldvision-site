<?php
// 設定
$ACCESS_PASSWORD = 'goldvision'; // ページ閲覧用パスワード

// アカウント情報定義
$ACCOUNTS = [
    'info' => [
        'name' => 'GOLD VISION info',
        'email' => 'info@goldvision.co.jp',
        'password' => 'm_Qr-F6-5ofe_5LC'
    ],
    'nakao' => [
        'name' => 'Keisuke Nakao',
        'email' => 'keisuke.nakao@goldvision.co.jp',
        'password' => 'Kn_2025_Gv-Pass'
    ],
    'fujita' => [
        'name' => 'Ryosuke Fujita',
        'email' => 'ryosuke.fujita@goldvision.co.jp',
        'password' => 'Rf_2025_Gv-Pass'
    ],
    'utsumi' => [
        'name' => 'Yu Utsumi',
        'email' => 'yu.utsumi@goldvision.co.jp',
        'password' => 'Gv-2025_Secret-Y'
    ],
    'nakaoka' => [
        'name' => 'Aira Nakaoka',
        'email' => 'aira.nakaoka@goldvision.co.jp',
        'password' => 'An_2025_Gv-Pass'
    ],
];

session_start();

// ログアウト処理
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: mail_setup.php');
    exit;
}

// ログイン処理
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['password']) && $_POST['password'] === $ACCESS_PASSWORD) {
        $_SESSION['authenticated'] = true;
        // リロード対策
        header('Location: mail_setup.php');
        exit;
    } else {
        $error = 'パスワードが間違っています。';
    }
}

// ダウンロード処理
if (isset($_GET['download']) && isset($_SESSION['authenticated']) && $_SESSION['authenticated']) {
    $key = $_GET['download'];
    if (array_key_exists($key, $ACCOUNTS)) {
        $account = $ACCOUNTS[$key];
        
        // mobileconfigのXMLを生成
        $uuid1 = strtoupper(md5($account['email'] . '1'));
        $uuid2 = strtoupper(md5($account['email'] . '2'));
        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE plist PUBLIC "-//Apple//DTD PLIST 1.0//EN" "http://www.apple.com/DTDs/PropertyList-1.0.dtd">
<plist version="1.0">
<dict>
    <key>PayloadContent</key>
    <array>
        <dict>
            <key>EmailAccountDescription</key>
            <string>GOLD VISION</string>
            <key>EmailAccountName</key>
            <string>' . htmlspecialchars($account['name']) . '</string>
            <key>EmailAccountType</key>
            <string>EmailTypeIMAP</string>
            <key>EmailAddress</key>
            <string>' . htmlspecialchars($account['email']) . '</string>
            <key>IncomingMailServerAuthentication</key>
            <string>EmailAuthPassword</string>
            <key>IncomingMailServerHostName</key>
            <string>imap.lolipop.jp</string>
            <key>IncomingMailServerPassword</key>
            <string>' . htmlspecialchars($account['password']) . '</string>
            <key>IncomingMailServerPortNumber</key>
            <integer>993</integer>
            <key>IncomingMailServerUseSSL</key>
            <true/>
            <key>IncomingMailServerUsername</key>
            <string>' . htmlspecialchars($account['email']) . '</string>
            <key>OutgoingMailServerAuthentication</key>
            <string>EmailAuthPassword</string>
            <key>OutgoingMailServerHostName</key>
            <string>smtp.lolipop.jp</string>
            <key>OutgoingMailServerPassword</key>
            <string>' . htmlspecialchars($account['password']) . '</string>
            <key>OutgoingMailServerPortNumber</key>
            <integer>465</integer>
            <key>OutgoingMailServerUseSSL</key>
            <true/>
            <key>OutgoingMailServerUsername</key>
            <string>' . htmlspecialchars($account['email']) . '</string>
            <key>PayloadDescription</key>
            <string>Configures email settings for ' . htmlspecialchars($account['email']) . '</string>
            <key>PayloadDisplayName</key>
            <string>GOLD VISION Email</string>
            <key>PayloadIdentifier</key>
            <string>jp.co.goldvision.mail.' . $key . '</string>
            <key>PayloadType</key>
            <string>com.apple.mail.managed</string>
            <key>PayloadUUID</key>
            <string>' . $uuid1 . '</string>
            <key>PayloadVersion</key>
            <integer>1</integer>
        </dict>
    </array>
    <key>PayloadDescription</key>
    <string>Install email settings for GOLD VISION</string>
    <key>PayloadDisplayName</key>
    <string>GOLD VISION Mail Setup (' . htmlspecialchars($account['name']) . ')</string>
    <key>PayloadIdentifier</key>
    <string>jp.co.goldvision.profile.' . $key . '</string>
    <key>PayloadOrganization</key>
    <string>GOLD VISION Co., Ltd.</string>
    <key>PayloadRemovalDisallowed</key>
    <false/>
    <key>PayloadType</key>
    <string>Configuration</string>
    <key>PayloadUUID</key>
    <string>' . $uuid2 . '</string>
    <key>PayloadVersion</key>
    <integer>1</integer>
</dict>
</plist>';

        header('Content-Description: File Transfer');
        header('Content-Type: application/x-apple-aspen-config');
        header('Content-Disposition: attachment; filename="mail-setup-' . $key . '.mobileconfig"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . strlen($xml));
        echo $xml;
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メール設定 | GOLD VISION</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Helvetica Neue", "Yu Gothic", YuGothic, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        h1 {
            font-size: 20px;
            margin-bottom: 20px;
            color: #d4af37; /* ゴールド風 */
        }
        p {
            font-size: 14px;
            margin-bottom: 20px;
            text-align: left;
        }
        .btn {
            display: inline-block;
            background-color: #d4af37;
            color: #fff;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 30px;
            font-weight: bold;
            font-size: 16px;
            margin: 20px 0;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border: none;
            cursor: pointer;
        }
        .btn:hover {
            opacity: 0.9;
        }
        .note {
            font-size: 12px;
            color: #666;
            text-align: left;
            background: #f0f0f0;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
        ol {
            text-align: left;
            padding-left: 20px;
            margin-bottom: 30px;
        }
        li {
            margin-bottom: 10px;
            font-size: 14px;
        }
        .login-form input[type="password"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 70%;
            margin-bottom: 10px;
            font-size: 16px;
        }
        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 15px;
        }
        .pc-settings {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: left;
        }
        .pc-settings h3 {
            font-size: 16px;
            margin-bottom: 15px;
            color: #333;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        .info-table th, .info-table td {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }
        .info-table th {
            width: 100px;
            background-color: #fafafa;
            font-weight: normal;
            color: #666;
        }
        .copy-text {
            cursor: pointer;
            color: #0066cc;
        }
        .account-list {
            text-align: left;
            margin-bottom: 20px;
        }
        .account-item {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .account-info {
            flex: 1;
        }
        .account-email {
            font-weight: bold;
            font-size: 14px;
            display: block;
        }
        .account-name {
            font-size: 12px;
            color: #666;
        }
        .btn-sm {
            display: inline-block;
            background-color: #d4af37;
            color: #fff;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            margin-left: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>GOLD VISION メール設定</h1>

    <?php if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']): ?>
        <!-- ログインフォーム -->
        <p style="text-align: center;">セキュリティのため、パスワードを入力してください。</p>
        
        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="post" class="login-form">
            <input type="password" name="password" placeholder="パスワード" required>
            <br>
            <button type="submit" class="btn">認証する</button>
        </form>

    <?php else: ?>
        <!-- iPhone用設定 -->
        <h2 style="font-size: 16px; border-bottom: 2px solid #d4af37; padding-bottom: 5px; margin-bottom: 20px; text-align: left;">iPhoneをお使いの方</h2>
        <p>ご自分のメールアドレスの「設定」ボタンを押してください。</p>
        
        <div class="account-list">
            <?php foreach ($ACCOUNTS as $key => $data): ?>
            <div class="account-item">
                <div class="account-info">
                    <span class="account-email"><?php echo htmlspecialchars($data['email']); ?></span>
                    <span class="account-name"><?php echo htmlspecialchars($data['name']); ?></span>
                </div>
                <a href="?download=<?php echo $key; ?>" class="btn-sm">設定</a>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="note">
            <strong>⚠️ 注意事項</strong><br>
            設定完了後、もしパスワードを求められた場合は、以下のPC用設定情報にあるパスワードを入力してください。
        </div>

        <div style="margin-top: 30px; text-align: left; background: #fff; padding: 20px; border: 1px solid #eee; border-radius: 5px;">
            <h3 style="margin-top: 0; font-size: 16px; color: #333;">設定手順（iPhone）</h3>
            <ol style="padding-left: 20px; margin-bottom: 0;">
                <li>上のリストから自分のメールアドレスの<strong>「設定」</strong>ボタンをタップします。</li>
                <li>「Webサイトが構成プロファイルをダウンロードしようとしています。許可しますか？」と表示されたら<strong>「許可」</strong>をタップします。</li>
                <li>「プロファイルがダウンロードされました」と表示されたら「閉じる」をタップします。</li>
                <li>iPhoneのホーム画面に戻り、<strong>「設定」アプリ</strong>を開きます。</li>
                <li>設定メニューの上部にある<strong>「ダウンロード済みのプロファイル」</strong>をタップします。</li>
                <li>「インストール」をタップし、画面の指示に従って進みます（画面ロックのパスコード入力が必要です）。</li>
                <li>完了すると、標準の「メール」アプリでメール送受信が可能になります。</li>
            </ol>
        </div>

        <!-- PC用設定 -->
        <div class="pc-settings">
            <h2 style="font-size: 16px; border-bottom: 2px solid #d4af37; padding-bottom: 5px; margin-bottom: 20px;">パソコン・手動設定の方</h2>
            <p>OutlookやThunderbird、Mac標準メールなどのソフトには、以下の情報を入力してください。</p>

            <h3 style="margin-top:20px; font-size:14px; background:#eee; padding:5px;">共通設定（全アカウント共通）</h3>
            <table class="info-table" style="margin-bottom:20px;">
                <tr>
                    <th>受信サーバー</th>
                    <td>
                        <strong>imap.lolipop.jp</strong><br>
                        <span style="font-size:11px; color:#666;">ポート: 993 (SSL)</span>
                    </td>
                </tr>
                <tr>
                    <th>送信サーバー</th>
                    <td>
                        <strong>smtp.lolipop.jp</strong><br>
                        <span style="font-size:11px; color:#666;">ポート: 465 (SSL)</span>
                    </td>
                </tr>
                <tr>
                    <th>認証方式</th>
                    <td>パスワード認証（平文）</td>
                </tr>
            </table>

            <h3 style="font-size:14px; background:#eee; padding:5px;">アカウント別情報</h3>
            
            <div style="margin-bottom: 20px;">
                <strong>1. info@goldvision.co.jp</strong>
                <table class="info-table">
                    <tr><th>パスワード</th><td>m_Qr-F6-5ofe_5LC</td></tr>
                </table>
            </div>

            <div style="margin-bottom: 20px;">
                <strong>2. keisuke.nakao@goldvision.co.jp</strong>
                <table class="info-table">
                    <tr><th>パスワード</th><td>Kn_2025_Gv-Pass</td></tr>
                </table>
            </div>

            <div style="margin-bottom: 20px;">
                <strong>3. ryosuke.fujita@goldvision.co.jp</strong>
                <table class="info-table">
                    <tr><th>パスワード</th><td>Rf_2025_Gv-Pass</td></tr>
                </table>
            </div>

            <div style="margin-bottom: 20px;">
                <strong>4. yu.utsumi@goldvision.co.jp</strong>
                <table class="info-table">
                    <tr><th>パスワード</th><td>Gv-2025_Secret-Y</td></tr>
                </table>
            </div>

            <div style="margin-bottom: 20px;">
                <strong>5. aira.nakaoka@goldvision.co.jp</strong>
                <table class="info-table">
                    <tr><th>パスワード</th><td>An_2025_Gv-Pass</td></tr>
                </table>
            </div>

        </div>
        
        <div style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px;">
            <a href="?logout=1" style="font-size: 12px; color: #999;">ログアウト</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
