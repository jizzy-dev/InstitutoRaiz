<?php
class TemplateRenderer
{
    private static $twig;

    public static function initialize()
    {
        if (!isset(self::$twig)) {
            $loader = new \Twig\Loader\FilesystemLoader('app/View');
            self::$twig = new \Twig\Environment($loader);
            self::$twig->addFunction(new \Twig\TwigFunction('count_keys', 
            function ($obj) {
                if (is_object($obj)) {
                    return count(get_object_vars($obj));
                } elseif (is_array($obj)) {
                    return count($obj);
                } else {
                    return 0;
                }
            }));
        }
    }

    public static function render($templateName, $parametros = [])
    {
        self::initialize();
        $template = self::$twig->load($templateName);
        return $template->render($parametros);
    }
}