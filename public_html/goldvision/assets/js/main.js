document.addEventListener('DOMContentLoaded', function() {
    // スムーズスクロール
    const anchors = document.querySelectorAll('a[href^="#"]');
    
    anchors.forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                const headerHeight = document.querySelector('header').offsetHeight;
                const targetPosition = targetElement.getBoundingClientRect().top + window.scrollY - headerHeight;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
                
                // スマホメニューが開いていたら閉じる
                const navMenu = document.querySelector('.nav-menu');
                if (navMenu.classList.contains('active')) {
                    navMenu.classList.remove('active');
                }
            }
        });
    });

    // ハンバーガーメニュー
    const menuToggle = document.querySelector('.menu-toggle');
    const navMenu = document.querySelector('.nav-menu');
    
    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
        });
    }

    // フォームバリデーション（簡易）
    const contactForm = document.querySelector('form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            const requiredInputs = contactForm.querySelectorAll('[required]');
            let hasError = false;

            requiredInputs.forEach(input => {
                if (!input.value.trim()) {
                    hasError = true;
                    input.style.borderColor = 'red';
                } else {
                    input.style.borderColor = '#444';
                }
            });

            if (hasError) {
                e.preventDefault();
                alert('必須項目を入力してください。');
            }
        });
    }
});
