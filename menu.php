<?php
session_start();
require_once "db_migracao.php";

if (isset($_SESSION["usuario"])) {
    if ($_SESSION["usuario"] == 'adm'){
        header("Location: admin/cadastro_livro.php");
        }
    }else{
        header("Location: login.php");
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>

    <body class="bg-gray-100 min-h-screen flex">
    <aside class="sidebar">
    <div class="logo-container">
      <h2>Livraria<br>Oliveira</h2>
    </div>
    <nav class="menu-nav">
      <a href="loja.php">Início / Loja</a>
      <a href="#">Meus Pedidos</a>
      <a href="meu_perfil.php">Meu Perfil</a>
      <p style="font-size: 0.8rem; font-weight: 700; color: var(--marrom-claro); margin: 1rem 0 0.2rem 1rem; text-transform: uppercase;">Categorias</p>
      <a href="loja.php?Ficção">Ficção</a>
      <a href="loja.php?Terror">Terror</a>
      <a href="logout.php" style="color: #c62828; margin-top: 2rem;">Sair</a>
</nav>
  </aside>

</body>
</html>