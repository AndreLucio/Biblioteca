<?php
/**
 * Created by PhpStorm.
 * User: tassio
 * Date: 04/01/2018
 * Time: 16:31
 */

require_once 'dao/daoUsuario.php';

// session_start inicia a sessão
session_start();
// as variáveis login e senha recebem os dados digitados na página anterior
$login = $_POST['login'];
$senha = $_POST['senha'];

$usuario = new daoUsuario();

$user = $usuario->logar($login, $senha);

unset($_SESSION['msgErro']);

if( $user != null)
{
    $_SESSION['login'] = $user->getNomeUsuario();
    $_SESSION['tipo'] = $user->getTipo();
    header('location:index.php');
}
else{
    unset ($_SESSION['login']);
    unset ($_SESSION['tipo']);
    $_SESSION['msgErro'] = "Usuário e/ou senha inválido(a)(os)";
    header('location:login.php');

}

?>