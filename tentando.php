<?Php
require_once 'db_migracao.php';

echo '<pre>';

$arquivo   = fopen('clientes.csv', 'r');
$cabecalho = fgetcsv($arquivo, 0, ';');

// foreach($clientes as $file){
//     $arquivo = fopen('clientes.csv', 'r');
//     $cabecalho = fgetcsv($arquivo, 0, ';');
$sql = db() -> prepare('TRUNCATE TABLE clientes');
$sql -> execute();


    $colunas = implode(',',$cabecalho);

    
    $i = 0;

    while (($linha = fgetcsv($arquivo, 0, ';')) !== false) {
        $insert = "INSERT INTO clientes";
        $insert .= '('.$colunas.') VALUES ';


        $clientes = [
            "id" => $linha[0] ?? null,
            "nome" => $linha[1] ?? null,
            "email" => $linha[2] ?? null,
            "cpf" => $linha[3] ?? null,
            "telefone" => $linha[4] ?? null,
            "senha" =>  $linha[5] ?? null,
            "ativo" =>  $linha[6] ?? null,
            "criadoEm" =>  $linha[7] ?? null,
            "atualizadoEm" => $linha[8] ?? null,
        
        ];
        $valores = [];
    
        foreach($linha as $indice => $valor){
        $i++;
        echo 'Importando a linha '.$i.'<br>';
        if($cabecalho[$indice] === 'cpf'){
            $valor = str_replace(['.','-',' '],'',$valor);
        }
        if($cabecalho[$indice] === 'telefone'){
            $valor = str_replace(['(',')',' ','-'],'',$valor);
        }
        $valores[] = "'".$valor."'";

        print_r($valores);
        
    }

    $insert .= '('.implode(',',$valores).')';
    echo $insert;
    
    $sql = db()-> prepare($insert);
    $sql->execute();
}
fclose($arquivo); 

    
?>