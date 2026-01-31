<?php
require_once 'auth_check.php';

$message = '';
$error = '';

// Handle Create
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = "ユーザー名とパスワードを入力してください。";
    } else {
        // 重複チェック
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $error = "そのユーザー名は既に使用されています。";
        } else {
            // 作成
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
            $stmt->execute([$username, $password_hash]);
            $message = "管理者ユーザー '{$username}' を作成しました。";
        }
    }
}

// Handle Delete
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // 自分自身は削除不可
    if ($id == $_SESSION['admin_user_id']) {
        $error = "自分自身のアカウントは削除できません。";
    } else {
        // 最後の1人を削除させないチェック（オプション）
        $stmt = $pdo->query("SELECT COUNT(*) FROM users");
        $count = $stmt->fetchColumn();
        
        if ($count <= 1) {
            $error = "管理者が0人になるため削除できません。";
        } else {
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$id]);
            $message = "ユーザーを削除しました。";
        }
    }
}

// Handle Password Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_password') {
    $id = $_POST['id'];
    $new_password = $_POST['new_password'];
    
    if (empty($new_password)) {
        $error = "新しいパスワードを入力してください。";
    } else {
        $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
        $stmt->execute([$password_hash, $id]);
        $message = "パスワードを更新しました。";
    }
}

// Fetch Users
$stmt = $pdo->query("SELECT * FROM users ORDER BY created_at ASC");
$users_list = $stmt->fetchAll();
?>
<?php
// ページ設定
$active_menu = 'users';
$page_title = 'アカウント管理';

// ヘッダー読み込み
require_once 'header.php';
?>

<div class="container">
    <h2>アカウント管理</h2>
    
    <?php if ($message): ?>
        <div class="alert"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert" style="background: #f8d7da; color: #721c24; border-color: #f5c6cb;"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <!-- Add User Form -->
    <div class="panel">
        <h3 style="border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 20px;">新規管理者追加</h3>
        <form method="post">
            <input type="hidden" name="action" value="create">
            <div style="display: flex; gap: 20px; align-items: flex-end;">
                <div class="form-group" style="flex: 1;">
                    <label>ユーザー名</label>
                    <input type="text" name="username" placeholder="半角英数推奨" required>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label>パスワード</label>
                    <input type="text" name="password" placeholder="8文字以上の強力なパスワード" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-sm" style="padding: 10px 30px; font-size: 1rem;">追加する</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Users List -->
    <div class="panel">
        <h3 style="border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 20px;">管理者一覧</h3>
        <table>
            <thead>
                <tr>
                    <th style="width: 50px;">ID</th>
                    <th>ユーザー名</th>
                    <th style="width: 200px;">登録日時</th>
                    <th style="width: 300px;">パスワード変更</th>
                    <th style="width: 80px;">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users_list as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td>
                            <strong><?php echo htmlspecialchars($user['username']); ?></strong>
                            <?php if ($user['id'] == $_SESSION['admin_user_id']): ?>
                                <span class="status-badge status-replied" style="margin-left: 5px;">あなた</span>
                            <?php endif; ?>
                        </td>
                        <td style="color: #666; font-size: 0.9rem;"><?php echo htmlspecialchars($user['created_at']); ?></td>
                        <td>
                            <form method="post" style="display: flex; gap: 5px;">
                                <input type="hidden" name="action" value="update_password">
                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                <input type="text" name="new_password" placeholder="新しいパスワード" style="padding: 5px; font-size: 0.8rem;" required>
                                <button type="submit" class="btn btn-sm" style="font-size: 0.8rem;">変更</button>
                            </form>
                        </td>
                        <td>
                            <?php if ($user['id'] != $_SESSION['admin_user_id']): ?>
                                <a href="?action=delete&id=<?php echo $user['id']; ?>" class="btn-red" onclick="return confirm('本当にこのユーザーを削除してもよろしいですか？');">削除</a>
                            <?php else: ?>
                                <span style="color: #ccc;">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
