<!DOCTYPE html>
<html>
    <head>
        <?php
        // Inclui o arquivo com o sistema de seguran�a
        require_once('./classes/Conexao.php');
        require_once('dao/seguranca.php');
        protegePagina();
// Recebe o id do cliente do cliente via GET
        $id_cliente = (isset($_GET['id'])) ? $_GET['id'] : '';

// Valida se existe um id e se ele é numérico
        if (!empty($id_cliente) && is_numeric($id_cliente)):

            // Captura os dados do cliente solicitado
            $conexao = conexao::getInstance();
            $sql = 'SELECT cli_codigo, cli_nome, cli_email, cli_cpf, cli_data_nascimento, cli_telefone, cli_celular, cli_status, cli_foto,cli_endereco,cli_cidade, cli_uf, cli_cep, cli_codcard FROM clientes WHERE cli_codigo = :id';
            $stm = $conexao->prepare($sql);
            $stm->bindValue(':id', $id_cliente);
            $stm->execute();
            $cliente = $stm->fetch(PDO::FETCH_OBJ);

            if (!empty($cliente)):

                // Formata a data no formato nacional
                $array_data = explode('-', $cliente->cli_data_nascimento);
                $data_formatada = $array_data[2] . '/' . $array_data[1] . '/' . $array_data[0];

            endif;

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
                <li><a href="login.html"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Login Page</a></li>
            </ul>
        </div><!--/.sidebar-->

        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
            <div class="row">
                <ol class="breadcrumb">
                    <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
                    <li class="active">Edição de Cliente</li>
                </ol>
            </div><!--/.row-->

            <div class='container'>
                <fieldset>
                    <legend><h1>Formulário - Edição de Cliente</h1></legend>

                    <?php if (empty($cliente)): ?>
                        <h3 class="text-center text-danger">Cliente não encontrado!</h3>
                    <?php else: ?>
                        <form action="action_cliente.php" method="post" id='form-contato' enctype='multipart/form-data'>
                            <div class="row">
                                <label for="nome">Alterar Foto</label>
                                <div class="col-md-2">
                                    <a href="#" class="thumbnail">
                                        <img src="fotos/<?= $cliente->cli_foto ?>" height="190" width="150" id="foto-cliente">
                                    </a>
                                </div>
                                <input type="file" name="foto" id="foto" value="foto" >
                            </div>

                            <div class="form-group">
                                <label for="nome">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" value="<?= $cliente->cli_nome ?>" placeholder="Infome o Nome">
                                <span class='msg-erro msg-nome'></span>
                            </div>

                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= $cliente->cli_email ?>" placeholder="Informe o E-mail">
                                <span class='msg-erro msg-email'></span>
                            </div>


                            <div class="form-group">
                                <label for="cod_card">Cod. Cartão</label>
                                <input type="text" class="form-control" id="cod_cart" name="cod_cart"   value="<?= $cliente->cli_codcard ?>" placeholder="Informe o codigo do cartão">
                                <!-- para validacao <span class='msg-erro msg-email'></span> -->
                            </div>


                            <div class="form-group">
                                <label for="cpf">CPF</label>
                                <input type="cpf" class="form-control" id="cpf" maxlength="14" name="cpf" value="<?= $cliente->cli_cpf ?>" placeholder="Informe o CPF">
                                <span class='msg-erro msg-cpf'></span>
                            </div>
                            <div class="form-group">
                                <label for="data_nascimento">Data de Nascimento</label>
                                <input type="data_nascimento" class="form-control" id="data_nascimento" maxlength="10" value="<?= $data_formatada ?>" name="data_nascimento">
                                <span class='msg-erro msg-data'></span>
                            </div>
                            <div class="form-group">
                                <label for="telefone">Telefone</label>
                                <input type="telefone" class="form-control" id="telefone" maxlength="12" name="telefone" value="<?= $cliente->cli_telefone ?>" placeholder="Informe o Telefone">
                                <span class='msg-erro msg-telefone'></span>
                            </div>
                            <div class="form-group">
                                <label for="celular">Celular</label>
                                <input type="celular" class="form-control" id="celular" maxlength="13" name="celular" value="<?= $cliente->cli_celular ?>" placeholder="Informe o Celular">
                                <span class='msg-erro msg-celular'></span>
                            </div>

                            <div class="row">
                                <div class="col-md-2"> 
                                    <label for="cep">CEP</label>
                                    <input type="cep" class="form-control" id="cep" name="cep" value="<?= $cliente->cli_cep ?>" placeholder="Informe o CEP">
                                    <!-- para validacao <span class='msg-erro msg-email'></span> -->
                                </div>
                                <div class="col-md-1">
                                    <label for="uf">UF</label>
                                    <input type="text" class="form-control" id="uf" name="uf" value="<?= $cliente->cli_uf?>" placeholder="UF">
                                    <!-- para validacao <span class='msg-erro msg-email'></span> -->
                                </div>
                                <div class="col-md-3">
                                    <label for="cidade">Cidade</label>
                                    <input type="text" class="form-control" id="cidade" name="cidade" value="<?= $cliente->cli_cidade ?>" placeholder="Cidade">
                                    <!-- para validacao <span class='msg-erro msg-email'></span> -->
                                </div>

                                <div class="col-md-6">
                                    <label for="endereco">Endereço</label>
                                    <input type="text" class="form-control" id="endereco" name="endereco" value="<?= $cliente->cli_endereco ?>" placeholder="Informe Rua, Nºcasa/APTO">
                                    <!-- para validacao <span class='msg-erro msg-email'></span> -->
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="<?= $cliente->cli_status ?>"><?= $cliente->cli_status ?></option>
                                    <option value="Ativo">Ativo</option>
                                    <option value="Inativo">Inativo</option>
                                </select>
                                <span class='msg-erro msg-status'></span>
                            </div>

                            <input type="hidden" name="acao" value="editar">
                            <input type="hidden" name="id" value="<?= $cliente->cli_codigo ?>">
                            <input type="hidden" name="foto_atual" value="<?= $cliente->cli_foto ?>">
                            <button type="submit" class="btn btn-primary" id='botao'> 
                                Gravar
                            </button>
                            <a href='Dash.php' class="btn btn-danger">Cancelar</a>
                        </form>
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