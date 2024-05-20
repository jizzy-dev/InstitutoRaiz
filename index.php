<?php

// core
require_once 'app/Core/Core.php';
// database
require_once 'lib/Database/Connection.php';
// controladores
require_once 'app/Controller/HomeController.php';
require_once 'app/Controller/SistemaController.php';
require_once 'app/Controller/UsuarioController.php';
require_once 'app/Controller/AlunoController.php';
require_once 'app/Controller/ErroController.php';
// modelos
require_once 'app/Model/Usuario.php';
require_once 'app/Model/Aluno.php';
// helpers
require_once 'app/Helper/TemplateRenderer.php';
// autoload
require_once 'vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader('app/Template');
$twig = new Environment($loader);

$core = new Core();
$saida = $core->run($_GET);

global $parametros;
$titulo = isset($parametros['titulo']) ? $parametros['titulo'] : 'Instituo Raíz do Futuro';

echo $twig->render('template.html', ['area_dinamica' => $saida, 'titulo' => $titulo]);
