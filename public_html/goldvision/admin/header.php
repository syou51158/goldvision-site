<?php
// Ensure SITE_NAME is available if not already
if (!defined('SITE_NAME')) {
    require_once '../config.php';
}

// Logout logic can be centralized here if we act on ?action=logout globally on included pages,
// but usually it's better to handle logic before HTML output. 
// For now, we assume the parent script handles logic and this file is just for View.
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? '管理画面'; ?> | <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        /* Admin Common CSS */
        body { background-color: #f4f4f9; color: #333; font-family: sans-serif; height: auto; overflow: auto; }
        header { background: #1a1a1a; color: #fff; padding: 10px 0; position: static; margin-bottom: 30px; }
        .container { max-width: 1000px; margin: 0 auto; padding: 0 20px; }
        .admin-nav { display: flex; justify-content: space-between; align-items: center; }
        .admin-nav ul { list-style: none; display: flex; gap: 20px; margin: 0; padding: 0; }
        .admin-nav a { color: #ccc; text-decoration: none; font-size: 0.95rem; transition: color 0.3s; }
        .admin-nav a:hover { color: var(--gold); }
        .admin-nav a.active { color: var(--gold); font-weight: bold; border-bottom: 1px solid var(--gold); }
        
        /* Common table & panel styles */
        table { width: 100%; border-collapse: collapse; background: #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-radius: 4px; overflow: hidden; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f0f0f5; font-weight: bold; color: #444; }
        tr:hover { background: #fbfbfb; }
        
        .panel { background: #fff; padding: 25px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); margin-bottom: 25px; border-radius: 5px; }
        h1, h2, h3 { color: #222; margin-top: 0; font-family: sans-serif; }
        
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; color: #555; }
        input[type="text"], input[type="date"], input[type="email"], input[type="tel"], textarea, select { 
            width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; font-size: 1rem;
        }
        input:focus, textarea:focus, select:focus { border-color: var(--gold); outline: none; }
        
        .btn { cursor: pointer; display: inline-block; text-align: center; }
        .btn-sm { padding: 6px 12px; font-size: 0.85rem; background: var(--gold); color: #000; border-radius: 4px; text-decoration: none; }
        .btn-red { background: #e74c3c; color: #fff; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 0.85rem; }
        .btn-red:hover { background: #c0392b; }
        
        .alert { padding: 15px; background: #d4edda; color: #155724; margin-bottom: 20px; border-radius: 4px; border: 1px solid #c3e6cb; }
        
        /* Status Badges */
        .status-badge { padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; display: inline-block; font-weight: 500; }
        .status-unread { background: #ffebee; color: #c62828; }
        .status-replied { background: #e8f5e9; color: #2e7d32; }
        .status-done { background: #f5f5f5; color: #616161; }
    </style>
</head>
<body>

<header>
    <div class="container admin-nav">
        <div class="logo" style="font-weight: bold; font-family: 'Cinzel', serif; font-size: 1.2rem;"><?php echo SITE_NAME; ?> <span style="font-size: 0.8rem; font-weight: normal; color: #666;">ADMIN</span></div>
        <nav>
            <ul>
                <li><a href="index.php" <?php echo ($active_menu ?? '') === 'home' ? 'class="active"' : ''; ?>>お問い合わせ一覧</a></li>
                <li><a href="news.php" <?php echo ($active_menu ?? '') === 'news' ? 'class="active"' : ''; ?>>ニュース設定</a></li>
                <li style="border-left: 1px solid #444; padding-left: 20px; margin-left: 10px;">
                    <a href="../index.php" target="_blank" style="display:flex; align-items:center; gap:5px;">
                        Webサイト確認 <span style="font-size: 12px;">↗</span>
                    </a>
                </li>
                <li><a href="?action=logout" style="color: #999;">ログアウト</a></li>
            </ul>
        </nav>
    </div>
</header>
