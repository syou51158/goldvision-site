<?php
require_once 'auth_check.php';

// お問い合わせ一覧取得
$stmt = $pdo->query("SELECT * FROM inquiries ORDER BY created_at DESC");
$inquiries = $stmt->fetchAll();
?>
<?php
// ページ設定
$active_menu = 'home';
$page_title = 'お問い合わせ一覧';


// ヘッダー読み込み
require_once 'header.php';
?>

<div class="container">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 20px;">
        <h2>お問い合わせ一覧</h2>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 50px;">ID</th>
                <th style="width: 180px;">受信日時</th>
                <th style="width: 100px;">ステータス</th>
                <th style="width: 150px;">種別</th>
                <th>お名前 / 会社名</th>
                <th style="width: 100px;">アクション</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($inquiries)): ?>
                <tr>
                    <td colspan="6" style="text-align:center; padding: 40px; color: #888;">お問い合わせはまだありません。</td>
                </tr>
            <?php else: ?>
                <?php foreach ($inquiries as $inquiry): ?>
                    <tr>
                        <td><?php echo $inquiry['id']; ?></td>
                        <td style="font-size: 0.9rem; color: #666;"><?php echo htmlspecialchars($inquiry['created_at']); ?></td>
                        <td>
                            <span class="status-badge status-<?php echo htmlspecialchars($inquiry['status']); ?>">
                                <?php
                                $status_labels = ['unread' => '未対応', 'replied' => '返信済', 'done' => '完了'];
                                echo $status_labels[$inquiry['status']] ?? $inquiry['status'];
                                ?>
                            </span>
                        </td>
                        <td><?php echo htmlspecialchars($inquiry['type']); ?></td>
                        <td>
                            <strong><?php echo htmlspecialchars($inquiry['name']); ?></strong><br>
                            <span style="font-size: 0.85rem; color: #888;"><?php echo htmlspecialchars($inquiry['company']); ?></span>
                        </td>
                        <td>
                            <a href="details.php?id=<?php echo $inquiry['id']; ?>" class="btn-sm">詳細確認</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
