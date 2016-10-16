<?php
require_once('Crud.class.php');
require_once "$ROOT/application/Functions.php";

class GruposUsuariosDAO extends Crud{
    public static $table = 'grupos_usuarios';
}
