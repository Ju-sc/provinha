<?php
require_once "db_migracao.php";
require_once "includes/menu.php";

$id_produto = isset($_REQUEST['editar']) ? $_REQUEST['editar'] : null;
$excluir = isset($_REQUEST['excluir']) ? $_REQUEST['excluir'] : null;

$where = '';

if($_POST){
    $id = $_POST['id'];
    $pesquisa = $_POST['pesquisa'];

    if($pesquisa !== ""){
        $where = ' and p.nome like "%'.$pesquisa.'%" OR p.sku like "%'.$pesquisa.'%"';
    }else{
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
}

if($excluir){
    $sql = db()->prepare('UPDATE produtos SET ativo = 0 WHERE id = '.$excluir);
    $sql->execute();
    header("Location: produto.php");
    exit;
}

//Por causa do fetch(), ele traz um único registro (um array simples).
$produto_ind = [];
if($id_produto){
    $sql = db()->prepare('SELECT * FROM produtos WHERE id = '.$id_produto);
    $sql->execute();
    $produto_ind = $sql->fetch();
}


$limite = 20;
$sql_count = db()->prepare('SELECT COUNT(id) FROM produtos');                    
$sql_count->execute();
$total_produtos = $sql_count->fetchColumn();
$total_paginas = ceil($total_produtos / $limite);

$pagina_atual = $_GET['pagina'] ?? 1;
$OFFSET = ($pagina_atual - 1) * $limite;


//Por causa do fetchAll(), a variável $produtos vira uma lista (um array multidimensional). 
//Ela não tem um nome ou preço direto; ela tem a posição 0, posição 1, posição 2...
$sql = db()->prepare('SELECT * FROM produtos LIMIT ' . $limite . ' OFFSET ' . $OFFSET);                
$sql->execute();
$produtos = $sql->fetchAll();
?>

<style>
    #editar_forma {
        margin: 50px 200px;
        border: 2px solid rgba(194, 169, 27, 0.77);
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
        <a href="pedidos.php" 1  class="bg-senai-green text-white font-bold px-4 py-2.5 rounded-lg text-sm hover:bg-green-600 transition flex items-center gap-2">
                -> Pedidos
            </a>
            <a href="relatorios.php" 1  class="bg-senai-green text-white font-bold px-4 py-2.5 rounded-lg text-sm hover:bg-green-600 transition flex items-center gap-2">
                -> Relatórios
            </a>
    </div>

    
    <div class="bg-white rounded-xl shadow-sm p-6">
        
        <form method="post" id="editar_forma">
            <input type="hidden" value="<?=$produto_ind['id'] ?? "" ?>" name="id"/>
            
            <div class="mb-4">
                <label class="form-label">Produto *</label>
                <input type="text" name="nome" class="form-input" required placeholder="Produto" value="<?=$produto_ind['nome'] ?? ''?>" >
            </div>
            <div class="mb-4">
                <label class="form-label">Slug *</label>
                <input type="text" name="slug" class="form-input" required placeholder="Slug" value="<?=$produto_ind['slug'] ?? ''?>">
            </div>
            <div class="mb-4">
                <label class="form-label">Descrição *</label>
                <input type="text" name="descricao" class="form-input" required placeholder="Descrição" value="<?=$produto_ind['descricao'] ?? ''?>">
            </div>
            <div class="mb-4">
                <label class="form-label">SKU *</label>
                <input type="text" name="sku" class="form-input" required placeholder="SKU" value="<?=$produto_ind['sku'] ?? ''?>">
            </div>
            <div class="mb-4">
                <label class="form-label">Preço *</label>
                <input type="text" name="preco" class="form-input" required placeholder="Preço" value="<?=$produto_ind['preco'] ?? ''?>">
            </div>
            <div class="mb-4">
                <label class="form-label">Preço Promocional*</label>
                <input type="text" name="preco_promocional" class="form-input" required placeholder="Preço Promocional" value="<?=$produto_ind['preco_promocional'] ?? ''?>">
            </div>
            <div class="mb-4">
                <label class="form-label">Peso*</label>
                <input type="text" name="peso" class="form-input" required placeholder="Peso" value="<?=$produto_ind['peso'] ?? ''?>">
            </div>
            <div class="mb-4">
                <label class="form-label">Altura*</label>
                <input type="text" name="altura" class="form-input" required placeholder="Altura" value="<?=$produto_ind['altura'] ?? ''?>">
            </div>
            <div class="mb-4">
                <label class="form-label">Largura*</label>
                <input type="text" name="largura" class="form-input" required placeholder="Largura" value="<?=$produto_ind['largura'] ?? ''?>">
            </div>
            <div class="mb-4">
                <label class="form-label">Comprimento*</label>
                <input type="text" name="comprimento" class="form-input" required placeholder="Comprimento" value="<?=$produto_ind['comprimento'] ?? ''?>">
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-senai-blue text-white font-bold px-5 py-2.5 rounded-lg text-sm hover:bg-senai-blue-dark transition">💾 Salvar</button>
            </div>
        </form>
        
        
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mt-6">
            <table class="w-full text-sm">
                <thead class="bg-senai-blue text-white">
                    <tr>
                        <th class="px-4 py-3 text-left">ID</th>
                        <th class="px-4 py-3 text-center">Produto</th>
                        <th class="px-4 py-3 text-center">SKU</th>
                        <th class="px-4 py-3 text-center">Preço</th>
                        <th class="px-4 py-3 text-center">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php 
                    
                    foreach($produtos as $u) { 
                    ?>
                        <tr>
                            <td class="px-4 py-3 text-left"><?=$u['id']?></td>
                            <td class="px-4 py-3 text-center"><?=$u['nome']?></td>
                            <td class="px-4 py-3 text-center"><?=$u['sku']?></td>
                            <td class="px-4 py-3 text-center">R$ <?=$u['preco']?></td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="?editar=<?=$u["id"]; ?>" class="bg-yellow-500 text-white text-xs px-2.5 py-1.5 rounded-md hover:bg-yellow-600 transition" title="Editar">✏ Editar</a>
                                    <a onclick="return confirm('Tem certeza disso?')" class="bg-red-600 text-white text-xs px-2.5 py-1.5 rounded-md hover:bg-red-700 transition" href="?excluir=<?=$u["id"]; ?>">Excluir</a>
                                </div>
                            </td>
                        </tr>
                    <?php 
                    } 
                    ?>
                </tbody>
            </table>

            <!-- RODAPÉ DA TABELA (Onde fica a paginação) -->
            <div class="border-t border-gray-100 px-4 py-3 flex items-center justify-between bg-gray-50">
                <div class="flex gap-1">
                    <?php
                    
                    for ($i = 1; $i <= $total_paginas; $i++) {
                        if ($i == $pagina_atual) {
                            echo "<a href='?pagina=$i' class='px-3 py-1 text-xs border border-senai-blue rounded bg-senai-blue text-white font-semibold'> $i </a>";
                        } else {
                            echo "<a href='?pagina=$i' class='px-3 py-1 text-xs border border-gray-300 rounded bg-white text-gray-500'> $i </a>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>