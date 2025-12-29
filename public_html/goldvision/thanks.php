<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>送信完了 | <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header>
    <div class="container">
        <div class="logo"><?php echo SITE_NAME; ?></div>
    </div>
</header>

<div class="section" style="min-height: 80vh; display: flex; align-items: center; justify-content: center;">
    <div class="container" style="text-align: center;">
        <h1 class="section-title">お問い合わせ完了</h1>
        <p>お問い合わせいただき、誠にありがとうございます。<br>
        ご入力いただいたメールアドレス宛に自動返信メールをお送りしました。</p>
        <p>担当者より確認次第、ご連絡させていただきます。</p>
        
        <br><br>
        
        <a href="index.php" class="btn">トップページへ戻る</a>
    </div>
</div>

<footer>
    <div class="container">
        <p class="copyright">&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?> All Rights Reserved.</p>
    </div>
</footer>

</body>
</html>
