<?php
session_start();
require_once '../config.php';
require_once '../db_connect.php';

// ログインチェック
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

// ステータス更新処理
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
    $stmt = $pdo->prepare("UPDATE inquiries SET status = ? WHERE id = ?");
    $stmt->execute([$_POST['status'], $id]);
    // リロードして反映
    header("Location: details.php?id={$id}");
    exit;
}

// データ取得
$stmt = $pdo->prepare("SELECT * FROM inquiries WHERE id = ?");
$stmt->execute([$id]);
$inquiry = $stmt->fetch();

if (!$inquiry) {
    die("Data not found.");
}
?>
<?php
// ページ設定
$active_menu = 'home'; // Details is part of "Home/Inquiries" section
$page_title = 'お問い合わせ詳細';


// ヘッダー読み込み
require_once 'header.php';
?>

<div class="container">
    <p style="margin-bottom: 20px;"><a href="index.php" style="text-decoration: none; color: #666;">&larr; 一覧に戻る</a></p>
    
    <div class="panel" style="display: flex; align-items: center; justify-content: space-between;">
        <div style="font-size: 1.2rem; font-weight: bold;">
            現在のステータス: 
            <span class="status-badge status-<?php echo htmlspecialchars($inquiry['status']); ?>" style="font-size: 1rem; margin-left: 10px;">
                <?php 
                $status_labels = ['unread' => '未対応', 'replied' => '返信済', 'done' => '完了'];
                echo $status_labels[$inquiry['status']] ?? $inquiry['status']; 
                ?>
            </span>
        </div>
        <form method="post" style="display:flex; align-items: center; gap:10px;">
            <label style="margin:0; font-weight: normal;">ステータス変更:</label>
            <select name="status" style="width: auto; padding: 8px;">
                <option value="unread" <?php if($inquiry['status']=='unread') echo 'selected'; ?>>未対応</option>
                <option value="replied" <?php if($inquiry['status']=='replied') echo 'selected'; ?>>返信済み</option>
                <option value="done" <?php if($inquiry['status']=='done') echo 'selected'; ?>>完了</option>
            </select>
            <button type="submit" class="btn btn-sm">更新</button>
        </form>
    </div>

    <div class="panel">
        <h2 style="border-bottom: 1px solid #eee; padding-bottom: 15px;">お問い合わせ内容</h2>
        
        <dl style="display: flex; flex-wrap: wrap; margin: 0;">
            <div style="width: 50%; padding: 15px 0; border-bottom: 1px solid #f5f5f5;">
                <dt style="font-size: 0.85rem; color: #888; margin-bottom: 5px;">受信日時</dt>
                <dd style="font-size: 1.1rem;"><?php echo htmlspecialchars($inquiry['created_at']); ?></dd>
            </div>
            <div style="width: 50%; padding: 15px 0; border-bottom: 1px solid #f5f5f5;">
                <dt style="font-size: 0.85rem; color: #888; margin-bottom: 5px;">種別</dt>
                <dd style="font-size: 1.1rem;"><?php echo htmlspecialchars($inquiry['type']); ?></dd>
            </div>
            
            <div style="width: 50%; padding: 15px 0; border-bottom: 1px solid #f5f5f5;">
                <dt style="font-size: 0.85rem; color: #888; margin-bottom: 5px;">お名前</dt>
                <dd style="font-size: 1.1rem; font-weight: bold;"><?php echo htmlspecialchars($inquiry['name']); ?></dd>
            </div>
            <div style="width: 50%; padding: 15px 0; border-bottom: 1px solid #f5f5f5;">
                <dt style="font-size: 0.85rem; color: #888; margin-bottom: 5px;">会社名</dt>
                <dd style="font-size: 1.1rem;"><?php echo htmlspecialchars($inquiry['company']); ?></dd>
            </div>
            
            <div style="width: 50%; padding: 15px 0; border-bottom: 1px solid #f5f5f5;">
                <dt style="font-size: 0.85rem; color: #888; margin-bottom: 5px;">メールアドレス</dt>
                <dd>
                    <a href="mailto:<?php echo htmlspecialchars($inquiry['email']); ?>" style="color: var(--gold); text-decoration: none;">
                        <?php echo htmlspecialchars($inquiry['email']); ?>
                    </a>
                </dd>
            </div>
            <div style="width: 50%; padding: 15px 0; border-bottom: 1px solid #f5f5f5;">
                <dt style="font-size: 0.85rem; color: #888; margin-bottom: 5px;">電話番号</dt>
                <dd><?php echo htmlspecialchars($inquiry['phone']); ?></dd>
            </div>
        </dl>
        
        <div style="margin-top: 30px;">
            <dt style="font-size: 0.85rem; color: #888; margin-bottom: 10px;">メッセージ本文</dt>
            <div style="background: #f9f9fb; padding: 20px; border-radius: 4px; white-space: pre-wrap; line-height: 1.8; border: 1px solid #eee;"><?php echo htmlspecialchars($inquiry['message']); ?></div>
        </div>
    </div>
</div>

</body>
</html>
