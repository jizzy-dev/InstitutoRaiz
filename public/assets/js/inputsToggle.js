function toggleRelationship() {
    var rows = document.querySelectorAll('.tr-toggle');
    rows.forEach(function (row) {
        if (row.style.display === 'none' || row.style.display === '') {
            row.style.display = 'table-row';
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

function setTodayAsDefaultDate() {
    const dateInput = document.getElementById('dateInput');
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0'); // Months start at 0!
    const dd = String(today.getDate()).padStart(2, '0');
    dateInput.value = `${yyyy}-${mm}-${dd}`;
}

// Set the default date if the page is loaded with "Dia" selected
if (document.getElementById('filtroRadioHoje').checked) {
    setTodayAsDefaultDate();
}

function setDataTable(objData) {
    const filtroRadio = document.querySelector('input[name="filtroRadio"]:checked').value;
    const headMesColumn = document.querySelector('#twig-mes-thead-column-td');
    const bodyMesColumn = document.querySelector('tbody');

    // const objData = document.querySelector('table').getAttribute('data-frequencia')
    const aluno = objData.alunos;
    const countAluno = Object.keys(aluno).length;

    switch (filtroRadio) {
        case 'd': 
        bodyMesColumn.innerHTML = ''
            for (let i = 0; i < countAluno; i++) {
                const a = aluno[i];

                bodyMesColumn.innerHTML +=
                    '<td>' + a.ID_ALUNO + '</td>'
                    '<td>' + a.nome + '</td>'

                console.log(a.nome);
            }
            break;
        case 'm':
            // mes = mesQtdDia;
            break;
    }


    // console.log(countAluno);


    // Submete o formulário
    // document.getElementById('frequenciaForm').submit();
}

