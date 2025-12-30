/**
 * Gold Particles Animation - Las Vegas Luxury Edition
 * より豪華に、より煌びやかに。
 */

document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('hero-canvas');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    let width, height;
    let particles = [];

    // Configuration for High-End Luxury Feel
    const config = {
        particleCount: 120,     // 密度を倍増
        baseSpeed: 0.8,         // 速度を上げて「都市の鼓動」を表現
        colors: [
            'rgba(191, 149, 63, ',  // Dark Gold
            'rgba(252, 246, 186, ', // Light Gold (Pale)
            'rgba(179, 135, 40, ',  // Gold Metallic
            'rgba(255, 215, 0, ',   // Neon Gold
            'rgba(255, 255, 255, '  // Pure Sparkle
        ]
    };

    function resize() {
        // 親要素ではなくウィンドウ全体をカバーして没入感を高める
        width = canvas.width = window.innerWidth;
        height = canvas.height = window.innerHeight;
    }

    class Particle {
        constructor() {
            this.reset();
        }

        reset() {
            this.x = Math.random() * width;
            this.y = Math.random() * height;
            this.size = Math.random() * 4 + 0.5; // 大小のメリハリをつける
            
            // 上昇するような動き（成功・運気上昇のイメージ）
            this.speedX = (Math.random() - 0.5) * config.baseSpeed;
            this.speedY = (Math.random() - 0.8) * config.baseSpeed; 
            
            this.life = Math.random() * 0.6 + 0.4; // 最初からある程度明るく
            this.decay = Math.random() * 0.01 + 0.005; // 点滅を早くして「煌めき」を表現
            this.colorPrefix = config.colors[Math.floor(Math.random() * config.colors.length)];
            this.direction = Math.random() > 0.5 ? 1 : -1;
        }

        update() {
            this.x += this.speedX;
            this.y += this.speedY;

            // 画面外処理（ループ）
            if (this.x < 0) this.x = width;
            if (this.x > width) this.x = 0;
            if (this.y < 0) this.y = height;
            if (this.y > height) this.y = height; // 下から出てくる感じも維持

            // Sparkle Effect (Flash)
            this.life += this.decay * this.direction;
            if (this.life >= 1) {
                this.direction = -1;
                this.life = 1;
            } else if (this.life <= 0.1) {
                this.direction = 1;
                this.life = 0.1;
                // 位置をリセットせず、その場でまた光らせる
            }
        }

        draw() {
            ctx.beginPath();
            // Glow effect
            const gradient = ctx.createRadialGradient(this.x, this.y, 0, this.x, this.y, this.size * 4); // Glow range wider
            gradient.addColorStop(0, this.colorPrefix + this.life + ')'); // Core
            gradient.addColorStop(0.4, this.colorPrefix + (this.life * 0.5) + ')'); // Mid glow
            gradient.addColorStop(1, 'rgba(0,0,0,0)'); // Fade out

            ctx.fillStyle = gradient;
            ctx.arc(this.x, this.y, this.size * 4, 0, Math.PI * 2);
            ctx.fill();
        }
    }

    function init() {
        resize();
        particles = [];
        for (let i = 0; i < config.particleCount; i++) {
            particles.push(new Particle());
        }
        animate();
    }

    function animate() {
        ctx.clearRect(0, 0, width, height);
        
        // Add subtle trail effect for motion blur (Luxury speed feel)
        // ctx.fillStyle = 'rgba(5, 5, 5, 0.2)';
        // ctx.fillRect(0, 0, width, height);

        // Global Composite Operation for neon glow blending
        ctx.globalCompositeOperation = 'lighter';

        particles.forEach(p => {
            p.update();
            p.draw();
        });

        requestAnimationFrame(animate);
    }

    window.addEventListener('resize', resize);
    init();
});
