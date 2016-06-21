<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
 
<body>
 
<?php
 
/*
Supondo que o arquivo esteja dentro do
diretório raíz e sub-diretório phpmailer/
*/
require "phpmailer/class.phpmailer.php"; 
 
// conteúdo da mensagem
$mensagem = "Testando o envio de email através de aplicações locais";
 
// Estrutura HTML da mensagem
$msg = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">";
$msg .= "<html>";
$msg .= "<head></head>";
$msg .= "<body style=\"background-color:#fff;\" >";
$msg .= "<strong>MENSAGEM:</strong><br /><br />";
$msg .= $mensagem;
$msg .= "</body>";
$msg .= "</html>";
 
// Abaixo começaremos a utilizar o PHPMailer. 
 
/*
Aqui criamos uma nova instância da classe como $mail.
Todas as características, funções e métodos da classe
poderão ser acessados através da variável (objeto) $mail.
*/
$mail = new PHPMailer(); // 
 
// Define o método de envio
$mail->Mailer     = "smtp";
 
// Define que a mensagem poderá ter formatação HTML
$mail->IsHTML(true); //
 
// Define que a codificação do conteúdo da mensagem será utf-8
$mail->CharSet    = "utf-8";
 
// Define que os emails enviadas utilizarão SMTP Seguro tls
$mail->SMTPSecure = "tls";
//$mail->SMTPSecure = "ssl"; // SSL REQUERIDO pelo GMail
 
// Define que o Host que enviará a mensagem é o Gmail
$mail->Host       = "smtp.gmail.com";
 
//Define a porta utilizada pelo Gmail para o envio autenticado
$mail->Port       = "587";                   
//$mail->Port       = "465";   //REQUERIDO pelo GMail
 
// Deine que a mensagem utiliza método de envio autenticado
$mail->SMTPAuth   = "true";
 
// Define o usuário do gmail autenticado responsável pelo envio
$mail->Username   = "luciano.bnz06@gmail.com";
 
// Define a senha deste usuário citado acima
$mail->Password   = "";
 
// Defina o email e o nome que aparecerá como remetente no cabeçalho
$mail->From       = "luciano.bnz06@gmail.com";
$mail->FromName   = "Luciano Silva";
 
// Define o destinatário que receberá a mensagem
$mail->AddAddress("eduardosalesyou@gmail.com");
 
/*
Define o email que receberá resposta desta
mensagem, quando o destinatário responder
*/
$mail->AddReplyTo("luciano.bnz06@gmail.com", $mail->FromName);
 
// Assunto da mensagem
$mail->Subject    = "Teste de envio";
 
// Toda a estrutura HTML e corpo da mensagem
$mail->Body       = $msg;
 
// Controle de erro ou sucesso no envio
if (!$mail->Send())
{
 
    echo "Erro de envio: " . $mail->ErrorInfo;
 
}
else{
 
    echo "Mensagem enviada com sucesso!";
 
}
 
?>
 
</body>
</html>