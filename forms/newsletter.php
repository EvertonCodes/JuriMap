<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Ajuste conforme o local do arquivo

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Endereço de e-mail inválido.');
    }

    // Configuração SMTP - substitua com suas informações
    $smtp_host = 'smtp.gmail.com';
    $smtp_username = 'evertonCoddes@gmail.com';
    $smtp_password = 'peaf ujmn qhal ofbw';   // Coloque sua senha de app aqui
    $smtp_port = 587;

    $to = 'evertonCoddes@gmail.com'; // E-mail que vai receber as inscrições
    $subject = 'Nova inscrição de newsletter';
    $message = "Novo inscrito: $email";

    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor
        $mail->isSMTP();
        $mail->Host       = $smtp_host;
        $mail->SMTPAuth   = true;
        $mail->Username   = $smtp_username;
        $mail->Password   = $smtp_password;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $smtp_port;

        // Remetente e destinatário
        $mail->setFrom($smtp_username, 'Jurimap');
        $mail->addAddress($to);

        // Conteúdo do e-mail
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
        echo 'OK'; // Esta resposta será capturada pelo JavaScript para exibir a mensagem de sucesso
    } catch (Exception $e) {
        echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
    }
} else {
    echo 'Método de requisição inválido.';
}
?>