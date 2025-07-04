import './bootstrap';

// modal cant be scrolled with this code
window.toggleBodyScroll = function(showModal) {
    if (showModal) {
        const scrollBarWidth = window.innerWidth - document.documentElement.clientWidth;
        document.body.style.paddingRight = scrollBarWidth + 'px';
        document.body.classList.add('overflow-hidden');
    } else {
        document.body.style.paddingRight = '';
        document.body.classList.remove('overflow-hidden');
    }
}
