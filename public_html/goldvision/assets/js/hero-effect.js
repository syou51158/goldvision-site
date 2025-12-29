/**
 * Gold Particles Animation
 * 高級感のあるゴールドの光の粒子が浮遊するエフェクト
 */

document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('hero-canvas');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    let width, height;
    let particles = [];

    // 設定
    const config = {
        particleCount: 60,      // 粒子の数
        baseSpeed: 0.2,         // 基本速度
        colors: [
            'rgba(197, 160, 89, ',  // ゴールド
            'rgba(230, 200, 136, ', // 明るいゴールド
            'rgba(255, 255, 255, '  // 白（輝き用）
        ]
    };

    // リサイズ処理
    function resize() {
        const parent = canvas.parentElement;
        if (parent) {
            width = canvas.width = parent.offsetWidth;
            height = canvas.height = parent.offsetHeight;
        } else {
            width = canvas.width = window.innerWidth;
            height = canvas.height = window.innerHeight;
        }
    }

    // パーティクルクラス
    class Particle {
        constructor() {
            this.reset();
        }

        reset() {
            this.x = Math.random() * width;
            this.y = Math.random() * height;
            this.size = Math.random() * 3 + 1; // 1px 〜 4px
            this.speedX = (Math.random() - 0.5) * config.baseSpeed;
            this.speedY = (Math.random() - 0.5) * config.baseSpeed;
            this.life = Math.random() * 0.5 + 0.5; // 透明度
            this.decay = Math.random() * 0.005 + 0.002; // 点滅速度
            this.colorPrefix = config.colors[Math.floor(Math.random() * config.colors.length)];
            this.direction = Math.random() > 0.5 ? 1 : -1; // 点滅の方向
        }

        update() {
            // 移動
            this.x += this.speedX;
            this.y += this.speedY;

            // 画面外に出たら反対側へ
            if (this.x < 0) this.x = width;
            if (this.x > width) this.x = 0;
            if (this.y < 0) this.y = height;
            if (this.y > height) this.y = 0;

            // 点滅（明滅）アニメーション
            this.life += this.decay * this.direction;
            if (this.life >= 1 || this.life <= 0.2) {
                this.direction *= -1;
            }
        }

        draw() {
            // 円形の光を描画
            ctx.beginPath();
            // グラデーションで光っている感じを出す
            const gradient = ctx.createRadialGradient(this.x, this.y, 0, this.x, this.y, this.size * 2);
            gradient.addColorStop(0, this.colorPrefix + this.life + ')');
            gradient.addColorStop(1, this.colorPrefix + '0)'); // 外側は透明
            
            ctx.fillStyle = gradient;
            ctx.arc(this.x, this.y, this.size * 2, 0, Math.PI * 2);
            ctx.fill();
        }
    }

    // 初期化
    function init() {
        resize();
        particles = [];
        for (let i = 0; i < config.particleCount; i++) {
            particles.push(new Particle());
        }
        animate();
    }

    // アニメーションループ
    function animate() {
        ctx.clearRect(0, 0, width, height);
        
        // 背景を完全な黒ではなく、少し残像を残す場合（今回はクリアでOK）
        // ctx.fillStyle = 'rgba(0, 0, 0, 0.1)';
        // ctx.fillRect(0, 0, width, height);

        // パーティクル同士を線で結ぶ（星座のような演出）- オプション
        // 今回は「ラスベガスの光」イメージなので、線は結ばず「ボケ」を重視する

        particles.forEach(p => {
            p.update();
            p.draw();
        });

        requestAnimationFrame(animate);
    }

    window.addEventListener('resize', resize);
    init();
});
