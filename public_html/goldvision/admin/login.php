<?php
session_start();
require_once '../config.php';
require_once '../db_connect.php';

// CSRFトークン生成
if (empty($_SESSION['admin_csrf_token'])) {
    $_SESSION['admin_csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['admin_csrf_token'];

// 既にログイン済みならダッシュボードへ
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? '';
    if (!hash_equals($csrf_token, $token)) {
        die('Invalid Request.');
    }

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = 'ユーザー名とパスワードを入力してください。';
    } else {
        try {
            // DBからユーザー取得
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->execute([':username' => $username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                // ログイン成功
                session_regenerate_id(true); // セッションハイジャック対策
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_user_id'] = $user['id'];
                $_SESSION['admin_username'] = $user['username'];
                header('Location: index.php');
                exit;
            } else {
                $error = 'ユーザー名またはパスワードが間違っています。';
                // セキュリティのため詳細なエラー（"ユーザーが存在しません"など）は出さない
            }
        } catch (PDOException $e) {
            $error = 'システムエラーが発生しました。';
            error_log($e->getMessage());
        }
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
            box-sizing: border-box; /* paddingを含めた幅計算 */
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
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($csrf_token); ?>">
        
        <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        
        <button type="submit" class="btn">LOGIN</button>
    </form>
    <p style="margin-top: 20px; font-size: 0.8rem; color: #666;">
        <a href="../index.php" style="color: #666; text-decoration: none;">&larr; Back to Site</a>
    </p>
</div>

</body>
</html>
