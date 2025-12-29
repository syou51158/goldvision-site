<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プライバシーポリシー | <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .privacy-content {
            background-color: #222;
            padding: 40px;
            text-align: left;
            line-height: 2;
        }
        .privacy-content h2 {
            color: var(--gold);
            font-size: 1.2rem;
            margin-top: 2rem;
            margin-bottom: 1rem;
            border-bottom: 1px solid #444;
        }
        .privacy-content h2:first-child {
            margin-top: 0;
        }
    </style>
</head>
<body>

<header>
    <div class="container">
        <div class="logo"><a href="index.php"><?php echo SITE_NAME; ?></a></div>
    </div>
</header>

<div class="section">
    <div class="container">
        <h1 class="section-title">プライバシーポリシー</h1>
        
        <div class="privacy-content">
            <h2>1. 個人情報の利用目的</h2>
            <p>当サイトでは、メールでのお問い合わせなどの際に、お名前、メールアドレス等の個人情報をご登録いただく場合がございます。これらの個人情報は質問に対する回答や必要な情報を電子メールなどをでご連絡する場合に利用させていただくものであり、個人情報をご提供いただく際の目的以外では利用いたしません。</p>

            <h2>2. 個人情報の第三者への開示</h2>
            <p>当サイトでは、個人情報は適切に管理し、以下に該当する場合を除いて第三者に開示することはありません。</p>
            <ul>
                <li>・本人のご了解がある場合</li>
                <li>・法令等への協力のため、開示が必要となる場合</li>
            </ul>

            <h2>3. 個人情報の開示、訂正、追加、削除、利用停止</h2>
            <p>ご本人からの個人データの開示、訂正、追加、削除、利用停止のご希望の場合には、ご本人であることを確認させていただいた上、速やかに対応させていただきます。</p>

            <h2>4. プライバシーポリシーの変更について</h2>
            <p>当サイトは、個人情報に関して適用される日本の法令を遵守するとともに、本ポリシーの内容を適宜見直しその改善に努めます。修正された最新のプライバシーポリシーは常に本ページにて開示されます。</p>

            <h2>5. お問い合わせ</h2>
            <p>当社の個人情報の取扱に関するお問い合せは下記までご連絡ください。</p>
            <p>
                <?php echo SITE_NAME; ?><br>
                <?php echo COMPANY_ADDRESS; ?><br>
                お問い合わせはフォームよりお願いいたします。
            </p>
        </div>
        
        <div style="text-align: center; margin-top: 40px;">
            <a href="index.php" class="btn">トップページへ戻る</a>
        </div>
    </div>
</div>

<footer>
    <div class="container">
        <p class="copyright">&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?> All Rights Reserved.</p>
    </div>
</footer>

</body>
</html>
