<?php

require_once "db_migracao.php";
require_once "includes/menu.php";
// require_once "includes/item_menu.php";




?>

    <!-- CONTEÚDO PRINCIPAL -->
    <main class="flex-1 flex flex-col">

        <!-- TOPBAR -->
        <div class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
            <div>
                <h1 class="text-xl font-extrabold text-gray-800">Relatório de pedidos</h1>
                <!-- <p class="text-sm text-gray-500">Cadastre, edite e organize os produtos</p> -->
            </div>
        </div>

           <div class="bg-white rounded-xl shadow-sm p-6">
              
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-senai-blue text-white">
                        <tr>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-center">Quantidade de pedidos</th>
                            <th class="px-4 py-3 text-center">Valor</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">

                    <?php 
                     $sql = db()->prepare('SELECT status, SUM(total) valor, COUNT(*) pedidos
                    FROM pedidos
                    GROUP BY status');
                     $sql->execute();
                     $produto = $sql->fetchAll();
                    //  echo '<pre>';
                    //  print_r($usuario);
                    //  die;

                    foreach( $produto as $u){
                        $status = ucfirst(str_replace('_',' ', $u["status"]));
                    ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-center text-gray-600 font-semibold"><?=$status;?></td>
                            <td class="px-4 py-3 text-center text-gray-600 font-semibold"><?=$u["pedidos"];?></td>
                            <td class="px-4 py-3 text-center text-gray-600 font-semibold">R$ <?=number_format($u["valor"],2,',', '.');?></td>
                        </tr>
                    <?php } ?>

                     

                    </tbody>
                </table>

            </div>

        </div>
    </main>

</body>
</html>
