<?php
#começando a sessão para processar as ações do usuario e conexão com o banco sql 'aqualert'
session_start();
require_once "db_migracao.php";

#se o usuario já tiver logado ele será redirecionado no mesmo instante
if (isset($_SESSION["usuario"])){
    if ($_SESSION["tipo"] == "operador"){
        header("location: login.php");
    }else if ($_SESSION["tipo"] == "admin"){
        header("location: admin/admin.php");
    }
}

#variável que vai guardar as menssagens de erro
$error_login = 0;

#aqui vai identificar se o formulário foi entregue 
if ($_POST) {
$email = $_POST['email'];
$senha = md5($_POST['senha']);
#identifica se o email tem nos usuarios

}
if($email !== '' && $senha !== ''){
    $sql = db()->prepare('SELECT id, nome, tipo FROM usuarios WHERE email = "'.$email.'" AND  senha = "'.$senha.'" AND ativo = 1');
    $sql->execute();
    $usuario = $sql->fetch();

    if(isset($usuario['id'])){
        unset($_SESSION['usuario']);
        $_SESSION['usuario'] = $usuario;

        header("Location: menu.php");
        exit;
    }else{
        $error_login = 1;
    }
    
    
}

?>
<html>
    <head>
        <title>login</title>
    </head>
    <body>
     <!--aqui se a variavel de erro estiver com alguma menssagem
     ele vai mostrar la na tela de login !-->   
     <h1 style="margin-bottom: 0.2rem; font-size: 1.6rem;">PROVINHA</h1>
     <p style="margin-bottom: 30px; font-size: 0.9rem;"> Acesse sua conta</p>
        <?php if (!empty($erro)): ?>
            <div style="color: red">
                <?php echo $erro; ?>
        <?php endif; ?>
        </div>
        
    
    <!--Aqui é o formulário onde o usuário vai colocar as informações de login para acessar a página!--> 
        <form method="POST" action="">
            <div>
                <label for="email">Email</label>
                <input
                type="email"
                name="email"
                required>
            </div>
            <div>
                <label for="senha">Senha</label>
                <input
                type="password"
                name="senha"
                required>
            </div">
            <div style="margin-top: 10px;">
                <button type="submit">Entrar</button>
            </div>
        </form>
        
    </body>
</html>