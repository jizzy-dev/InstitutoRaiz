<?php
class SistemaController
{
    public function index()
    {
            $loader= new \Twig\Loader\FilesystemLoader('app/View');
            $twig = new \Twig\Environment($loader);
            $template = $twig->load('sistema.html');

            $conteudo = $template->render();

            echo $conteudo;

    }
    public function redirectUsuarios()
    {
            $loader= new \Twig\Loader\FilesystemLoader('app/View');
            $twig = new \Twig\Environment($loader);
            $template = $twig->load('usuario.html');

            $conteudo = $template->render();

            echo $conteudo;

    }
    public function redirectTodosUsuarios()
    {
            $loader= new \Twig\Loader\FilesystemLoader('app/View');
            $twig = new \Twig\Environment($loader);
            $template = $twig->load('todosUsuarios.html');

            $conteudo = $template->render();

            echo $conteudo;

    }
}
