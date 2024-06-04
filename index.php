<?php
// core
require_once 'app/Core/Core.php';
// database
require_once 'lib/Database/Connection.php';
// modelos
require_once 'app/Model/Autenticar.php';
require_once 'app/Model/Imagem.php';
require_once 'app/Model/Usuario.php';
require_once 'app/Model/ValidarDuplos.php';
require_once 'app/Model/Aluno.php';
require_once 'app/Model/Turma.php';
require_once 'app/Model/Frequencia.php';
// autoload
require_once 'vendor/autoload.php';
// helpers
require_once 'app/Helper/VerificarSessao.php';
require_once 'app/Helper/TemplateRenderer.php';
// controladores
require_once 'app/Controller/AutenticarController.php';
require_once 'app/Controller/AutenticarController.php';
require_once 'app/Controller/ImagemController.php';
require_once 'app/Controller/HomeController.php';
require_once 'app/Controller/UsuarioController.php';
require_once 'app/Controller/SistemaController.php';
require_once 'app/Controller/AlunoController.php';
require_once 'app/Controller/TurmaController.php';
require_once 'app/Controller/MatriculaController.php';
require_once 'app/Controller/PadrinhoController.php';
require_once 'app/Controller/FrequenciaController.php';
require_once 'app/Controller/ErroController.php';

session_start();

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader('app/Template');
$twig = new Environment($loader);


$core = new Core();
$saida = $core->run($_GET);

global $parametros, $template;
$titulo = isset($parametros['titulo']) ? $parametros['titulo'] : 'Instituto Raíz do Futuro';
$template = isset($parametros['template']) ? $parametros['template'] : 'template.html';

echo $twig->render($template, ['area_dinamica' => $saida, 'titulo' => $titulo]);
