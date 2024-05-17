<?php include_once 'contenido/cabeza.php'; ?>
<title><?php echo $pagecontact; ?></title>

<!-- Breadcrumb Begin -->
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="./index.html"><i class="fa fa-home"></i> Home</a>
                    <span>Contact</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Success Message Begin -->
<section class="contact spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="contact__success">
                    <h2>Mensaje enviado con éxito</h2>
                    <p>Gracias por contactarnos. Hemos recibido tu mensaje y te responderemos lo antes posible.</p>
                    <script>setTimeout(function() { window.location.href = "contactenos.php"; }, 5000);</script>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Success Message End -->

<?php include_once 'contenido/pie.php'; ?>
