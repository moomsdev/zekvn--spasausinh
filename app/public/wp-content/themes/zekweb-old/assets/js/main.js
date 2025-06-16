// Product content read more functionality
document.addEventListener('DOMContentLoaded', function() {
    const readMoreBtn = document.querySelector('.read-more-btn');
    if (readMoreBtn) {
        readMoreBtn.addEventListener('click', function() {
            const shortContent = document.querySelector('.product-content__short');
            const fullContent = document.querySelector('.product-content__full');
            
            if (shortContent.style.display !== 'none') {
                // Show full content
                shortContent.style.display = 'none';
                fullContent.style.display = 'block';
                this.textContent = 'Rút gọn';
                this.classList.add('expanded');
            } else {
                // Show short content
                shortContent.style.display = 'block';
                fullContent.style.display = 'none';
                this.textContent = 'Đọc thêm';
                this.classList.remove('expanded');
            }
        });
    }
}); 