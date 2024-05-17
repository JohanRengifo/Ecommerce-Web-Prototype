<?php
include_once 'contenido/cabeza.php';
?>
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

<!-- Contact Section Begin -->
<section class="contact spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="contact__content">
                    <div class="contact__address">
                        <h5>Información de Contacto</h5>
                        <ul>
                            <li>
                                <h6><i class="fa fa-map-marker"></i> Dirección</h6>
                                <p>Popayán, Cauca - Colombia 🇨🇴</p>
                            </li>
                            <li>
                                <h6><i class="fa fa-phone"></i> Teléfonos</h6>
                                <p><span>3137671705</span></p>
                            </li>
                            <li>
                                <h6><i class="fa fa-headphones"></i> Email de Soporte</h6>
                                <p>soporte@desarrollodigital-jr.online</p>
                            </li>
                        </ul>
                    </div>
                    <div class="contact__form">
                        <h5>Enviar Mensaje</h5>
                        <form method="post" action="enviar_mensaje.php">
                            <input type="text" name="name" placeholder="Nombre">
                            <input type="email" name="email" placeholder="Email">
                            <input type="text" name="asunto" placeholder="Asunto">
                            <textarea name="message" placeholder="Mensaje"></textarea>
                            <button type="submit" class="site-btn">Enviar Mensaje</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="contact__map">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63778.38371262806!2d-76.64113404587204!3d2.4574700699403293!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e300311c028d47d%3A0x880bd67f0987a54e!2zUG9wYXnDoW4sIENhdWNh!5e0!3m2!1ses-419!2sco!4v1684821351439!5m2!1ses-419!2sco" height="780" style="border:0" allowfullscreen=""></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact Section End -->

<?php
include_once 'contenido/pie.php';
?>
