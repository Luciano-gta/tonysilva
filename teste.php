<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Cadastro de usuário</title>
    </head>

    <body>
        <h1>Novo Usuário</h1>
        <form action="dao/Cadastro_clientes.php" method="post" enctype="multipart/form-data" name="cadastro" >
            Nome:<br />
            <input type="text" name="nome" /><br /><br />
            Email:<br />
            <input type="text" name="email" /><br /><br />
            Foto de exibição:<br />
            <input type="file" name="foto" /><br /><br />
            <input type="submit" name="cadastrar" value="Cadastrar" />
        </form>

        <hr />

        <h1>Usuários cadastrados</h1>
        <?php
// Conexão com o banco de dados
        include("classes\Conexao.php");
        $db = new Conexao;
// Seleciona todos os usuários
        $sql = $db->executeQuery("SELECT * FROM clientes ORDER BY cli_nome") or die('Erro: ' . mysql_error());

// Exibe as informações de cada usuário
        while ($usuario = mysql_fetch_object($sql)) {
            // Exibimos a foto
            echo "<hr />";
            echo "<img src='img/" . $usuario->cli_foto . "' alt='Foto de exibição' /><br />";
            // Exibimos o nome e email
            echo "<b>Nome:</b> " . $usuario->cli_nome . "<br />";
            echo "<b>Email:</b> " . $usuario->cli_email . "<br /><br />";
        }
        ?>
    </body>
</html>