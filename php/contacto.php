<?php
/**
 * @version 1.0
 */

require("class.phpmailer.php");
require("class.smtp.php");

// Valores enviados desde el formulario
if ( !isset($_POST["name"]) || !isset($_POST["email"]) || !isset($_POST["message"]) || !isset($_POST["subject"]) ) {
    die ("Es necesario completar todos los datos del formulario");
}


$nombre = $_POST["name"];
$email = $_POST["email"];
$asunto = $_POST["subject"];
$mensaje = $_POST["message"];



include("../../config/config.php");
$mail->smtpHost = $host_mail; //host
$mail->smtpUsuario = $user_mail; //nombre usuario
$mail->$smtpClave = $pass_mail; //contraseña
$mail->$emailDestino = $destino_mail; //mail destino


$mail = new PHPMailer(true);
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //seguridad
$mail->SMTPAuth = true;
$mail->IsSMTP();
$mail->Port = 465; 
$mail->IsHTML(true); 
$mail->CharSet = "utf-8";


// VALORES A MODIFICAR //
$mail->Host = $smtpHost; 
$mail->Username = $smtpUsuario; 
$mail->Password = $smtpClave;

$mail->From = $email; // Email desde donde envío el correo.
$mail->FromName = $nombre;
$mail->AddAddress($emailDestino); // Esta es la dirección a donde enviamos los datos del formulario

$mail->Subject = $asunto; // Este es el titulo del email.
$mensajeHtml = nl2br($mensaje);
$mail->Body = $mensajeHtml; // Texto del email en formato HTML

// FIN - VALORES A MODIFICAR //

$estadoEnvio = $mail->Send(); 
if($estadoEnvio){
    header ('Location: ../../index.html');
    echo "<h4>El correo fue enviado correctamente!</h4>";
} else {
    header ('Location: ../../index.html');
    echo "<h4>Ocurrió un error inesperado!</h4>";
}
