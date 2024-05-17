<?php
include_once 'contenido/cabeza.php';

// Función para procesar el formulario de solicitud o PQR
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $mensaje = $_POST['mensaje'];
    // Ejemplo de mensaje de confirmación
    $confirmacion = "Gracias por enviar tu solicitud. Nos pondremos en contacto contigo pronto.";
    // header('Location: index.php');
}
?>

<title>Sobre Nosotros | Egocentricas Pop</title>

<!-- Breadcrumb Begin -->
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="./index.php"><i class="fa fa-home"></i> Home</a>
                    <span>About</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- About Section Begin -->
<section class="contact spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="contact__form">
                    <h5>Enviar solicitud o PQR</h5>
                    <?php if (isset($confirmacion)) : ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $confirmacion; ?>
                        </div>
                    <?php else : ?>
                        <form action="" method="POST">
                            <input type="text" name="nombre" placeholder="Nombre" required>
                            <input type="email" name="correo" placeholder="Correo electrónico" required>
                            <textarea name="mensaje" placeholder="Mensaje" required></textarea>
                            <button type="submit" class="site-btn">Enviar</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About Section End -->

<?php include_once 'contenido/pie.php'; ?>
