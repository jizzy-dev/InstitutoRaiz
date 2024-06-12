document.addEventListener('DOMContentLoaded', function () {
    const table = document.querySelector('.tb-consulta');
    if (!table) return;

    const ths = table.querySelectorAll('.row-column-titles td:not(.td-button)');
    const tbodyRows = table.querySelectorAll('tbody tr');
    const minColumnWidth = 300; // Largura mínima em pixels
    const maxColumnWidth = 700; // Largura máxima em pixels

    ths.forEach((th, index) => {
        const resizer = th.querySelector('.resize-handle');
        if (!resizer) return;

        let startX, startMinWidth;

        const initResize = (e) => {
            startX = e.clientX;
            startMinWidth = parseInt(window.getComputedStyle(th).minWidth, 10);
            document.addEventListener('mousemove', doDrag);
            document.addEventListener('mouseup', stopDrag);
        };

        const doDrag = (e) => {
            const newMinWidth = Math.max(Math.min(startMinWidth + e.clientX - startX, maxColumnWidth), minColumnWidth) + 'px';
            th.style.minWidth = newMinWidth;

            tbodyRows.forEach(tr => {
                const td = tr.children[index];
                if (td) {
                    td.style.minWidth = newMinWidth;
                }
            });
        };

        const stopDrag = () => {
            document.removeEventListener('mousemove', doDrag);
            document.removeEventListener('mouseup', stopDrag);
        };

        resizer.addEventListener('mousedown', initResize);
    });
});
