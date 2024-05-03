<?php

require_once 'app/Core/Core.php';

require_once 'lib/Database/Connection.php';

require_once 'app/Controller/HomeController.php';
require_once 'app/Controller/UsuarioController.php';
require_once 'app/Controller/ErroController.php';

require_once 'app/Model/Usuario.php';

require_once 'vendor/autoload.php';

$template = file_get_contents('app/Template/template.php');

ob_start();
$core = new Core();
$core-> run($_GET);

$saida = ob_get_contents();
ob_end_clean();

$tplPronto = str_replace('{{area_dinamica}}',$saida,$template);

echo $tplPronto;