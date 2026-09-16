<?php

require_once "db_migracao.php";
// require_once "includes/menu.php";
// require_once "includes/item_menu.php";

if($_POST){
    $id = $_POST['id'];
    $campos = array();
    foreach($_POST as $key => $value){
        $campos[] = $key;

        if($key !== 'id'){
            $update[] = $key.' = "'.$value.'"';
        }
    };
    
}
if($id_pedido){
    
    $sql = db()->prepare('SELECT * from pedidos WHERE id = '.$id_pedido);
    $sql->execute();
    $pedido_ind = $sql->fetch();
  
}



?>

<style>
    #editar_forma{
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

          
                                
                            
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">pedido *</label>
                        <input type="text" name="nome" class="form-input" required placeholder="pedido" value="<?=$pedido_ind['id']?>" >
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Slug *</label>
                        <input type="text" name="slug" class="form-input" required placeholder="Slug" value="<?=$pedido_ind['status']?>">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Descrição *</label>
                        <input type="text" name="descricao" class="form-input" required placeholder="Descrição" value="<?=$pedido_ind['subtotal']?>">
</div>
                    <div class="flex gap-2">
                        <button type="submit" class="bg-senai-blue text-white font-bold px-5 py-2.5 rounded-lg text-sm hover:bg-senai-blue-dark transition">💾 Salvar</button>
                    </div>
                </form>
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
                            <th class="px-4 py-3 text-left">Categoria</th>
                            <th class="px-4 py-3 text-center">pedido</th>
                            <th class="px-4 py-3 text-center">SKU</th>
                            <th class="px-4 py-3 text-center">Preço</th>
                            <th class="px-4 py-3 text-center">Quantidade</th>
                            <th class="px-4 py-3 text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">

                    <?php 
                     $sql = db()->prepare('SELECT p.id, c.nome categoria, p.nome pedido, p.descricao, p.sku, p.preco, e.quantidade
                                                FROM pedidos p 
                                                LEFT JOIN categorias c ON (p.categoria_id = c.id)
                                                LEFT JOIN estoques e ON (p.id = e.pedido_id)
                                                WHERE p.ativo = 1');
                     $sql->execute();
                     $pedido = $sql->fetchAll();
                    //  echo '<pre>';
                    //  print_r($usuario);
                    //  die;

                    foreach( $pedido as $u){
                    ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-center text-gray-600 font-semibold"><?=$u["categoria"];?></td>
                            <td class="px-4 py-3 text-center text-gray-600 font-semibold"><?=$u["pedido"];?></td>
                            <td class="px-4 py-3 text-center text-gray-600 font-semibold"><?=$u["sku"];?></td>
                            <td class="px-4 py-3 text-center text-gray-600 font-semibold"><?=number_format($u["preco"],2,',', '.');?></td>
                            <td class="px-4 py-3 text-center text-gray-600 font-semibold"><?=$u["quantidade"];?></td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="?editar=<?=$u["id"]; ?>" class="bg-yellow-500 text-white text-xs px-2.5 py-1.5 rounded-md hover:bg-yellow-600 transition" title="Editar">✏ Editar</a>
                                    <a onclick="return confirm('Tem certeza disso?')" class="bg-senai-red text-white text-xs px-2.5 py-1.5 rounded-md hover:bg-red-700 transition" href="?excluir=<?=$u["id"]; ?>">Excluir</a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>

                     

                    </tbody>
                </table>

                <!-- RODAPÉ DA TABELA -->
                <div class="border-t border-gray-100 px-4 py-3 flex items-center justify-between bg-gray-50">
                    <p class="text-xs text-gray-400">Exibindo 3 de 3 cursos</p>
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
