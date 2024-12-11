<?php
/**
 * @version 1.0
 */

require("class.phpmailer.php");
require("class.smtp.php");

include("../../config/config.php");

// Valores enviados desde el formulario
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: ../../index.html?mensaje=error');
    exit;
}

if (!isset($_POST["name"]) || !isset($_POST["email"]) || !isset($_POST["message"]) || !isset($_POST["subject"])) {
     header('Location: ../../index.html?mensaje=error');
     exit;
}

$nombre = $_POST["name"];
$email = $_POST["email"];
$asunto = $_POST["subject"];
$msg = $_POST["message"];
$mensaje = "
<html>
<body>
    <h1>Mensaje desde el sitio web!</h1>
    <p>$msg</p>
</body>
</html>
";

$mail = new PHPMailer(true);

try {

    $mail->isSMTP();
    $mail->Host = $smtpHost;
    $mail->SMTPAuth = $smtpAuth;
    $mail->Username = $smtpUsuario;
    $mail->Password = $smtpClave;
    $mail->SMTPSecure = $smtpSecure;
    $mail->isHTML(true);
    $mail->Port = $smtpPort;
    $mail->XMailer = 'PHP/' . phpversion();
    $mail->CharSet = 'UTF-8';
    $mail->Encoding = 'base64';

    $mail->setFrom($email, $nombre); 
    $mail->addAddress($emailDestino, 'Desde Sitio Web');
    $mail->Subject = $asunto;


    $mail->Body = $mensaje;
    $mail->send();

    // Emitir mensaje de éxito
    echo 'exito';
} catch (Exception $e) {
    // Emitir mensaje de error
    echo 'error';
}
?>
