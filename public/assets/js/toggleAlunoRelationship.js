function toggleRelationship() {
    var rows = document.querySelectorAll('.tr-toggle');
    rows.forEach(function(row) {
        if (row.style.display === 'none' || row.style.display === '') {
            row.style.display = 'table-row';
        } else {
            row.style.display = 'none';
        }
    });
}
