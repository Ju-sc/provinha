<?php
#começando a sessão para processar as ações do usuario e conexão com o banco sql 'aqualert'
session_start();
require_once "db_migracao.php";

#se o usuario já tiver logado ele será redirecionado no mesmo instante
if (isset($_SESSION["id_usuario"])){
    if ($_SESSION["tipo"] == "user"){
        header("location: login.php");
    }else if ($_SESSION["tipo"] == "adm"){
        header("location: admin/home.php");
    }else if ($_SESSION["tipo"] == "gestor"){
        header("location: gestor/home.php");
    }exit;
}

#variável que vai guardar as menssagens de erro
$erro = "";

#aqui vai identificar se o formulário foi entregue 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
$email = $_POST["email"];
$senha = $_POST["senha"];
#identifica se o email tem nos usuarios
$res = mysqli_query($conexao, "SELECT * from usuario where email = '$email'");

#se acha o email ele verifica a senha se está certa e guarda as informações da sessão no banco
if ($usuario = mysqli_fetch_assoc($res)){
    if (password_verify($senha, $usuario["senha"])){

        $_SESSION["id_usuario"] = $usuario["id_usuario"];
        $_SESSION["nome"] = $usuario["nome"];
        $_SESSION["email"] = $usuario["email"];
        $_SESSION["tipo"] = $usuario["tipo"];

#aqui é onde acontece o redirecionamento de tipos de usuarios,
#user = usuario comum
#adm = usuario administrador
#gestor = usuario gerenciador

        if ($_SESSION["tipo"] == "user"){
            header("location: menu.php");
        }else if ($_SESSION["tipo"] == "adm"){
            header("location: admin/home.php");
        }else if ($_SESSION["tipo"] == "gestor"){
            header("location: gestor/home.php");
        }exit;
        }else{
            $erro = "Email ou senha inválidos.";
        }
    }else{
            $erro = "Email ou senha inválidos.";
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
     <h1 style="margin-bottom: 0.2rem; font-size: 1.6rem;">Aqualert</h1>
     <p style="margin-bottom: 30px; font-size: 0.9rem;"> acesse sua conta</p>
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