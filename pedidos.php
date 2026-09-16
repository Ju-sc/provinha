<?php

require_once "db_migracao.php";
// require_once "includes/menu.php";
// require_once "includes/item_menu.php";

if($_POST){
    $sql = db()->prepare('SELECT * from pedidos WHERE id = '.$id_pedido);
    $sql->execute();
    $pedido_ind = $sql->fetch();
}

  $limite = 20;
  $pagina_atual = $_GET['pagina'] ?? 1;
  $OFFSET = ($pagina_atual - 1) * $limite;
  $sql = db()->prepare('SELECT COUNT(id) FROM pedidos');                     
  $sql_count->execute();
  $total_pedidos = $sql->fetchColumn();

  ?>
<style>
    editar_forma{
        margin: 50px 200px;
        border: 2px solid rgba(0, 0, 0, 0.1);
        padding: 40px;
        border-radius: 30px;
        display: <?=$id_pedido ? 'block' : 'none'?>;
    }


</style>
    <!-- CONTEÚDO PRINCIPAL -->
    <main class="flex-1 flex flex-col">

        <!-- TOPBAR -->
        <div class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
            <div>
                <h1 class="text-xl font-extrabold text-gray-800">Gerenciar pedidos</h1>
                <p class="text-sm text-gray-500">Cadastre, edite e organize os pedidos</p>
            </div>
            <a href="curso_form.html" class="bg-senai-green text-white font-bold px-4 py-2.5 rounded-lg text-sm hover:bg-green-600 transition flex items-center gap-2">
                + Novo pedido
            </a>
        </div>

          
                                
                            
                     
            <!-- MENSAGEM DE SUCESSO -->
            <!-- <div class="bg-green-50 border border-green-300 text-green-700 rounded-lg p-3 mb-5 flex items-center gap-2 text-sm">
                <span class="font-bold text-base">✓</span>
                <span>Curso excluído com sucesso!</span>
                <button class="ml-auto text-green-400 hover:text-green-700 text-lg leading-none">×</button>
            </div> -->

            <!-- TABELA DE CURSOS -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-senai-blue text-white">
                        <tr>
                            <th class="px-4 py-3 text-left">ID</th>
                            <th class="px-4 py-3 text-center">STATUS</th>
                            <th class="px-4 py-3 text-center">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">

                    <?php 
                     

                     $total_paginas = ceil($total_pedidos / $limite);
                     $sql = db()->prepare("SELECT id, status, total FROM pedidos LIMIT $limite OFFSET $offset");
                     $sql->execute();
                     $pedido = $sql->fetchAll();

                    foreach($pedido as $u){
                    ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-center text-gray-600 font-semibold"><?=$u["id"];?></td>
                            <td class="px-4 py-3 text-center text-gray-600 font-semibold"><?=$u["status"];?></td>
                            <td class="px-4 py-3 text-center text-gray-600 font-semibold"><?=number_format($u["total"],2,',', '.');?></td>
                            <td class="px-4 py-3 text-center">
                            </td>
                        </tr>
                    <?php } ?>

                    </tbody>
                </table>

                <!-- RODAPÉ DA TABELA -->
                <div class="border-t border-gray-100 px-4 py-3 flex items-center justify-between bg-gray-50">
                    <div class="flex gap-1">
                        <button class="px-3 py-1 text-xs border border-gray-300 rounded bg-white text-gray-500">← Anterior</button>
                        <button class="px-3 py-1 text-xs border border-senai-blue rounded bg-senai-blue text-white font-semibold">1</button>
                        <button class="px-3 py-1 text-xs border border-gray-300 rounded bg-white text-gray-500">Próxima →</button>
                    </div>
                </div>
            </div>

        </div>
    </main>

</body>
</html>
