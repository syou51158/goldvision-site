<?php
session_start();
require_once 'config.php';

// POSTリクエスト以外はリダイレクト
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// CSRFトークンチェック (簡易)
if (empty($_POST['token']) || empty($_SESSION['token']) || $_POST['token'] !== $_SESSION['token']) {
    die('Invalid Request.');
}

// スパムチェック (Honeypot)
// 'website'というname属性のhiddenフィールドが入力されていたらスパムとみなす
if (!empty($_POST['website'])) {
    die('Spam detected.');
}

// 入力データの取得とサニタイズ
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$company = filter_input(INPUT_POST, 'company', FILTER_SANITIZE_SPECIAL_CHARS);
$phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_SPECIAL_CHARS);
$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);

// バリデーション
$errors = [];
if (empty($name)) $errors[] = 'お名前は必須です。';
if (!$email) $errors[] = 'メールアドレスの形式が正しくありません。';
if (empty($type)) $errors[] = 'お問い合わせ種別を選択してください。';
if (empty($message)) $errors[] = 'お問い合わせ内容は必須です。';
if (mb_strlen($message) > 1000) $errors[] = 'お問い合わせ内容は1000文字以内で入力してください。';

// エラーがある場合
if (!empty($errors)) {
    // エラー表示ページなどは作らず、簡易的に戻るリンクを表示（要件「最短公開」優先）
    echo '<h1>入力エラー</h1>';
    echo '<ul>';
    foreach ($errors as $error) {
        echo "<li>{$error}</li>";
    }
    echo '</ul>';
    echo '<p><a href="javascript:history.back()">戻る</a></p>';
    exit;
}

// メール送信準備
mb_language("Japanese");
mb_internal_encoding("UTF-8");

// DB保存 (Phase 1)
try {
    require_once 'db_connect.php'; // DB接続
    $stmt = $pdo->prepare("INSERT INTO inquiries (type, name, company, email, phone, message) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$type, $name, $company, $email, $phone, $message]);
} catch (Exception $e) {
    // DBエラーが起きてもメールは送るようにする（またはエラー処理）
    // error_log($e->getMessage());
}

// 1. 管理者へ送信
$admin_subject = "【" . SITE_NAME . "】Webサイトからのお問い合わせ";
$admin_body = <<<EOD
Webサイトから新しいお問い合わせがありました。

■お問い合わせ内容
--------------------------------------------------
[種別] {$type}
[お名前] {$name}
[会社名] {$company}
[メール] {$email}
[電話番号] {$phone}

[内容]
{$message}
--------------------------------------------------

送信日時： {date('Y-m-d H:i:s')}
送信元IP： {$_SERVER['REMOTE_ADDR']}
EOD;

$admin_headers = "From: " . mb_encode_mimeheader(FROM_NAME) . " <" . FROM_EMAIL . ">";
// 返信先をユーザーのメールアドレスに設定
$admin_headers .= "\nReply-To: " . $email;

// 2. ユーザーへ自動返信
$user_subject = "【" . SITE_NAME . "】お問い合わせありがとうございます";
$user_body = <<<EOD
{$name} 様

この度は、お問い合わせいただき誠にありがとうございます。
以下の内容で受け付けいたしました。
担当者より確認次第、折り返しご連絡させていただきます。

--------------------------------------------------
[種別] {$type}
[お名前] {$name}
[会社名] {$company}
[メール] {$email}
[電話番号] {$phone}

[内容]
{$message}
--------------------------------------------------

※このメールは自動送信されています。
心当たりがない場合は、お手数ですが破棄してください。

━━━━━━━━━━━━━━━━━━━━━━━━━━
" . SITE_NAME . "
" . COMPANY_ADDRESS . "
EOD;

$user_headers = "From: " . mb_encode_mimeheader(FROM_NAME) . " <" . FROM_EMAIL . ">";

// 送信実行
$admin_result = mb_send_mail(ADMIN_EMAIL, $admin_subject, $admin_body, $admin_headers);
$user_result = mb_send_mail($email, $user_subject, $user_body, $user_headers);

if ($admin_result) {
    // セッションクリア（トークンのみ再生成するか、完了画面で使うなら保持）
    // 今回は完了画面へリダイレクト
    header('Location: thanks.php');
    exit;
} else {
    echo 'メール送信に失敗しました。時間をおいて再度お試しください。';
}
