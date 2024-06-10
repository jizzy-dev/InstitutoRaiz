function toggleRelationship() {
    var rows = document.querySelectorAll('.tr-toggle');
    rows.forEach(function (row) {
        if (row.style.display === 'none' || row.style.display === '') {
            row.style.display = 'flex';
        } else {
            row.style.display = 'none';
        }
    });
}
function toggleDateInput() {
    const dateInput = document.getElementById('dateInput');
    const filtroRadioHoje = document.getElementById('filtroRadioHoje').checked;
    if (filtroRadioHoje) {
        dateInput.style.display = 'inline';
        dateInput.required = true;
        setTodayAsDefaultDate();
    } else {
        dateInput.style.display = 'none';
        dateInput.required = false;
    }

}
function togglePassword() {
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('senha');

    const type = password.type === 'password' ? 'text' : 'password';

    password.type = type;

    togglePassword.classList.toggle("senha-icon-open");
    togglePassword.classList.toggle("senha-icon-close");

}
function toggleEyeSlash() {
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('senha').value;
    if (password == '') {
        togglePassword.classList.add("display-none");
    } else {
        togglePassword.classList.remove("display-none");

    }
}
