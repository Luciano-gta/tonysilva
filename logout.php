<?php
//unset($_SESSION['usuarioID'], $_SESSION['usuarioNome'], $_SESSION['usuarioLogin'], $_SESSION['usuarioSenha']);
// primeiro destruímos os dados associados à sessão
  $_SESSION = array();

  // destruímos então o cookie relacionado a esta sessão
  if(isset($_COOKIE[session_name()])){
    setcookie(session_name(), '', time() - 1000, '/');
  }
  
  // finalmente destruimos a sessão
  session_destroy();
    // Manda pra tela de login
  //header("Location: " .$_SERVER['DOCUMENT_ROOT']);
    header('Location: login.php'); 
?>



