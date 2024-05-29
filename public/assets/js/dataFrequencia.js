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
function parseDateInputValue(dateInputValue) {
    const parts = dateInputValue.split('-');
    const year = parseInt(parts[0]);
    const month = parseInt(parts[1]) - 1; // Months are zero-based
    const day = parseInt(parts[2]);
    return new Date(year, month, day);
}
function setDataTable(objData) {
    const filtroRadio = document.querySelector('input[name="filtroRadio"]:checked').value;
    const MesColumn = document.querySelector('tbody');


    const alunos = objData.alunos;
    const frequencias = objData.frequencias;


    const dateInputValue = document.getElementById('dateInput').value;
    const selectedDate = parseDateInputValue(dateInputValue);

    const dia = selectedDate.getDate();

    const countMes = objData.mes;

    // console.log('Quantidade de alunos:', Object.keys(alunos).length);
    // console.log('Quantidade de dias no mês:', countMes);
    // console.log('Quantidade dia Selecionado:', dia);

    MesColumn.innerHTML = ''

    switch (filtroRadio) {
        case 'd':
            MesColumn.innerHTML =
                `<tr class="tb-frequencia tr-titulo">
                    <td>ID</td>
                    <td>Aluno</td>
                    <td>Dia ${dia}</td>
                </tr>`;

            for (const idAluno in alunos) {
                const aluno = alunos[idAluno];
                let presenca = '( N/A )';
                for (const idFrequencia in frequencias) {
                    const frequencia = frequencias[idFrequencia];
                    if (frequencia.ID_ALUNO === aluno.ID_ALUNO && new Date(frequencia.data_aula).getDate() === dia) {
                        presenca = frequencia.presenca;
                        break;
                    }
                }
                MesColumn.innerHTML +=
                    `<tr>
                    <td>${aluno.ID_ALUNO}</td>
                    <td>${aluno.nome}</td>
                    <td>
                        <select name="presenca[${aluno.ID_ALUNO}][${dia}]" class="textbox">
                            <option value="" ${presenca === '' ? 'selected' : ''}>N/A</option>
                            <option value="P" ${presenca === 'P' ? 'selected' : ''}>Presente</option>
                            <option value="F" ${presenca === 'F' ? 'selected' : ''}>Falta</option>
                        </select>
                    </td>
                </tr>`;
            }
            break;
        case 'm':
            let rowContent =
                `<tr class="tb-frequencia tr-titulo">
                <td> ID </td>
                <td> Aluno </td>`;
            for (let countDia = 1; countDia <= countMes; countDia++) {
                rowContent += `<td> ${countDia} </td>`;
            }
            rowContent += '</tr>';
            MesColumn.innerHTML += rowContent;

            for (const idAluno in alunos) {
                const aluno = alunos[idAluno];
                let rowContent =
                    `<tr>
                    <td>${aluno.ID_ALUNO}</td>
                    <td>${aluno.nome}</td>`;
                for (let countDia = 1; countDia <= countMes; countDia++) {
                    let presenca = '( N/A )';
                    for (const idFrequencia in frequencias) {
                        const frequencia = frequencias[idFrequencia];
                        if (frequencia.ID_ALUNO === aluno.ID_ALUNO && new Date(frequencia.data_aula).getDate() === countDia) {
                            presenca = frequencia.presenca;
                            break;
                        }
                    }
                    rowContent +=
                        `<td>
                        <select name="presenca[${aluno.ID_ALUNO}][${countDia}]" class="textbox">
                            <option value="" ${presenca === '' ? 'selected' : ''}>N/A</option>
                            <option value="P" ${presenca === 'P' ? 'selected' : ''}>Presente</option>
                            <option value="F" ${presenca === 'F' ? 'selected' : ''}>Falta</option>
                        </select>
                    </td>`;
                }
                rowContent += '</tr>';
                MesColumn.innerHTML += rowContent;
            }
            break;      // console.log(countAluno);


        // Submete o formulário
        // document.getElementById('frequenciaForm').submit();
    }
}
