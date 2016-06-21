<!DOCTYPE html>
<html>
    <head>
        
        <?php
        require './classes/Conexao.php';
        require_once('./dao/seguranca.php');
        protegePagina();
    
// Recebe o termo de pesquisa se existir
        $termo = (isset($_GET['termo'])) ? $_GET['termo'] : '';
// Termo para pegar o id
        $id =    (isset($_GET['id'])) ? $_GET['id'] : '';
// Verifica se o termo de pesquisa está vazio, se estiver executa uma consulta completa
        if (empty($termo)):

            $conexao = conexao::getInstance();
            $sql = 'SELECT cli_codigo,cli_visitas as cli_vistot , cli_nome, cli_email, cli_telefone, cli_status,cli_foto FROM clientes';
            $stm = $conexao->prepare($sql);
            $stm->execute();
            $clientes = $stm->fetchAll(PDO::FETCH_OBJ);

        else:

            // Executa uma consulta baseada no termo de pesquisa passado como parâmetro
            $conexao = conexao::getInstance();
            $sql = 'SELECT cli_codigo, cli_nome, cli_email, cli_telefone, cli_status,cli_foto FROM clientes WHERE cli_nome LIKE :cli_nome OR cli_email LIKE :cli_email';
            $stm = $conexao->prepare($sql);
            $stm->bindValue(':cli_nome', $termo . '%');
            $stm->bindValue(':cli_email',$termo . '%');
            $stm->execute();
            $clientes = $stm->fetchAll(PDO::FETCH_OBJ);

        endif;
        // Para o DASH
            $conexao = conexao::getInstance();
            $sql = 'SELECT cli_codigo,sum(cli_visitas) as cli_vistot , cli_nome, cli_email, cli_telefone, cli_status,cli_foto FROM clientes';
            $stm = $conexao->prepare($sql);
            $stm->execute();
            $dash = $stm->fetchAll(PDO::FETCH_OBJ);
        
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
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> <?php echo($_SESSION['usuarioNome'])?> <span class="caret"></span></a>
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
                <li class="active"><a href="Dash.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg>Inicio</a></li>
                <!--<li role="presentation" class="divider"></li> -->
                <li class="active"><a href="Aniversariantes.php"><svg class="glyph stroked address-book"><use xlink:href="#landed-address-book"></use></svg>Aniversariantes</a></li>
                <!--<li role="presentation" class="divider"></li> -->
                <li class="active"><a href="Aniversariantes.php"><svg class="glyph stroked address-book"><use xlink:href="#landed-address-book"></use></svg>Rel. Aniversariantes</a></li>
                <!-- <li role="presentation" class="divider"></li> -->
                <li><a href="login.html"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Login Page</a></li>
            </ul>
        </div><!--/.sidebar-->

        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
            <div class="row">
                <ol class="breadcrumb">
                    <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
                    <li class="active">Dashboard</li>
                </ol>
            </div><!--/.row-->

            <!-- Cabeçalho da Listagem -->
                    <legend><h1>Listagem de Clientes</h1></legend>

            
            <div class="row">
		<?php foreach ($dash as $dashs): ?>	
                <div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-blue panel-widget ">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<svg class="glyph stroked bag"><use xlink:href="#stroked-bag"></use></svg>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large"> <?= $dashs->cli_vistot?> </div>
							<div class="text-muted">vistas</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-orange panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<svg class="glyph stroked empty-message"><use xlink:href="#stroked-empty-message"></use></svg>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large">52</div>
							<div class="text-muted">Comments</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-teal panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large">24</div>
							<div class="text-muted">Clientes</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-md-6 col-lg-3">
				<div class="panel panel-red panel-widget">
					<div class="row no-padding">
						<div class="col-sm-3 col-lg-5 widget-left">
							<svg class="glyph stroked app-window-with-content"><use xlink:href="#stroked-app-window-with-content"></use></svg>
						</div>
						<div class="col-sm-9 col-lg-7 widget-right">
							<div class="large">25.2k</div>
							<div class="text-muted">Page Views</div>
						</div>
					</div>
				</div>
			</div>
	<?php endforeach; ?>	
            </div><!--/.row-->
            
            
            
            
            
            <div class='container'>
                <fieldset>
                    <!-- Formulário de Pesquisa -->
                    <form action="" method="get" id='form-contato' class="form-horizontal col-md-10">
                        <label class="col-md-2 control-label" for="termo">Pesquisar</label>
                        <div class='col-xs-4'>
                            <input type="text" class="form-control" id="termo" name="termo" placeholder="Infome o Nome ou E-mail">
                        </div>
                        <button type="submit" class="btn btn-primary">Pesquisar</button>
                        <a href='Cadastro_clientes.php' class="btn btn-success pull-right ">Cadastrar Cliente</a>
                        <a href='Dash.php' class="btn btn-primary">Ver Todos</a>
                        <a href='Pontuacao.php' class="btn btn-warning">Pontuar</a>
                        <!-- Link para página de cadastro -->
                        
                    </form>

                   
                    
                    <div class='clearfix'></div>

                    <?php if (!empty($clientes)): ?>

                        <!-- Tabela de Clientes -->
                        <table class="table table-striped">
                            <tr class='active'>
                                <th>Foto</th>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>Celular</th>
                                <th>Status</th>
                                <th>Ação</th>
                            </tr>
                            <?php foreach ($clientes as $cliente): ?>
                                <tr>
                                    <td><img src='fotos/<?= $cliente->cli_foto ?>' height='40' width='40'></td>
                                    <td><?= $cliente->cli_nome ?></td>
                                    <td><?= $cliente->cli_email ?></td>
                                    <td><?= $cliente->cli_telefone ?></td>
                                    <td><?= $cliente->cli_status ?></td>
                                    <td>
                                        <a href='Editar_clientes.php?id=<?= $cliente->cli_codigo ?>' class="btn btn-primary">Editar</a>
                                        <a href='javascript:void(0)' class="btn btn-danger link_exclusao" rel="<?= $cliente->cli_codigo ?>">Excluir</a>
                                    </td>
                                </tr>	
                            <?php endforeach; ?>
                        </table>

                    <?php else: ?>

                        <!-- Mensagem caso não exista clientes ou não encontrado  -->
                        <h3 class="text-center text-primary">Não existem clientes cadastrados!</h3>
                    <?php endif; ?>
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