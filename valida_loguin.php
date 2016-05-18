<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of valida_loguin
 *
 * @author PLANTAO
 */
session_start();
    
$usuario = $_POST['email'];
$senha   = $_POST['password'];


echo $usuario.'-'.$senha;


        
        ?>