<!DOCTYPE html>
<html>
    <head>
<script>
    
        </script>        
        <?php
        require './classes/Conexao.php';
        require_once('./dao/seguranca.php');
        protegePagina();
// Recebe o termo de pesquisa se existir
        $termo = (isset($_GET['termo'])) ? $_GET['termo'] : '';

// Verifica se o termo de pesquisa está vazio, se estiver executa uma consulta completa
        if (empty($termo)):

            $conexao = conexao::getInstance();
            $sql = 'SELECT cli_codigo, cli_visitas, cli_ptototal, (cli_ptototal - cli_ptousado) as cli_ptodisp, cli_nome, cli_email, cli_celular, cli_status, cli_foto FROM clientes ;';
            $stm = $conexao->prepare($sql);
            $stm->execute();
            $clientes = $stm->fetchAll(PDO::FETCH_OBJ);
        else:

            // Executa uma consulta baseada no termo de pesquisa passado como parâmetro
            $conexao = conexao::getInstance();
            $sql = 'SELECT cli_codigo, cli_visitas, cli_ptototal,(cli_ptototal - cli_ptousado) as cli_ptodisp, cli_nome, cli_email, cli_telefone, cli_status,cli_foto FROM clientes WHERE nome LIKE :nome OR email LIKE :email';
            $stm = $conexao->prepare($sql);
            $stm->bindValue(':nome', $termo . '%');
            $stm->bindValue(':email', $termo . '%');
            $stm->execute();
            $clientes = $stm->fetchAll(PDO::FETCH_OBJ);

        endif;
            
       
        ?>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Painel - Tony Silva</title>

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/datepicker3.css" rel="stylesheet">
        <link href="css/styles.css" rel="stylesheet">

        <!--Icons-->
        <script src="js/lumino.glyphs.js"></script>

        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->
        <style type="text/css">
            .msg-erro{ color: red; }
        </style>
    </head>

    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#"><span>Tony Silva</span>Admin</a>
                    <ul class="user-menu">
                        <li class="dropdown pull-right">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> <?php echo($_SESSION['usuarioNome']) ?> <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Profile</a></li>
                                <li><a href="#"><svg class="glyph stroked gear"><use xlink:href="#stroked-gear"></use></svg> Settings</a></li>
                                <li><a href="logout.php"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>

            </div><!-- /.container-fluid -->
        </nav>

        <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
            <form role="search">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search">
                </div>
            </form>
            <ul class="nav menu">
                <li class="active"><a href="Dash.php"><svg class="glyph stroked address-book"><use xlink:href="#landed-address-book"></use></svg>Inicio</a></li>
                <li role="presentation" class="divider"></li>
                <li class="active"><a href="Aniversariantes.php"><svg class="glyph stroked address-book"><use xlink:href="#landed-address-book"></use></svg>Aniversariantes</a></li>
                <li role="presentation" class="divider"></li>
                <li><a href="login.html"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Login Page</a></li>
            </ul>
        </div><!--/.sidebar-->

        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
            <div class="row">
                <ol class="breadcrumb">
                    <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
                    <li class="active">Pontuação</li>
                </ol>
            </div><!--/.row-->

            <div class='container'>
                <fieldset>

                    <!-- Cabeçalho da Listagem -->
                    <legend><h1>Pontuação</h1></legend>

                    <!-- Formulário de Pesquisa -->
                    <form action="" method="get" id='form-contato' class="form-horizontal col-md-10">
                        <label class="col-md-2 control-label" for="termo">Pesquisar</label>
                        <div class='col-md-7'>
                            <input type="text" class="form-control" id="termo" name="termo" placeholder="Infome o Nome ou E-mail">
                        </div>
                        <button type="submit" class="btn btn-primary">Pesquisar</button>
                        <a href='Dash.php' class="btn btn-primary">Ver Todos</a>
                    </form>

                    <!-- Link para página de cadastro -->

                    <div class='clearfix'></div>

<?php if (!empty($clientes)): ?>
                    <form action="pontuar.php" method="get" name="form" >
                        <!-- Tabela de Clientes -->
                        <table class="table table-striped">
                            <tr class='active' >
                                <th>Foto</th>
                                <th>Nome</th>
                                <th>Visitas</th>
                                <th>Pontos</th>
                                <th>Disponivel</th>
                                <th>Pontuar/Recolher</th>
                                <th>Ação</th>
                            </tr>
    <?php foreach ($clientes as $cliente): ?>
                                <tr>
                                    <td><img src='fotos/<?= $cliente->cli_foto ?>' height='40' width='40'></td>
                                    <input type="hidden" name="id" value="<?=$cliente->cli_codigo?>">
                                    <td><?= $cliente->cli_nome ?></td>
                                    <td><?= $cliente->cli_visitas?></td>
                                    <td><?= $cliente->cli_ptototal?></td>
                                    <td><?= $cliente->cli_ptodisp?></td>
                                    <td><input id="pontos" name="pontos" type="text" ></td>
                                    <td>
                                        
                                        <button type="submit" class="btn btn-primary " name="pontuar" value="pontua" onclick="validaval()" >Pontuar</button>>
                                        <button type="submit" class="btn btn-danger " name="recolher" value="recolhe">Recolher</button>> 
                                    </td>
                                </tr>	
    <?php endforeach; ?>
                        </table>

                        <?php else: ?>

                        <!-- Mensagem caso não exista clientes ou não encontrado  -->
                        <div class="alert alert-danger" role="alert">
                            <strong>Atenção!</strong> Não existem Aniversariantes Para o mês Corrente!
                        </div>
                        <h3 class="text-center text-primary"></h3>
<?php endif; ?>
          </form>
                </fieldset>
            </div>

            <script type="text/javascript" src="js/custom.js"></script>

            <script src='http://code.jquery.com/jquery-2.1.3.min.js'></script>
            <script src='//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js'></script>
            <script>
                $(function () {
                    $('.dropdown-toggle').dropdown();
                   });
            </script>



    </body>

</html>