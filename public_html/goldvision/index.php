<?php
session_start();
require_once 'config.php';

// CSRFトークン生成
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['token'];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> | 公式サイト</title>
    <meta name="description" content="<?php echo SITE_NAME; ?>の公式サイトです。現場に強い人材提案、スピード対応で長期的な価値を提供します。">
    
    <!-- OGP Settings -->
    <meta property="og:title" content="<?php echo SITE_NAME; ?> | 公式サイト">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo SITE_URL; ?>">
    <meta property="og:image" content="<?php echo SITE_URL; ?>assets/img/ogp.jpg">
    <meta property="og:site_name" content="<?php echo SITE_NAME; ?>">
    <meta property="og:description" content="現場に強い人材提案、スピード対応で長期的な価値を提供します。">
    <meta name="twitter:card" content="summary_large_image">

    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Favicon (Emoji for simplicity) -->
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>✨</text></svg>">
    <!-- Google Fonts (Noto Serif JP for premium feel) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        /* 見出しなどに明朝体を使用して高級感を出す */
        h1, h2, h3, .logo, .hero-sub {
            font-family: 'Noto Serif JP', serif;
        }
    </style>
</head>
<body>

<!-- ヘッダー -->
<header>
    <div class="container">
        <div class="logo">
            <a href="#"><?php echo SITE_NAME; ?></a>
        </div>
        <div class="menu-toggle">☰</div>
        <nav class="nav-menu">
            <ul>
                <li><a href="#features">強み</a></li>
                <li><a href="#service">事業内容</a></li>
                <li><a href="#company">会社概要</a></li>
                <li><a href="#contact" class="text-gold">お問い合わせ</a></li>
            </ul>
        </nav>
    </div>
</header>

<!-- ヒーローエリア -->
<div class="hero">
    <canvas id="hero-canvas"></canvas>
    <div class="container hero-content">
        <h1><?php echo SITE_NAME; ?></h1>
        <p class="en-sub">Providing unwavering value like gold</p>
        <span class="hero-sub">人材とビジネスに、揺るぎない価値を。</span>
        <div style="margin-top: 3rem;">
            <a href="#contact" class="btn">お問い合わせ</a>
        </div>
    </div>
</div>

<!-- 強み (Features) -->
<section id="features" class="section features">
    <div class="container">
        <h2 class="section-title">3つの強み</h2>
        <div class="features-grid">
            <div class="feature-card">
                <h3>01. 現場に強い人材提案</h3>
                <p>企業の課題を深く理解し、即戦力となる最適な人材をご提案。現場視点でのマッチングを重視しています。</p>
            </div>
            <div class="feature-card">
                <h3>02. スピード対応</h3>
                <p>ビジネスの機会を逃さないため、迅速なレスポンスと行動を徹底。急なご依頼にも柔軟に対応いたします。</p>
            </div>
            <div class="feature-card">
                <h3>03. 長期的な価値提供</h3>
                <p>一過性の関係ではなく、長期的なパートナーとして信頼関係を構築。「ゴールド」のような不変の価値を提供し続けます。</p>
            </div>
        </div>
    </div>
</section>

<!-- 事業内容 (Service) -->
<section id="service" class="section">
    <div class="container">
        <h2 class="section-title">事業内容</h2>
        <div class="service-list">
            <div class="service-item">
                <h3>人材派遣事業</h3>
                <p>必要なスキルを持った人材を、必要な期間・必要な人数、迅速に派遣いたします。</p>
            </div>
            <div class="service-item">
                <h3>人材紹介事業</h3>
                <p>貴社の採用課題に合わせて、最適な候補者をご紹介。採用成功まで伴走いたします。</p>
            </div>
            <div class="service-item">
                <h3>営業支援</h3>
                <p>新規開拓から既存顧客のフォローまで、営業活動を強力にサポートし、売上拡大に貢献します。</p>
            </div>
            <div class="service-item">
                <h3>業務支援・コンサルティング</h3>
                <p>業務プロセスの改善や効率化など、企業の成長を阻害する課題を解決へ導きます。</p>
            </div>
        </div>
        
        <div style="text-align: center; margin-top: 4rem; display: flex; justify-content: center; gap: 20px; flex-wrap: wrap;">
            <div style="background: #222; padding: 20px; border: 1px solid #333; max-width: 400px;">
                <h4 style="color: var(--gold); margin-bottom: 10px;">企業のご担当者様</h4>
                <p style="margin-bottom: 15px; font-size: 0.9rem;">人材・営業支援のご相談はお気軽にお問い合わせください。</p>
                <a href="#contact" class="btn" style="padding: 10px 20px; font-size: 0.9rem;">企業向けお問い合わせ</a>
            </div>
            <div style="background: #222; padding: 20px; border: 1px solid #333; max-width: 400px;">
                <h4 style="color: var(--gold); margin-bottom: 10px;">お仕事をお探しの方</h4>
                <p style="margin-bottom: 15px; font-size: 0.9rem;">キャリアのご相談や求人紹介も受け付けています。</p>
                <a href="#contact" class="btn" style="padding: 10px 20px; font-size: 0.9rem;">求職者向けお問い合わせ</a>
            </div>
        </div>
    </div>
</section>

<!-- 会社概要 (Company) -->
<section id="company" class="section">
    <div class="container">
        <h2 class="section-title">会社概要</h2>
        <div class="company-info">
            <dl class="company-row">
                <dt>会社名</dt>
                <dd>
                    <?php echo COMPANY_NAME; ?><br>
                    <span style="font-size: 0.8rem; color: #888;"><?php echo SITE_NAME_EN; ?></span>
                </dd>
            </dl>
            <dl class="company-row">
                <dt>設立</dt>
                <dd><?php echo REGISTRATION_DATE; ?></dd>
            </dl>
            <dl class="company-row">
                <dt>代表者</dt>
                <dd>代表取締役社長 <?php echo CEO_NAME; ?></dd>
            </dl>
            <dl class="company-row">
                <dt>住所</dt>
                <dd>
                    〒<?php echo COMPANY_POSTAL_CODE; ?><br>
                    <?php echo COMPANY_ADDRESS; ?><br>
                    <span style="font-size: 0.8rem; color: #888; display:block; margin-top:5px;"><?php echo COMPANY_ADDRESS_EN; ?></span>
                </dd>
            </dl>
            <dl class="company-row">
                <dt>連絡先</dt>
                <dd>
                    Email: <?php echo COMPANY_EMAIL; ?><br>
                    Tel: <?php echo COMPANY_PHONE; ?>
                </dd>
            </dl>
            <dl class="company-row">
                <dt>事業内容</dt>
                <dd>
                    人材派遣事業<br>
                    人材紹介事業<br>
                    営業支援事業<br>
                    業務支援・コンサルティング<br>
                    <small style="color: #888;">※許可番号：取得準備中</small>
                </dd>
            </dl>
        </div>
    </div>
</section>

<!-- お問い合わせ (Contact) -->
<section id="contact" class="section contact">
    <div class="container">
        <h2 class="section-title">お問い合わせ</h2>
        <p style="text-align: center; margin-bottom: 3rem;">
            お仕事のご依頼、ご相談などお気軽にお問い合わせください。<br>
            <span class="required">必須</span>の項目は必ずご入力ください。
        </p>
        
        <form action="form_handler.php" method="post" style="max-width: 700px; margin: 0 auto;">
            <!-- CSRF Token -->
            <input type="hidden" name="token" value="<?php echo $token; ?>">
            
            <!-- Honeypot (Spam Trap) -->
            <input type="text" name="website" style="display:none;" autocomplete="off">
            
            <div class="form-group">
                <label for="type" class="required">お問い合わせ種別</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="">選択してください</option>
                    <option value="企業様からのお問い合わせ">企業様からのお問い合わせ</option>
                    <option value="求職者様からのお問い合わせ">求職者様からのお問い合わせ</option>
                    <option value="その他">その他</option>
                </select>
            </div>

            <div class="form-group">
                <label for="name" class="required">お名前</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="例：山田 太郎" required>
            </div>

            <div class="form-group">
                <label for="company">会社名</label>
                <input type="text" name="company" id="company" class="form-control" placeholder="例：GOLD VISION 株式会社">
            </div>

            <div class="form-group">
                <label for="phone">電話番号</label>
                <input type="tel" name="phone" id="phone" class="form-control" placeholder="例：090-1234-5678">
            </div>

            <div class="form-group">
                <label for="email" class="required">メールアドレス</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="例：info@example.com" required>
            </div>

            <div class="form-group">
                <label for="message" class="required">お問い合わせ内容</label>
                <textarea name="message" id="message" class="form-control" placeholder="ご相談内容を詳しくご記入ください。" required></textarea>
            </div>

            <div class="form-submit">
                <button type="submit" class="btn">送信する</button>
            </div>
        </form>
    </div>
</section>

<!-- フッター -->
<footer>
    <div class="container">
        <div class="footer-info">
            <p style="font-size: 1.2rem; margin-bottom: 10px;"><strong><?php echo SITE_NAME; ?></strong></p>
            <p style="font-size: 0.9rem; margin-bottom: 5px;">〒<?php echo COMPANY_POSTAL_CODE; ?> <?php echo COMPANY_ADDRESS; ?></p>
            <p style="font-size: 0.9rem;">Email: <?php echo COMPANY_EMAIL; ?></p>
        </div>
        <ul style="list-style: none; display: flex; justify-content: center; gap: 20px; margin-bottom: 20px; font-size: 0.8rem; margin-top: 20px;">
            <li><a href="privacy.php">プライバシーポリシー</a></li>
        </ul>
        <p class="copyright">&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME_EN; ?> All Rights Reserved.</p>
    </div>
</footer>

<script src="assets/js/main.js"></script>
<script src="assets/js/hero-effect.js"></script>
</body>
</html>
