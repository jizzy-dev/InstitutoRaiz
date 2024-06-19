<?php
class Autorizar
{
    public static function verificarAutorizacao(array $perfisNecessario)
    {
        if (!in_array($_SESSION['user']->perfil_acesso, $perfisNecessario)) {
            return true;
        }
        return false;
    }
}
