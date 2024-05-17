<?php
echo '<title><?php echo $pagecontact; ?></title>';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validación de datos
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['message'])) {
        echo 'Por favor, completa todos los campos obligatorios.';
        exit();
    }

    $name = $_POST['name'];
    $email = $_POST['email'];
    $asunto = $_POST['asunto'];
    $message = $_POST['message'];

    // Validación del correo electrónico
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Por favor, ingresa un correo electrónico válido.';
        exit();
    }

    // Correo de destino
    $to = 'soporte@desarrollodigital-jr.online';

    // Asunto del correo
    $subject = 'Nuevo mensaje de contacto';

    // Cuerpo del correo
    $body = "Nombre: $name\n";
    $body .= "Email: $email\n";
    $body .= "Asunto: $asunto\n";
    $body .= "Mensaje: $message\n";

    // Encabezados del correo
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // Configuración de SMTP de Hostinguer
    $smtp_host = 'smtp.hostinger.com';
    $smtp_port = 465; 
    $smtp_username = 'soporte@desarrollodigital-jr.online'; 
    $smtp_password = 'JohanR89.'; 

    // Configuración adicional de SMTP
    $smtp_options = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        ]
    ];

    // Configurar el servidor SMTP
    ini_set('SMTP', $smtp_host);
    ini_set('smtp_port', $smtp_port);
    ini_set('sendmail_from', $smtp_username);
    ini_set('sendmail_path', "/usr/sbin/sendmail -t -i -f $smtp_username");

    // Enviar el correo
    if (mail($to, $subject, $body, $headers, "-f$smtp_username")) {
        // Redireccionar al usuario a una página de confirmación
        header('Location: mensaje_enviado.php');
        exit();
    } else {
        // Error al enviar el correo
        echo 'Hubo un error al enviar el mensaje. Por favor, inténtalo de nuevo.';
    }
} else {
    // Si se intenta acceder directamente a este archivo sin enviar el formulario, redireccionar al formulario de contacto
    header('Location: contactenos.php');
    exit();
}
?>
