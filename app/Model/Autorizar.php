<?php
class Autorizar
{
    public static function verificarAutorizacao(String $perfilNecessario)
    {
        if ($_SESSION['user']->perfil_acesso !== $perfilNecessario) {
            return true;
        }
    }
}
