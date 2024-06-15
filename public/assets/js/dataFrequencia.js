function setTodayAsDefaultDate() {
    const dateInput = document.getElementById('dateInput');
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0'); // Os meses começam em 0!
    const dd = String(today.getDate()).padStart(2, '0');
    dateInput.value = `${yyyy}-${mm}-${dd}`;
}



function parseDateInputValue(dateInputValue) {
    const parts = dateInputValue.split('-');
    const year = parseInt(parts[0]);
    const month = parseInt(parts[1]) - 1; // Os meses são baseados em zero
    const day = parseInt(parts[2]);
    return new Date(Date.UTC(year, month, day)); // Use UTC para evitar problemas de fuso horário
}

function setDataTable(objData) {
    const filtroRadio = document.querySelector('input[name="filtroRadio"]:checked').value;
    const MesColumn = document.querySelector('tbody');

    // Define a data padrão se a página for carregada com "Dia" selecionado
    if (document.getElementById('filtroRadioHoje').checked) {
        setTodayAsDefaultDate();
    }

    const alunos = objData.alunos;
    const frequencias = objData.frequencias;

    const dateInputValue = document.getElementById('dateInput').value;
    const selectedDate = parseDateInputValue(dateInputValue);

    const countMes = objData.mes;

    MesColumn.innerHTML = '';

    switch (filtroRadio) {
        case 'd':
            const dia = selectedDate.getUTCDate(); // Use getUTCDate para consistência
            console.log('Data Selecionada:', selectedDate); // Log da data selecionada

            MesColumn.innerHTML =
                `<tr class="row-column-titles row-columns tr-consultar-id">
                    <td class="td-ID">
                        ID
                        <div class="resize-handle"></div>
                    </td>
                    <td>
                    Aluno
                        <div class="resize-handle"></div>
                    </td>
                    <td>
                    Dia ${dia}
                    </td>
                </tr>`;

            for (const idAluno in alunos) {
                const aluno = alunos[idAluno];
                let presenca = '( N/A )';
                for (const idFrequencia in frequencias) {
                    const frequencia = frequencias[idFrequencia];
                    const freqDate = new Date(frequencia.data_aula);
                    const freqDia = freqDate.getUTCDate(); // Use getUTCDate para consistência
                    if (frequencia.ID_ALUNO === aluno.ID_ALUNO && freqDia === dia) {
                        presenca = frequencia.presenca;
                        break;
                    }
                }
                MesColumn.innerHTML +=
                    `<tr>
                    <td>${aluno.ID_ALUNO}</td>
                    <td>${aluno.nome}</td>
                    <td>
                        <select name="presenca[${aluno.ID_ALUNO}][${dia}]" class="textbox" ${(presenca === 'P' ? 'disabled' : (presenca === 'F') ? 'disabled' : '')}>
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
                `<tr class="row-column-titles row-columns tr-consultar-id">
                <td class="td-ID">
                    ID
                    <div class="resize-handle"></div>
                </td>
                <td>
                    Aluno
                    <div class="resize-handle"></div>
                </td>`;
            for (let countDia = 1; countDia <= countMes; countDia++) {
                rowContent += `<td>${countDia}</td>`;
            }
            rowContent += '</tr>';
            MesColumn.innerHTML += rowContent;
            console.clear();
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
                        const freqDate = new Date(frequencia.data_aula);
                        const dia = freqDate.getUTCDate(); // Use getUTCDate para consistência
                        if (frequencia.ID_ALUNO === aluno.ID_ALUNO && dia === countDia) {
                            presenca = frequencia.presenca;
                        }
                    }
                    rowContent +=
                        `<td>
                        <select name="presenca[${aluno.ID_ALUNO}][${countDia}]" class="textbox" ${(presenca === 'P' ? 'disabled' : (presenca === 'F') ? 'disabled' : '')}>
                            <option value="" ${presenca === '' ? 'selected' : ''}>N/A</option>
                            <option value="P" ${presenca === 'P' ? 'selected' : ''}>Presente</option>
                            <option value="F" ${presenca === 'F' ? 'selected' : ''}>Falta</option>
                        </select>
                    </td>`;
                }
                rowContent += '</tr>';
                MesColumn.innerHTML += rowContent;
            }
            break;
    }
}
