<?php
session_start();
require_once "db_migracao.php";
$usuarios = $pdo->query("SELECT * FROM usuarios");

?>