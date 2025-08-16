/**
 * YandexPRO Blog JavaScript
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Mobile menu toggle
    const menuToggle = document.querySelector('.menu-toggle');
    const navMenu = document.querySelector('.nav-menu');
    
    if (menuToggle && navMenu) {
        menuToggle.addEventListener('click', function() {
            this.classList.toggle('active');
            navMenu.classList.toggle('active');
            
            // Update ARIA attributes
            const expanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !expanded);
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!menuToggle.contains(e.target) && !navMenu.contains(e.target)) {
                menuToggle.classList.remove('active');
                navMenu.classList.remove('active');
                menuToggle.setAttribute('aria-expanded', 'false');
            }
        });
        
        // Close menu on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                menuToggle.classList.remove('active');
                navMenu.classList.remove('active');
                menuToggle.setAttribute('aria-expanded', 'false');
            }
        });
    }
    
    // Progress bar for single posts
    const progressBar = document.getElementById('progressBar');
    if (progressBar) {
        function updateProgressBar() {
            const article = document.querySelector('.content-text');
            if (!article) return;
            
            const scrollTop = window.pageYOffset;
            const docHeight = article.offsetHeight;
            const winHeight = window.innerHeight;
            const scrollPercent = scrollTop / (docHeight - winHeight);
            
            progressBar.style.transform = `scaleX(${Math.min(scrollPercent, 1)})`;
        }
        
        window.addEventListener('scroll', updateProgressBar);
        updateProgressBar();
    }
    
    // Table of contents scroll spy
    const tocLinks = document.querySelectorAll('.toc-link');
    if (tocLinks.length > 0) {
        function updateTOC() {
            const sections = document.querySelectorAll('[id^="section"]');
            let currentSection = '';
            
            sections.forEach(section => {
                const rect = section.getBoundingClientRect();
                if (rect.top <= 100) {
                    currentSection = section.id;
                }
            });
            
            tocLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${currentSection}`) {
                    link.classList.add('active');
                }
            });
        }
        
        window.addEventListener('scroll', updateTOC);
        updateTOC();
        
        // Smooth scrolling for TOC links
        tocLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);
                
                if (targetElement) {
                    const offsetTop = targetElement.offsetTop - 100;
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }
    
    // Header background on scroll
    const header = document.querySelector('.site-header');
    if (header) {
        function updateHeaderBackground() {
            if (window.scrollY > 100) {
                header.style.background = 'rgba(255, 255, 255, 0.98)';
                header.style.borderBottom = '1px solid rgba(17, 24, 39, 0.15)';
            } else {
                header.style.background = 'rgba(255, 255, 255, 0.95)';
                header.style.borderBottom = '1px solid rgba(17, 24, 39, 0.08)';
            }
        }
        
        window.addEventListener('scroll', updateHeaderBackground);
    }
    
    // Search functionality
    const searchBox = document.querySelector('.search-field, input[type="search"]');
    if (searchBox) {
        let searchTimeout;
        
        searchBox.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            
            searchTimeout = setTimeout(() => {
                const query = e.target.value.toLowerCase();
                if (query.length > 2) {
                    // Implement live search here
                    console.log('Searching for:', query);
                }
            }, 300);
        });
    }
    
    // Category filtering
    const categoryTags = document.querySelectorAll('.category-tag');
    categoryTags.forEach(tag => {
        tag.addEventListener('click', function(e) {
            if (this.getAttribute('href') === '#') {
                e.preventDefault();
            }
            
            // Remove active class from all tags
            categoryTags.forEach(t => t.classList.remove('active'));
            
            // Add active class to clicked tag
            this.classList.add('active');
        });
    });
    
    // Newsletter form
    const newsletterForm = document.querySelector('.newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = this.querySelector('input[type="email"]').value;
            const nonce = this.querySelector('input[name="newsletter_nonce"]');
            
            if (email && nonce) {
                // Send AJAX request
                fetch(yandexpro_ajax.ajax_url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        'action': 'newsletter_subscribe',
                        'email': email,
                        'nonce': nonce.value
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Спасибо за подписку! Проверьте почту для подтверждения.');
                        this.querySelector('input[type="email"]').value = '';
                    } else {
                        alert('Произошла ошибка. Попробуйте еще раз.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Произошла ошибка. Попробуйте еще раз.');
                });
            }
        });
    }
    
    // Lazy loading for images
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });
        
        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }
    
    // Scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const scrollObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationPlayState = 'running';
            }
        });
    }, observerOptions);
    
    // Observe elements with animation
    document.querySelectorAll('.animate-on-scroll').forEach((element, index) => {
        element.style.animationDelay = `${index * 0.1}s`;
        element.style.animationPlayState = 'paused';
        scrollObserver.observe(element);
    });
    
    // Copy to clipboard functionality
    function copyToClipboard(text) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(text).then(() => {
                showNotification('Ссылка скопирована!');
            });
        } else {
            // Fallback for older browsers
            const textArea = document.createElement('textarea');
            textArea.value = text;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            showNotification('Ссылка скопирована!');
        }
    }
    
    // Show notification
    function showNotification(message) {
        const notification = document.createElement('div');
        notification.className = 'notification';
        notification.textContent = message;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--color-primary);
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            z-index: 9999;
            animation: slideIn 0.3s ease;
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
    
    // View counter (if implemented)
    if (document.body.classList.contains('single-post')) {
        // Increment view count after 30 seconds
        setTimeout(() => {
            const postId = document.body.getAttribute('data-post-id');
            if (postId) {
                fetch(yandexpro_ajax.ajax_url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        'action': 'increment_post_views',
                        'post_id': postId,
                        'nonce': yandexpro_ajax.nonce
                    })
                });
            }
        }, 30000);
    }
});

// Global functions for sharing and actions
window.yandexpro_share_telegram = function() {
    const url = encodeURIComponent(window.location.href);
    const title = encodeURIComponent(document.title);
    window.open(`https://t.me/share/url?url=${url}&text=${title}`, '_blank');
};

window.yandexpro_share_vk = function() {
    const url = encodeURIComponent(window.location.href);
    const title = encodeURIComponent(document.title);
    window.open(`https://vk.com/share.php?url=${url}&title=${title}`, '_blank');
};

window.yandexpro_copy_link = function() {
    const copyToClipboard = (text) => {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Ссылка скопирована!');
            });
        } else {
            const textArea = document.createElement('textarea');
            textArea.value = text;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            alert('Ссылка скопирована!');
        }
    };
    
    copyToClipboard(window.location.href);
};

window.yandexpro_bookmark = function() {
    const btn = event.target.closest('.share-btn');
    btn.style.background = 'var(--color-primary)';
    btn.style.color = 'white';
    setTimeout(() => {
        btn.style.background = '';
        btn.style.color = '';
    }, 1000);
};

window.yandexpro_save_post = function(postId) {
    const btn = event.target;
    btn.innerHTML = '✅ Сохранено';
    btn.classList.remove('primary');
    setTimeout(() => {
        btn.innerHTML = '💾 Сохранить статью';
        btn.classList.add('primary');
    }, 2000);
};

window.yandexpro_share_post = function() {
    if (navigator.share) {
        navigator.share({
            title: document.title,
            url: window.location.href
        }).catch(console.error);
    } else {
        yandexpro_copy_link();
		} else {
       yandexpro_copy_link();
   }
};

// Reading time calculation
window.yandexpro_reading_time = function() {
   const content = document.querySelector('.content-text');
   if (!content) return 0;
   
   const text = content.textContent;
   const wordsPerMinute = 200; // Average reading speed
   const words = text.trim().split(/\s+/).length;
   const readingTime = Math.ceil(words / wordsPerMinute);
   
   return readingTime;
};