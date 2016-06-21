<?php
unset($_SESSION['usuarioID'], $_SESSION['usuarioNome'], $_SESSION['usuarioLogin'], $_SESSION['usuarioSenha']);
  // Manda pra tela de login
  //header("Location: " .$_SERVER['DOCUMENT_ROOT']);
    header('Location: login.html'); 
?>



