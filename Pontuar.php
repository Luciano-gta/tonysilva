<html>
    <head>
        <meta charset="utf-8">
        <title>Sistema de Cadastro</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/custom.css">
    </head>
    <body>
        <?php
        require './classes/Conexao.php';

        $pontos = (isset($_GET['pontos'])) ? $_GET['pontos'] : '';
        $id = (isset($_GET['codigo'])) ? $_GET['codigo'] : '';
        

        
        if (filter_has_var(INPUT_GET, 'pontuar')):

            if (!empty($pontos)):
                $conexao = conexao::getInstance();
                $sql = "update clientes set cli_visitas = cli_visitas+1,cli_ptototal = cli_ptototal+ '" . $pontos . "' WHERE cli_codigo = $id";
                $stm = $conexao->prepare($sql);
                //$stm->bindValue(':id', $id);
                $retorno = $stm->execute();
                if ($retorno):
                    echo "<div class='alert alert-success' role='alert'> Pontos adicionadados com sucesso ...</div> ";
                else:
                    echo "<div class='alert alert-danger' role='alert'>Erro ao Adicionar Pontos...!</div> ";
                endif;
                
                echo "<meta http-equiv=refresh content='3;URL=Dash.php'>";
            else :
                echo "<div class='alert alert-success' role='alert'>Ops! Nao pegeuei os Pontos!! ...</div> ";
            endif;
        
            else :
           
                //echo "<div class='alert alert-danger' role='alert'>Nao achei a acao...!</div> ";
            
            endif;

        if (filter_has_var(INPUT_GET, 'recolher')):
            $conexao = conexao::getInstance();
            $sql = "update clientes set cli_ptousado = cli_ptousado + '" . $pontos . "' WHERE cli_codigo = $id";
            $stm = $conexao->prepare($sql);
            //$stm->bindValue(':id', $id);
            $retorno = $stm->execute();
            if ($retorno):
                echo "<div class='alert alert-success' role='alert'> Pontos Recolhidos com sucesso ...</div> ";
            else:
                echo "<div class='alert alert-danger' role='alert'>Erro ao Recolher Pontos...!</div> ";
            endif;
            
            echo "<meta http-equiv=refresh content='3;URL=Dash.php'>";
           
            endif;
            
        ?> 
    </body>
</html>