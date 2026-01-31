<?php
session_start();
require_once '../config.php';

// 既にログイン済みならダッシュボードへ
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    
    // 簡易的なパスワード認証（本来はDB管理推奨だが、小規模サイトのためconfig管理またはハードコード）
    // ここでは仮として 'admin1234' をパスワードとします。実運用では変更してください。
    // config.php に ADMIN_PASSWORD を定義するのが良いでしょう。
    
    // とりあえず簡易パスワード
    $valid_password = 'admin'; 

    if ($password === $valid_password) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: index.php');
        exit;
    } else {
        $error = 'パスワードが間違っています。';
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者ログイン | <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            background-color: #111;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .login-box {
            background: #222;
            padding: 40px;
            border-radius: 8px;
            border: 1px solid #333;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .login-box h1 {
            color: var(--gold);
            font-family: 'Cinzel', serif;
            margin-bottom: 20px;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            background: #333;
            border: 1px solid #444;
            color: #fff;
            border-radius: 4px;
        }
        .btn {
            width: 100%;
            cursor: pointer;
        }
        .error {
            color: #ff6b6b;
            margin-bottom: 15px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h1>ADMIN LOGIN</h1>
    <?php if ($error): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="post">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <button type="submit" class="btn">LOGIN</button>
    </form>
    <p style="margin-top: 20px; font-size: 0.8rem; color: #666;">
        <a href="../index.php" style="color: #666; text-decoration: none;">&larr; Back to Site</a>
    </p>
</div>

</body>
</html>
