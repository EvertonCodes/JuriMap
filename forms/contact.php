<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Garante que o Composer carregue o PHPMailer

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validação básica
    $name    = htmlspecialchars($_POST['name']);
    $email   = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Endereço de e-mail inválido.');
    }

    // Configurações do servidor SMTP (Gmail)
    $smtp_host     = 'smtp.gmail.com';
    $smtp_username = 'evertonCoddes@gmail.com';         // Seu e-mail
    $smtp_password = 'peaf ujmn qhal ofbw';            // Senha de app gerada
    $smtp_port     = 587;

    $to = 'evertonCoddes@gmail.com'; // Para onde será enviado o formulário

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
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = "
            <strong>Nome:</strong> $name<br>
            <strong>Email:</strong> $email<br>
            <strong>Mensagem:</strong><br>$message
        ";

        $mail->AltBody = "Nome: $name\nEmail: $email\nMensagem:\n$message";

        $mail->send();
        echo 'OK'; // Importante: essa resposta será usada pelo JS
    } catch (Exception $e) {
        echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
    }
} else {
    echo 'Método inválido.';
}
?>