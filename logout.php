<?php
// Iniciar a sessão
session_start();

$_SESSION = array();

// Destruir todos os dados da sessão
session_destroy();

// Redirecionar para a tela de login
header("Location: login.php");


exit;

?>

