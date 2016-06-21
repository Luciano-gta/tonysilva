<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Rel_aniversariantes
 *
 * @author eduardo.sales
 */
class Rel_aniversariantes {

    function gera(){
//TÍTULO DO RELATÓRIO 
$titulo = "Tony Silva"; 
//LOGO QUE SERÁ COLOCADO NO RELATÓRIO

$imagem = "logo_imasters.png"; 
//ENDEREÇO DA BIBLIOTECA FPDF 
$end_fpdf = "c:/pagina/biblioteca/fpdf"; 

//TIPO DO PDF GERADO 
//F-> SALVA NO ENDEREÇO ESPECIFICADO
$tipo_pdf = " ";

/**************
NÃO MEXER DAQUI PRA BAIXO ***************/
require_once("../classes/fpdf/fpdf.php"); 
require_once '../classes/conexao.php';
//CONECTA
$conexao = conexao::getInstance();
$sql = 'SELECT cli_codigo,cli_visitas as cli_vistot , cli_nome, cli_email, cli_telefone, cli_status,cli_foto FROM clientes';
$stm = $conexao->prepare($sql);
$stm->execute();
$clientes = $stm->fetchAll(PDO::FETCH_OBJ);


//PREPARA PARA GERAR O PDF
define("FPDF_FONTPATH", "$end_fpdf/font/");
$pdf = new FPDF();


//PÁGINAS

$pdf->Open(); 
$pdf->AddPage(); 
$pdf->SetFont("Arial", "B", 10);

$pdf->Image($imagem, 0, 8);
$pdf->Ln(2);
//$pdf->Cell(185, 8, "Página $x de $paginas",0, 0,'R');

//QUEBRA DE LINHA
$pdf->Ln(20);

//MONTA O CABEÇALHO 
$pdf->Cell(15, 8, "", 1, 0, 'C'); 
$pdf->Cell(85, 8, "NOME", 1, 0, 'L');
$pdf->Cell(85, 8, "ANIVERSARIO", 1, 1, 'L');

//EXIBE OS REGISTROS 
foreach ($clientes as $cliente) {
$pdf->Cell(15, 8,$cliente->cli_codigo,
1, 0, 'C'); 
$pdf->Cell(85, 8,$cliente->cli_nome,
1, 0, 'L'); 
$pdf->Cell(85, 8,$cliente->cli_data_nascimento,
1, 1, 'L'); 

}
//SAIDA DO PDF
 ob_clean(); // Limpa o buffer de saída
 $pdf->Output();
}

}
