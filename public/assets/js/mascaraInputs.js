function adicionarMascara() {
    // Seleciona todos os elementos com a classe .inputCPF
    const cpfInputs = document.querySelectorAll('.inputCPF');
    const rgInputs = document.querySelectorAll('.inputRG');
    const certidaoInputs = document.querySelectorAll('.inputCertidao');
    const contatoInputs = document.querySelectorAll('.inputContato');
    const cepInputs = document.querySelectorAll('.inputCEP');

    // Função genérica para aplicar máscara
    function aplicarMascara(valor, partes, separadores) {
        valor = valor.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
        let valorFormatado = '';
        let posicao = 0;

        for (let i = 0; i < partes.length; i++) {
            if (valor.length > posicao) {
                if (i > 0) {
                    valorFormatado += separadores[i - 1];
                }
                valorFormatado += valor.substring(posicao, posicao + partes[i]);
                posicao += partes[i];
            }
        }

        return valorFormatado;
    }

    // Máscaras específicas
    function formatarCPF(valor) {
        return aplicarMascara(valor, [3, 3, 3, 2], ['.', '.', '-']);
    }

    function formatarRG(valor) {
        return aplicarMascara(valor, [2, 3, 3, 1], ['.', '.', '-']);
    }

    function formatarCertidao(valor) {
        return aplicarMascara(valor, [6, 2, 2, 4, 1, 5, 3, 7, 2], ['.', '.', '.', '.', '.', '.', '.', '-', '']);
    }
    
    function formatarContato(valor) {
        return aplicarMascara(valor, [0,2, 5, 4], ['(', ') ', '-']);
    }
    
    function formatarCEP(valor) {
        return aplicarMascara(valor, [5, 3], ['-']);
    }

    // Adicionar eventos para os inputs de CPF
    cpfInputs.forEach(input => {
        adicionarEventoMascaraInput(input, formatarCPF);
    });

    // Adicionar eventos para os inputs de RG
    rgInputs.forEach(input => {
        adicionarEventoMascaraInput(input, formatarRG);
    });

    // Adicionar eventos para os inputs de Certidão
    certidaoInputs.forEach(input => {
        adicionarEventoMascaraInput(input, formatarCertidao);
    });
    
    // Adicionar eventos para os inputs de Contato
    contatoInputs.forEach(input => {
        adicionarEventoMascaraInput(input, formatarContato);
    });
    
    // Adicionar eventos para os inputs de CEP
    cepInputs.forEach(input => {
        adicionarEventoMascaraInput(input, formatarCEP);
    });
}

// Função para adicionar eventos de máscara a um input específico
function adicionarEventoMascaraInput(input, funcaoFormatar) {
    input.addEventListener('input', () => {
        input.value = funcaoFormatar(input.value);
    });

    input.addEventListener('keypress', (e) => {
        if (!/^\d$/.test(e.key)) { // Permitir apenas números
            e.preventDefault();
        }
    });
}

// Chama a função de adicionarMascara quando a página é carregada
window.addEventListener('load', adicionarMascara);
