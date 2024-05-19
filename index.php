<?php

require_once 'app/Core/Core.php';

require_once 'lib/Database/Connection.php';

require_once 'app/Controller/HomeController.php';
require_once 'app/Controller/SistemaController.php';
require_once 'app/Controller/UsuarioController.php';
require_once 'app/Controller/ErroController.php';

require_once 'app/Model/Usuario.php';

require_once 'app/Helper/TemplateRenderer.php';

require_once 'vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader('app/Template');
$twig = new Environment($loader);

$core = new Core();
ob_start();
$core->run($_GET);
$saida = ob_get_clean();

echo $twig->render('template.html', ['area_dinamica' => $saida]);

