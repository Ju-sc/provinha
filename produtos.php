<?php

require_once "db_migracao.php";
// require_once "includes/menu.php";
// require_once "includes/item_menu.php";


$id_produto = $_REQUEST['editar']?? null;;
$excluir = $_REQUEST['excluir']?? null;



 
if($_POST){
    $id = $_POST['id'];
    $campos = array();
    $update = array();
    foreach($_POST as $key => $value){
        $campos[] = $key;

        if($key !== 'id'){
            $update[] = $key.' = "'.$value.'"';
        }
       

    };

    if($id){
        // editar
        $insert = "UPDATE  produtos SET ";
        $insert .= implode(',',$update);
        $insert .= " WHERE id = ".$id;
   
        
    }else{
        // inserir
        $insert = "INSERT INTO produtos ";
        $insert .= '('.implode(',',$campos).')';
        $insert .= ' VALUES ';
        $insert .= '('.implode(',',$_POST).')';

    }

    $sql = db()->prepare($insert);
    $sql->execute();


}
    
if($excluir){
    $sql = db()->prepare('UPDATE produtos SET ativo = 0 WHERE id = '.$excluir);
    $sql->execute();
    header("Location: produto.php");
    exit;
}
if($id_produto){
    $sql = db()->prepare('SELECT id, nome from categorias WHERE ativo = 1');
    $sql->execute();
    $categoria = $sql->fetchAll();
    
    $sql = db()->prepare('SELECT * from produtos WHERE id = '.$id_produto);
    $sql->execute();
    $produto_ind = $sql->fetch();
  
}

// Buscar todos os cliente para listar

?>
<style>
    #editar_forma{
        margin: 50px 200px;
        border: 2px solid rgba(0, 0, 0, 0.1);
        padding: 40px;
        border-radius: 30px;
        display: <?=$id_produto ? 'block' : 'none'?>;
    }
</style>
    <!-- CONTEÚDO PRINCIPAL -->
    <main class="flex-1 flex flex-col">

        <!-- TOPBAR -->
        <div class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
            <div>
                <h1 class="text-xl font-extrabold text-gray-800">Gerenciar Produtos</h1>
                <p class="text-sm text-gray-500">Cadastre, edite e organize os produtos</p>
            </div>
            <a href="cadastro_produto" class="bg-senai-green text-white font-bold px-4 py-2.5 rounded-lg text-sm hover:bg-green-600 transition flex items-center gap-2">
                + Novo Produto
            </a>
        </div>

           <div class="bg-white rounded-xl shadow-sm p-6">
                <form  method="post" id="editar_forma">
                    <input type="hidden" value="<?=$produto_ind['id'] ?? "" ?>" name="id"/>
                    <div class="mb-4">
                        <label class="form-label">Categoria *</label>
                        <select name="categoria_id" class="form-input">
                            <?php 
                            foreach($categoria as $c){
                                echo '<option '.($produto_ind['categoria_id'] === $c['id'] ? 'selected' : '').' value="'. $c['id'].'">'. $c['nome'].'</option>';
                            }
                                
                            ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Produto *</label>
                        <input type="text" name="nome" class="form-input" required placeholder="Produto" value="<?=$produto_ind['nome']?>" >
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Slug *</label>
                        <input type="text" name="slug" class="form-input" required placeholder="Slug" value="<?=$produto_ind['slug']?>">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Descrição *</label>
                        <input type="text" name="descricao" class="form-input" required placeholder="Descrição" value="<?=$produto_ind['descricao']?>">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">SKU *</label>
                        <input type="text" name="sku" class="form-input" required placeholder="SKU" value="<?=$produto_ind['sku']?>">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Preço *</label>
                        <input type="text" name="preco" class="form-input" required placeholder="Preço" value="<?=$produto_ind['preco']?>">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Preço Promocional*</label>
                        <input type="text" name="preco_promocional" class="form-input" required placeholder="Preço Promocional" value="<?=$produto_ind['preco_promocional']?>">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Peso*</label>
                        <input type="text" name="peso" class="form-input" required placeholder="Peso" value="<?=$produto_ind['peso']?>">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Altura*</label>
                        <input type="text" name="altura" class="form-input" required placeholder="Altura" value="<?=$produto_ind['altura']?>">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Largura*</label>
                        <input type="text" name="largura" class="form-input" required placeholder="Largura" value="<?=$produto_ind['largura']?>">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Comrpimento*</label>
                        <input type="text" name="comprimento" class="form-input" required placeholder="Comprimento" value="<?=$produto_ind['comprimento']?>">
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

            
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-senai-blue text-white">
                        <tr>
                            <th class="px-4 py-3 text-left">Categoria</th>
                            <th class="px-4 py-3 text-center">Produto</th>
                            <th class="px-4 py-3 text-center">SKU</th>
                            <th class="px-4 py-3 text-center">Preço</th>
                            <th class="px-4 py-3 text-center">Quantidade</th>
                            <th class="px-4 py-3 text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">

                    <?php 
                     $sql = db()->prepare('SELECT p.id, c.nome categoria, p.nome produto, p.descricao, p.sku, p.preco, e.quantidade
                                                FROM produtos p 
                                                LEFT JOIN categorias c ON (p.categoria_id = c.id)
                                                LEFT JOIN estoques e ON (p.id = e.produto_id)
                                                WHERE p.ativo = 1');
                     $sql->execute();
                     $produto = $sql->fetchAll();
                    //  echo '<pre>';
                    //  print_r($usuario);
                    //  die;

                    foreach( $produto as $u){
                    ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-center text-gray-600 font-semibold"><?=$u["categoria"];?></td>
                            <td class="px-4 py-3 text-center text-gray-600 font-semibold"><?=$u["produto"];?></td>
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
                    <p class="text-xs text-gray-400">Exibindo 3 de 3 páginas   </p>
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
