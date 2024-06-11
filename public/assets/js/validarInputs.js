function adicionarValidacao() {
    // Seleciona todos os elementos com a classe .textbox
    const textBoxes = document.querySelectorAll('.textbox');
    const senhaInputs = document.querySelectorAll('.inputSenha');
    const confirmarSenhaInputs = document.querySelectorAll('.inputConfirmarSenha');

    // Para cada caixa de texto, adiciona um span de erro após ela
    textBoxes.forEach(textBox => {
        // Cria um novo elemento span para o erro
        const errorSpan = document.createElement('span');
        
        // Adiciona a classe 'error-span' ao span
        errorSpan.classList.add('error-span');
        
        // Insere o span após a caixa de texto
        textBox.parentNode.insertBefore(errorSpan, textBox.nextSibling);
        
        // Adiciona um ouvinte de evento de input a cada caixa de texto
        textBox.addEventListener('input', () => {
            // Encontra o elemento de erro correspondente
            const errorSpan = textBox.nextElementSibling;
            
            // Verifica se a caixa de texto está vazia
            if (textBox.value.trim() === '') {
                // Exibe a mensagem de erro de campo obrigatório
                errorSpan.innerHTML = 'Preencher os Campos Obrigatórios';
                // Adiciona uma sombra vermelha
                textBox.style.boxShadow = '#f83340 1px 1px 0px 2px';
            } else if (!textBox.validity.valid) {
                // Exibe a mensagem de erro de campo inválido
                errorSpan.innerHTML = 'Campo Inválido';
                // Adiciona uma sombra vermelha
                textBox.style.boxShadow = '#f83340 1px 1px 0px 2px';
            } else {
                // Limpa a mensagem de erro e a sombra se a caixa de texto for válida
                errorSpan.innerHTML = '';
                textBox.style.boxShadow = '';
            }
        });
    });

    // Validação específica para senha
    senhaInputs.forEach(senhaInput => {
        senhaInput.addEventListener('input', () => {
            const senha = senhaInput.value;
            const senhaValida = validarSenha(senha);
            const errorSpan = senhaInput.nextElementSibling;

            if (!senhaValida) {
                errorSpan.innerHTML = 'A senha deve ter no mínimo 8 caracteres, '
                    + 'pelo menos uma letra maiúscula, uma letra minúscula, '
                    + 'um número e um caractere especial.';
                senhaInput.style.boxShadow = '#f83340 1px 1px 0px 2px';
            } else {
                errorSpan.innerHTML = '';
                senhaInput.style.boxShadow = '';
            }

            // Valida o campo de confirmação de senha
            confirmarSenhaInputs.forEach(confirmarSenhaInput => {
                const confirmarSenhaSpan = confirmarSenhaInput.nextElementSibling;
                if (confirmarSenhaInput.value !== senhaInput.value) {
                    confirmarSenhaSpan.innerHTML = 'As senhas não coincidem';
                    confirmarSenhaInput.style.boxShadow = '#f83340 1px 1px 0px 2px';
                } else {
                    confirmarSenhaSpan.innerHTML = '';
                    confirmarSenhaInput.style.boxShadow = '';
                }
            });
        });
    });

    // Validação específica para confirmar senha
    confirmarSenhaInputs.forEach(confirmarSenhaInput => {
        confirmarSenhaInput.addEventListener('input', () => {
            const senha = document.querySelector('.inputSenha').value;
            const errorSpan = confirmarSenhaInput.nextElementSibling;

            if (confirmarSenhaInput.value !== senha) {
                errorSpan.innerHTML = 'As senhas não coincidem';
                confirmarSenhaInput.style.boxShadow = '#f83340 1px 1px 0px 2px';
            } else {
                errorSpan.innerHTML = '';
                confirmarSenhaInput.style.boxShadow = '';
            }
        });
    });

    // Adiciona um ouvinte de evento de submit ao formulário
    const form = document.querySelector('form');
    form.addEventListener('submit', (event) => {
        // Evita o envio padrão do formulário
        event.preventDefault();

        // Para cada caixa de texto, executa a mesma lógica de validação do evento de entrada
        textBoxes.forEach(textBox => {
            // Encontra o elemento de erro correspondente
            const errorSpan = textBox.nextElementSibling;
            if (textBox.value.trim() === '') {
                errorSpan.innerHTML = 'Preencher os Campos Obrigatórios';
                textBox.style.boxShadow = '#f83340 1px 1px 0px 2px';
            } else if (!textBox.validity.valid) {
                errorSpan.innerHTML = 'Campo Inválido';
                textBox.style.boxShadow = '#f83340 1px 1px 0px 2px';
            } else {
                errorSpan.innerHTML = '';
                textBox.style.boxShadow = '';
            }
        });

        // Verifica a validade de cada input de senha antes de enviar
        senhaInputs.forEach(senhaInput => {
            const senha = senhaInput.value;
            const senhaValida = validarSenha(senha);
            const errorSpan = senhaInput.nextElementSibling;

            if (!senhaValida) {
                errorSpan.innerHTML = 'A senha deve ter no mínimo 8 caracteres, '
                    + 'pelo menos uma letra maiúscula, uma letra minúscula, '
                    + 'um número e um caractere especial.';
                senhaInput.style.boxShadow = '#f83340 1px 1px 0px 2px';
            } else {
                errorSpan.innerHTML = '';
                senhaInput.style.boxShadow = '';
            }
        });

        // Verifica a validade de cada input de confirmação de senha antes de enviar
        confirmarSenhaInputs.forEach(confirmarSenhaInput => {
            const senha = document.querySelector('.inputSenha').value;
            const errorSpan = confirmarSenhaInput.nextElementSibling;

            if (confirmarSenhaInput.value !== senha) {
                errorSpan.innerHTML = 'As senhas não coincidem';
                confirmarSenhaInput.style.boxShadow = '#f83340 1px 1px 0px 2px';
            } else {
                errorSpan.innerHTML = '';
                confirmarSenhaInput.style.boxShadow = '';
            }
        });

        // Se todos os campos forem válidos, envie o formulário
        const todosValidos = [...textBoxes, ...senhaInputs, ...confirmarSenhaInputs].every(input => input.validity.valid);
        if (todosValidos) {
            form.submit();
        }
    });
}

// Função de validação da senha
function validarSenha(senha) {
    const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()\[\]{}\\\-_=+])[A-Za-z\d!@#$%^&*()\[\]{}\\\-_=+]{8,}$/;
    return regex.test(senha);
}

// Chama a função de adicionarValidacao quando a página é carregada
window.addEventListener('load', adicionarValidacao);
