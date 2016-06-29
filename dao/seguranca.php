<?php

/**
 * Sistema de segurança com acesso restrito
 *
 * Usado para restringir o acesso de certas páginas do  site
 *
 */
$pasta = dirname(__FILE__);

// Teste
//require_once($pasta."/db.inc.php");
//Classes
require_once($pasta . "/../classes/conexao.php");

//  Configurações do Script
// ==============================
$_SG['conectaServidor'] = true;    // Abre uma conexão com o servidor MySQL?
$_SG['abreSessao'] = true;         // Inicia a sessão com um session_start()?
$_SG['caseSensitive'] = false;     // Usar case-sensitive? Onde 'thiago' é diferente de 'THIAGO'
$_SG['validaSempre'] = true;       // Deseja validar o usuário e a senha a cada carregamento de página?
// Evita que, ao mudar os dados do usuário no banco de dado o mesmo contiue logado.
$_SG['paginaLogin'] = 'login.php'; // Página de login
$_SG['tabela'] = 'usuarios';       // Nome da tabela onde os usuários são salvos
// ==============================
// ======================================
//   ~ Não edite a partir deste ponto ~
// ======================================
if(session_status()== PHP_SESSION_NONE  ){
    session_start();
}
/**
 * Função que valida um usuário e senha
 *
 * @param string $usuario - O usuário a ser validado
 * @param string $senha - A senha a ser validada
 *
 * @return bool - Se o usuário foi validado ou não (true/false)
 */
function validaUsuario($usuario, $senha) {
    
    $conexao = conexao::getInstance();
    global $_SG;
    $cS = ($_SG['caseSensitive']) ? 'BINARY' : '';
    // Usa a função addslashes para escapar as aspas
    $nusuario = addslashes($usuario);
    $nsenha = addslashes($senha);
    $sql = "SELECT usu_id, usu_nome FROM " . $_SG['tabela'] . " WHERE " . $cS . " usu_email = '" . $nusuario . "' AND " . $cS . " usu_senha = '" . $nsenha . "' LIMIT 1";
    $stm = $conexao->prepare($sql);
    $stm->execute();
    $resultado = $stm->fetchAll(PDO::FETCH_OBJ);

// Verifica se encontrou algum registro
    if (empty($resultado)) {
        // Nenhum registro foi encontrado => o usuário é inválido
        return false;
    } else {
        // Definimos dois valores na sessão com os dados do usuário
        foreach ($resultado as $user){
        $_SESSION['usuarioID'] = $user->usu_id; // Pega o valor da coluna 'id do registro encontrado no MySQL
        $_SESSION['usuarioNome'] = $user->usu_nome; // Pega o valor da coluna 'nome' do registro encontrado no MySQL
        }
// Verifica a opção se sempre validar o login
        if ($_SG['validaSempre'] == true) {
            // Definimos dois valores na sessão com os dados do login
            $_SESSION['usuarioLogin'] = $usuario;
            $_SESSION['usuarioSenha'] = $senha;
            // Verifica se precisa iniciar a sessão
        }
        return true;
    }
}

/**
 * Função que protege uma página
 */
function protegePagina() {
    global $_SG;
    if (!isset($_SESSION['usuarioID']) OR ! isset($_SESSION['usuarioNome'])) {
        // Não há usuário logado, manda pra página de login
        expulsaVisitante();
    } else {
        // Há usuário logado, verifica se precisa validar o login novamente
        if ($_SG['validaSempre'] == true) {
            // Verifica se os dados salvos na sessão batem com os dados do banco de dados
            if (!validaUsuario($_SESSION['usuarioLogin'], $_SESSION['usuarioSenha'])) {
                // Os dados não batem, manda pra tela de login
               expulsaVisitante();
            }
        }
    }
}

/**
 * Função para expulsar um visitante
 */
function expulsaVisitante() {
    global $_SG;
    // Remove as variáveis da sessão (caso elas existam)
    unset($_SESSION['usuarioID'], $_SESSION['usuarioNome'], $_SESSION['usuarioLogin'], $_SESSION['usuarioSenha']);
    // Manda pra tela de login
    //header("Location: " .$_SERVER['DOCUMENT_ROOT']);
    header('Location: login.php');
}
