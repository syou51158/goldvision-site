<?php
session_start();
require_once '../config.php';
require_once '../db_connect.php';

// Check login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$message = '';

// Handle Create
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    $date = $_POST['date'];
    $title = $_POST['title'];
    $content = $_POST['content']; // Optional link or short text

    if ($date && $title) {
        $stmt = $pdo->prepare("INSERT INTO news (published_date, title, content) VALUES (?, ?, ?)");
        $stmt->execute([$date, $title, $content]);
        $message = "ニュースを追加しました。";
    }
}

// Handle Delete
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM news WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $message = "ニュースを削除しました。";
}

// Fetch News
$stmt = $pdo->query("SELECT * FROM news ORDER BY published_date DESC, created_at DESC");
$news_list = $stmt->fetchAll();
?>
<?php
// ページ設定
$active_menu = 'news';
$page_title = 'ニュース管理';


// ヘッダー読み込み
require_once 'header.php';
?>

<div class="container">
    <h2>ニュース管理</h2>
    
    <?php if ($message): ?>
        <div class="alert"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <!-- Add News Form -->
    <div class="panel">
        <h3 style="border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 20px;">新規ニュース投稿</h3>
        <form method="post">
            <input type="hidden" name="action" value="create">
            <div style="display: flex; gap: 20px;">
                <div class="form-group" style="width: 200px;">
                    <label>日付</label>
                    <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label>タイトル</label>
                    <input type="text" name="title" placeholder="例：ウェブサイトをリニューアルしました" required>
                </div>
            </div>
            <div class="form-group">
                <label>詳細・リンクURL（任意）</label>
                <textarea name="content" rows="3" placeholder="詳細テキスト、またはリンクさせたいURLがあれば入力してください"></textarea>
            </div>
            <div style="text-align: right;">
                <button type="submit" class="btn btn-sm" style="padding: 10px 30px; font-size: 1rem;">追加する</button>
            </div>
        </form>
    </div>

    <!-- News List -->
    <div class="panel">
        <h3 style="border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 20px;">投稿済みニュース一覧</h3>
        <table>
            <thead>
                <tr>
                    <th style="width: 150px;">日付</th>
                    <th>タイトル</th>
                    <th>詳細</th>
                    <th style="width: 80px;">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($news_list)): ?>
                    <tr><td colspan="4" style="text-align: center; padding: 30px; color: #888;">まだ投稿がありません。</td></tr>
                <?php else: ?>
                    <?php foreach ($news_list as $news): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($news['published_date']); ?></td>
                            <td><strong><?php echo htmlspecialchars($news['title']); ?></strong></td>
                            <td style="color: #666; font-size: 0.9rem;"><?php echo htmlspecialchars(mb_strimwidth($news['content'] ?? '', 0, 50, '...')); ?></td>
                            <td>
                                <a href="?action=delete&id=<?php echo $news['id']; ?>" class="btn-red" onclick="return confirm('本当に削除しますか？');">削除</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
