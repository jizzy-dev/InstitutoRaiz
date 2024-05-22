<?php
class MatriculaController
{
    public function Cadastrar()
    {
        global $parametros;
        $parametros = ['titulo' => 'Matrícula'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dadosUsuario = [
                'nome' => $_POST['nome_responsavel'],
                'cpf' => $_POST['cpf_responsavel'],
                'rg' => $_POST['rg_responsavel'],
                'contato' => $_POST['contato_responsavel'],
                'email' => $_POST['email_responsavel'],
                'senha' => $_POST['senha_responsavel'],
                'data_nasc' => $_POST['data_nasc_responsavel'],
                'cep' => $_POST['cep'],
                'logradouro' => $_POST['logradouro'],
                'bairro' => $_POST['bairro'],
                'numero_endereco' => $_POST['numero_endereco'],
                'complemento' => $_POST['complemento'],
                'cidade' => $_POST['cidade'],
                'estado' => $_POST['estado'],
                'isResponsavel' => isset($_POST['isResponsavel']) ? 1 : 0, // Marcar como responsável se o campo estiver presente
                'isPadrinho' => isset($_POST['isPadrinho']) ? 1 : 0, // Marcar como padrinho se o campo estiver presente
                'isAdm' => 0, // Por padrão, não é um administrador
                'isMod' => 0, // Por padrão, não é um moderador
                'ID_IMAGEM' => 1
            ];
            try {
                $id_usuario = Usuario::Create($dadosUsuario);

                $dadosAluno = [
                    'nome' => $_POST['nome_aluno'],
                    'cpf' => $_POST['cpf_aluno'],
                    'rg' => $_POST['rg_aluno'],
                    'data_nasc' => $_POST['data_nasc_aluno'],
                    'certidao' => $_POST['certidao_aluno'],
                    'carteira_vacina' => $_POST['carteira_vacina_aluno'],
                    'situacao_matricula' => isset($_POST['situacao_matricula']) ? $_POST['situacao_matricula'] : 'pendente',
                    'data_matricula' => isset($_POST['data_matricula']) ? $_POST['data_matricula'] : date('Y-m-d h:i:s'),
                    'data_inicio' => isset($_POST['data_inicio']) ? $_POST['data_inicio'] : date('Y-m-d h:i:s'),
                    'ID_TURMA' => isset($_POST['ID_TURMA']) ? $_POST['ID_TURMA'] : 1,
                    'ID_USER_RESPONSAVEL' => $id_usuario,
                    'ID_USER_PADRINHO' => isset($_POST['ID_USER_PADRINHO']) ? $_POST['ID_USER_PADRINHO'] : 1
                ];

                Aluno::Create($dadosAluno);

                echo TemplateRenderer::render('cadastro_sucesso.html');
            } catch (Exception $e) {
                $this->handleError('Erro ao cadastrar matrícula: ' . $e->getMessage());
            }
        } else {
            echo TemplateRenderer::render('cadastrar.html', $parametros);
        }
    }
    private function handleError($errorMessage)
    {
        $erroController = new ErroController();
        $erroController->index($errorMessage);
    }
}
