
<?php

if(!isset($_SESSION['usuario'])){
    echo $_SESSION['usuario']['id'];
    die;
    header("Location: login.php");
    exit;
  }
?>
<aside class="w-56 bg-gray-900 min-h-screen flex flex-col flex-shrink-0">
        <div class="px-4 py-5 border-b border-gray-700"><p class="text-white font-extrabold text-base">🎓 SENAI</p>
        <p class="text-gray-500 text-xs"><?=$_SESSION['usuario']['nome']?></p>
        <p class="text-gray-500 text-xs"><?=$_SESSION['usuario']['tipo']?></p>
    </div>
        <nav class="flex-1 p-3 space-y-1 pt-4">
            <a href="produto.php"   class="nav-link">Produtos</a>
            <a href="pedido.php"   class="nav-link">Pedidos</a>
            <a href="relatorio.php"   class="nav-link">Relatório</a>
            <div class="pt-2 border-t border-gray-700 mt-2">
                <a href="login.php?logout=ok" class="nav-link text-red-400">🚪 Sair</a>
            </div>
        </nav>
    </aside>
    