document.addEventListener("DOMContentLoaded", function() {
    function alignTextContent() {
        var headerContent = document.querySelector('.header-content');
        var headerContentRect = headerContent.getBoundingClientRect();
        var sc1LeftContent = document.querySelector('.sc1-content-left');
        sc1LeftContent.style.marginLeft = headerContentRect.left + 'px';
    }

    alignTextContent();

    window.addEventListener('resize', alignTextContent);

    // Observador de mutação para monitorar mudanças na largura do .header-content
    var headerContent = document.querySelector('.header-content');
    var observer = new MutationObserver(alignTextContent);

    observer.observe(headerContent, {
        attributes: true,
        attributeFilter: ['style', 'class']
    });
});